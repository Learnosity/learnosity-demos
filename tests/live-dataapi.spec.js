// OPT-IN live end-to-end test for the Data API demo submit (LRN-52745).
//
// Unlike ajax-callbacks.spec.js (which stubs xhr.php via route interception), this test lets
// the real request flow through: the browser submits the Data API demo form, dataApiRequest.js
// POSTs to the local xhr.php proxy, which signs the request with the shipped demo consumer
// credentials and calls the real https://data.learnosity.com endpoint. On success the jqXHR
// .done() handler renders the response — so this exercises the .success()->.done() migration
// end-to-end against the live API, which is the flow Copilot flagged as needing manual QA.
//
// It is OPT-IN because it depends on external network + a live third-party service, which must
// not break the offline core suite. Enable with:
//     RUN_LIVE=1 npx playwright test live-dataapi.spec.js
// Without RUN_LIVE the whole file is skipped. Even when enabled, it skips gracefully (rather
// than failing) if the Data API can't be reached, so a network blip is not a red build.
//
// Scope: only the Data API submit is automatable reliably. The reports-click-events and
// asset-upload modals require clicking inside live cross-origin Learnosity iframes with
// pre-existing session/report data; those remain manual QA (see the PR description).

const { test, expect } = require('@playwright/test');

const DATA_PAGE = '/analytics/data/index.php';
const LIVE_ENABLED = process.env.RUN_LIVE === '1';

test.describe('LRN-52745 live Data API submit (opt-in)', () => {
    test.skip(!LIVE_ENABLED, 'Set RUN_LIVE=1 to run live-API tests (needs external network).');

    // Live third-party round-trips are slower than local DOM checks.
    test.setTimeout(60 * 1000);

    test('Data API demo form submit renders a real API response via .done()', async ({ page, baseURL }) => {
        // Preflight: confirm the Data API proxy actually returns data with the shipped demo
        // credentials from this environment. If it doesn't (offline, credentials rotated,
        // region blocked), skip rather than fail — this test guards our code, not the network.
        const preflight = await page.request.post(`${baseURL}/analytics/data/xhr.php`, {
            form: {
                request: JSON.stringify({ limit: 1 }),
                endpoint: 'https://data.learnosity.com/v2026.2.LTS/itembank/activities',
                action: 'get',
            },
        });
        let reachable = false;
        try {
            const json = JSON.parse(await preflight.text());
            reachable = json && json.meta && json.meta.status === true;
        } catch (_) {
            reachable = false;
        }
        test.skip(!reachable, 'Data API not reachable / demo credentials not usable here.');

        // Fail the test on any uncaught JS error - a jQuery 3 regression in this flow would
        // surface as e.g. "TypeError: ....success is not a function".
        const pageErrors = [];
        page.on('pageerror', (e) => pageErrors.push(e.message));

        await page.goto(DATA_PAGE);
        await page.waitForFunction(() => typeof window.jQuery === 'function' && !!window.jQuery.fn, null, {
            timeout: 10000,
        });

        // Open the activities accordion and submit its real Data API demo form.
        await page.click('a[href="#activities"]');
        await expect(page.locator('#activities')).toHaveClass(/\bin\b/);
        await page.evaluate(() => window.jQuery('#frm-data-api-activities').trigger('submit'));

        // The .done() handler pretty-prints the live response into #response-activities and
        // activates the Response tab. Wait for the real round-trip to populate it.
        await expect(page.locator('#response-activities')).toContainText('"status": true', {
            timeout: 20000,
        });
        await expect(page.locator('#tab-response-activities')).toHaveClass(/\bactive\b/);

        // The migrated callback path must not have thrown.
        expect(pageErrors, `unexpected page errors: ${pageErrors.join('; ')}`).toEqual([]);
    });
});
