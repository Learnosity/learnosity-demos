/**
 * Playwright tests for the profanity filter and Author API hook.
 *
 * These tests exercise the filter against the test-harness.html mock page
 * and do not require a running PHP server, Learnosity API credentials,
 * or any external services.
 *
 * Run with:
 *   npx playwright test tests/profanity/profanity.spec.js
 */
const { test, expect } = require('@playwright/test');

const HARNESS_URL = '/tests/profanity/test-harness.html';

/**
 * Helper: wait until the profanity filter reports ready.
 */
async function waitForFilterReady(page) {
    await page.waitForFunction(() =>
        window.LrnProfanityFilter && window.LrnProfanityFilter.isReady(),
        { timeout: 10000 }
    );
}

/* ------------------------------------------------------------------ */
/*  profanityFilter.js unit-level tests                                */
/* ------------------------------------------------------------------ */

test.describe('LrnProfanityFilter', () => {

    test('isReady() returns true after init()', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);
        const ready = await page.evaluate(() => window.LrnProfanityFilter.isReady());
        expect(ready).toBe(true);
    });

    test('containsProfanity() detects a bad word', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);
        const result = await page.evaluate(() =>
            window.LrnProfanityFilter.containsProfanity('This is some shit content')
        );
        expect(result).toBe(true);
    });

    test('containsProfanity() returns false for clean text', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);
        const result = await page.evaluate(() =>
            window.LrnProfanityFilter.containsProfanity('This is perfectly clean content')
        );
        expect(result).toBe(false);
    });

    test('containsProfanity() detects profanity hidden in HTML tags', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);
        const result = await page.evaluate(() =>
            window.LrnProfanityFilter.containsProfanity('<b>damn</b> this is bad')
        );
        expect(result).toBe(true);
    });

    test('containsProfanity() detects multi-word phrases', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);
        const result = await page.evaluate(() =>
            window.LrnProfanityFilter.containsProfanity('You are a son of a bitch')
        );
        expect(result).toBe(true);
    });

    test('containsProfanity() is case-insensitive', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);
        const result = await page.evaluate(() =>
            window.LrnProfanityFilter.containsProfanity('This is SHIT')
        );
        expect(result).toBe(true);
    });

    test('getMatches() returns the detected words', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);
        const matches = await page.evaluate(() =>
            window.LrnProfanityFilter.getMatches('What the fuck is this shit')
        );
        expect(matches).toContain('fuck');
        expect(matches).toContain('shit');
    });

    test('allowlist prevents false positives', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);
        const result = await page.evaluate(() => {
            window.LrnProfanityFilter.addAllowlistWords(['damn']);
            return window.LrnProfanityFilter.containsProfanity('damn, that is good');
        });
        expect(result).toBe(false);
    });

    test('addWords() dynamically adds a new word', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);
        const result = await page.evaluate(() => {
            window.LrnProfanityFilter.addWords(['badword123']);
            return window.LrnProfanityFilter.containsProfanity('This has badword123 in it');
        });
        expect(result).toBe(true);
    });
});

/* ------------------------------------------------------------------ */
/*  authorProfanityHook.js integration tests                           */
/* ------------------------------------------------------------------ */

test.describe('Author Profanity Hook', () => {

    test('allows save for clean item content', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);

        // Set clean item data
        await page.evaluate(() => {
            window.setMockItemData({
                reference: 'clean-item',
                questions: [{ stimulus: 'What is 1 + 1?' }]
            });
        });

        // Listen for alert — should not appear
        let alertFired = false;
        page.on('dialog', async (dialog) => {
            alertFired = true;
            await dialog.dismiss();
        });

        await page.click('[data-authorapi-selector="save"]');
        // Give a moment for any async handlers
        await page.waitForTimeout(200);

        expect(alertFired).toBe(false);
    });

    test('blocks save when item contains profanity', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);

        // Set item data with profanity
        await page.evaluate(() => {
            window.setMockItemData({
                reference: 'bad-item',
                questions: [{ stimulus: 'What the fuck is this?' }]
            });
        });

        // Listen for the blocking alert
        let alertMessage = '';
        page.on('dialog', async (dialog) => {
            alertMessage = dialog.message();
            await dialog.dismiss();
        });

        await page.click('[data-authorapi-selector="save"]');
        await page.waitForTimeout(200);

        expect(alertMessage).toContain('profanity detected');
        expect(alertMessage).toContain('fuck');
    });

    test('blocks save when profanity is nested in item JSON', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);

        await page.evaluate(() => {
            window.setMockItemData({
                reference: 'nested-bad-item',
                questions: [{
                    stimulus: 'Choose the correct answer',
                    options: [
                        { label: 'Normal option', value: '0' },
                        { label: 'This is bullshit', value: '1' }
                    ]
                }]
            });
        });

        let alertMessage = '';
        page.on('dialog', async (dialog) => {
            alertMessage = dialog.message();
            await dialog.dismiss();
        });

        await page.click('[data-authorapi-selector="save"]');
        await page.waitForTimeout(200);

        expect(alertMessage).toContain('profanity detected');
        expect(alertMessage).toContain('bullshit');
    });

    test('does not activate when authorApp is absent', async ({ page }) => {
        await page.goto(HARNESS_URL);
        await waitForFilterReady(page);

        // Remove authorApp to simulate a non-Author-API page
        await page.evaluate(() => {
            window.setMockItemData({ stimulus: 'fuck' });
            delete window.authorApp;
        });

        // Re-add a save button and click it — should not be intercepted
        // since authorApp.getItem would throw
        let alertFired = false;
        page.on('dialog', async (dialog) => {
            alertFired = true;
            await dialog.dismiss();
        });

        // Restore authorApp without getItem to test the guard
        await page.evaluate(() => {
            window.authorApp = {};
        });

        await page.click('[data-authorapi-selector="save"]');
        await page.waitForTimeout(200);

        // The hook should gracefully handle this (getItem throws, save proceeds)
        expect(alertFired).toBe(false);
    });
});
