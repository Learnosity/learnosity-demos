/**
 * Integration tests for the profanity filter against the real Author API demo.
 *
 * These tests require a running PHP server at http://localhost:8080
 * (e.g. `php -S localhost:8080 --docroot www`).
 *
 * The Learnosity Author API loads from an external CDN. When the CDN is
 * reachable the tests exercise the real Author API initialisation path.
 * When it is not (e.g. in CI or sandboxed environments) the tests inject
 * a lightweight mock so the profanity hook still activates and can be
 * verified end-to-end on the real PHP page.
 *
 * Run with:
 *   npx playwright test tests/profanity/author-integration.spec.js \
 *       --config=playwright.integration.config.js
 */
const { test, expect } = require('@playwright/test');

const AUTHOR_URL = '/authoring/item-create.php';

/**
 * Navigate to the Author demo page and ensure the profanity filter hook
 * is active.
 *
 * Strategy:
 *  1. Quickly check whether the real Author API loaded.
 *  2. If not (CDN unreachable), inject a mock authorApp early enough for
 *     the hook's polling loop (30 s window) to pick it up.
 *  3. Wait for LrnProfanityFilter.isReady().
 *  4. Insert a Save button if one does not already exist.
 */
async function setupPage(page) {
    await page.goto(AUTHOR_URL, { waitUntil: 'domcontentloaded' });

    // Quick probe — is the real Author API likely to appear?
    // Wait 10 s first; if it hasn't appeared, inject a mock.
    const needsMock = await page.evaluate(() => {
        return new Promise((resolve) => {
            var elapsed = 0;
            var iv = setInterval(function () {
                elapsed += 200;
                if (
                    window.authorApp &&
                    typeof window.authorApp.getItem === 'function'
                ) {
                    clearInterval(iv);
                    resolve(false); // real API loaded
                }
                if (elapsed >= 10000) {
                    clearInterval(iv);
                    resolve(true); // needs mock
                }
            }, 200);
        });
    });

    if (needsMock) {
        // Inject a minimal mock *before* the hook's 30 s poll timeout
        await page.evaluate(() => {
            window._mockItemData = {
                reference: 'mock-item',
                questions: [{ stimulus: 'placeholder' }]
            };
            window.authorApp = {
                getItem: function () { return window._mockItemData; }
            };
        });
    }

    // Wait for profanity filter to become ready (hook should init it)
    await page.waitForFunction(
        () => window.LrnProfanityFilter && window.LrnProfanityFilter.isReady(),
        { timeout: 30000 }
    );

    // Ensure a Save button exists on the page for click-interception tests.
    // (The real Author API renders its own Save button inside the UI; when
    //  using a mock the UI isn't rendered so we add one.)
    await page.evaluate(() => {
        if (!document.querySelector(
            '[data-authorapi-selector="save"], [data-lrn-role="save"], ' +
            '.lrn_btn_save, .lrn-author-save-button'
        )) {
            var btn = document.createElement('button');
            btn.setAttribute('data-authorapi-selector', 'save');
            btn.textContent = 'Save';
            btn.style.cssText = 'margin:1em;padding:0.5em 1em;';
            document.body.appendChild(btn);
        }
    });
}

/**
 * Locate a Save button using the same tiered strategy as authorProfanityHook.js.
 */
function saveButtonLocator(page) {
    return page.locator([
        '[data-authorapi-selector="save"]',
        '[data-lrn-role="save"]',
        '.lrn_btn_save',
        '.lrn-author-save-button',
        'button:has-text("Save")'
    ].join(', ')).first();
}

test.describe('Author API Profanity Filter Integration', () => {

    test('profanity filter initialises on the Author API page', async ({ page }) => {
        await setupPage(page);

        const ready = await page.evaluate(() => window.LrnProfanityFilter.isReady());
        expect(ready).toBe(true);
    });

    test('blocks save when item contains profanity', async ({ page }) => {
        await setupPage(page);

        // Override getItem to return data containing profanity,
        // simulating a user who has entered profane content.
        await page.evaluate(() => {
            window.authorApp.getItem = function () {
                return {
                    reference: 'test-profanity-item',
                    questions: [{
                        type: 'mcq',
                        stimulus: 'What the fuck is the answer?',
                        options: [
                            { label: 'Option A', value: '0' },
                            { label: 'Option B', value: '1' }
                        ]
                    }]
                };
            };
        });

        // Auto-dismiss the dialog so click() can complete, then inspect
        let alertMessage = '';
        page.on('dialog', async (dialog) => {
            alertMessage = dialog.message();
            await dialog.dismiss();
        });

        await saveButtonLocator(page).click();
        await page.waitForTimeout(500);

        expect(alertMessage).toContain('profanity detected');
        expect(alertMessage).toContain('fuck');
    });

    test('allows save for clean content (no profanity alert)', async ({ page }) => {
        await setupPage(page);

        // Override getItem to return clean data
        await page.evaluate(() => {
            window.authorApp.getItem = function () {
                return {
                    reference: 'test-clean-item',
                    questions: [{
                        type: 'mcq',
                        stimulus: 'What is the capital of France?',
                        options: [
                            { label: 'Paris', value: '0' },
                            { label: 'London', value: '1' }
                        ]
                    }]
                };
            };
        });

        // Listen for alert — should not appear
        let alertFired = false;
        page.on('dialog', async (dialog) => {
            alertFired = true;
            await dialog.dismiss();
        });

        await saveButtonLocator(page).click();

        // Give enough time for any synchronous/async handlers to fire
        await page.waitForTimeout(1000);

        expect(alertFired).toBe(false);
    });

    test('detects profanity nested in item JSON', async ({ page }) => {
        await setupPage(page);

        // Override getItem to return deeply nested profanity
        await page.evaluate(() => {
            window.authorApp.getItem = function () {
                return {
                    reference: 'test-nested-profanity',
                    questions: [{
                        type: 'mcq',
                        stimulus: 'Pick the best answer',
                        options: [
                            { label: 'Correct answer', value: '0' },
                            { label: 'This option is bullshit', value: '1' },
                            { label: 'Another option', value: '2' }
                        ]
                    }]
                };
            };
        });

        let alertMessage = '';
        page.on('dialog', async (dialog) => {
            alertMessage = dialog.message();
            await dialog.dismiss();
        });

        await saveButtonLocator(page).click();
        await page.waitForTimeout(500);

        expect(alertMessage).toContain('profanity detected');
        expect(alertMessage).toContain('bullshit');
    });

    test('detects Spanish profanity when es locale is configured', async ({ page }) => {
        await setupPage(page);

        // The header sets data-profanity-locales="en,es", so Spanish words
        // should be loaded automatically.
        await page.evaluate(() => {
            window.authorApp.getItem = function () {
                return {
                    reference: 'test-spanish-profanity',
                    questions: [{
                        type: 'mcq',
                        stimulus: 'Esto es una mierda',
                        options: [
                            { label: 'Si', value: '0' },
                            { label: 'No', value: '1' }
                        ]
                    }]
                };
            };
        });

        let alertMessage = '';
        page.on('dialog', async (dialog) => {
            alertMessage = dialog.message();
            await dialog.dismiss();
        });

        await saveButtonLocator(page).click();
        await page.waitForTimeout(500);

        expect(alertMessage).toContain('profanity detected');
        expect(alertMessage).toContain('mierda');
    });
});
