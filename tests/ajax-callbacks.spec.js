// Regression tests for the jQuery 3 jqXHR callback migration (LRN-52745).
//
// jQuery 3.0 REMOVED the deprecated jqXHR .success(), .error() and .complete() methods.
// Two callers in this app used them and would throw "TypeError: ....error is not a function"
// once jQuery was upgraded to 3.7.1:
//   - www/static/js/dataapi/dataApiRequest.js  (Data API demo form submit)
//   - www/usecases/feedback/simple-scoring/feedback.php  (teacher scoring submit)
// They were migrated to .fail()/.done(). These tests lock that migration in.
//
// The real ajax targets (xhr.php) proxy to the live Learnosity Data API and need valid
// consumer credentials, so we intercept the requests with page.route() and return stub
// responses. That lets us exercise the real .done()/.fail() handlers without the live API.

const { test, expect } = require('@playwright/test');

const DATA_PAGE = '/analytics/data/index.php';

async function waitForJQuery(page) {
    await page.waitForFunction(() => typeof window.jQuery === 'function' && !!window.jQuery.fn, null, {
        timeout: 10000,
    });
}

test.describe('LRN-52745 jqXHR callback migration', () => {
    test('jqXHR exposes .done/.fail and NOT the removed .success/.error (jQuery 3)', async ({ page }) => {
        await page.goto(DATA_PAGE);
        await waitForJQuery(page);

        // Intercept so the probe request doesn't actually hit the Data API proxy.
        await page.route('**/xhr.php', (route) =>
            route.fulfill({ status: 200, contentType: 'application/json', body: '{}' })
        );

        const shape = await page.evaluate(() => {
            const jqXHR = window.jQuery.ajax({ url: 'xhr.php', method: 'POST', data: {} });
            const result = {
                hasDone: typeof jqXHR.done === 'function',
                hasFail: typeof jqXHR.fail === 'function',
                // These were removed in jQuery 3 - must be undefined now.
                hasSuccess: typeof jqXHR.success,
                hasError: typeof jqXHR.error,
            };
            // Swallow the settled promise so it doesn't surface as an unhandled rejection.
            jqXHR.done(function () {}).fail(function () {});
            return result;
        });

        expect(shape.hasDone).toBe(true);
        expect(shape.hasFail).toBe(true);
        expect(shape.hasSuccess).toBe('undefined');
        expect(shape.hasError).toBe('undefined');
    });

    test('Data API form submit runs the .done() handler and renders the response', async ({ page }) => {
        // Stub the cross-domain proxy with a recognisable payload.
        const stubBody = JSON.stringify({ meta: { status: true }, data: [{ demo: 'done-path' }] });
        await page.route('**/xhr.php', (route) =>
            route.fulfill({ status: 200, contentType: 'application/json', body: stubBody })
        );

        await page.goto(DATA_PAGE);
        await waitForJQuery(page);

        // The activities panel is a collapsed accordion; open it so its form is interactable.
        await page.click('a[href="#activities"]');
        await expect(page.locator('#activities')).toHaveClass(/\bin\b/);

        // Submit the real Data API demo form. dataApiRequest.js intercepts submit, POSTs to
        // xhr.php, and on .done() renders the response into #response-activities and shows the
        // Response tab. Trigger submit via jQuery so it works regardless of button visibility.
        await page.evaluate(() => window.jQuery('#frm-data-api-activities').trigger('submit'));

        // The .done() handler renders the (pretty-printed) response JSON into this element.
        const responseText = page.locator('#response-activities');
        await expect(responseText).toContainText('done-path');

        // .done() also activates the Response tab pane.
        await expect(page.locator('#tab-response-activities')).toHaveClass(/\bactive\b/);
    });

    test('Data API form submit runs the .fail() handler on an error response', async ({ page }) => {
        // Route the proxy to a server error with a recognisable body; .fail() renders
        // xhr.responseText into the response area.
        await page.route('**/xhr.php', (route) =>
            route.fulfill({ status: 500, contentType: 'text/plain', body: 'FAIL_PATH_ERROR' })
        );

        await page.goto(DATA_PAGE);
        await waitForJQuery(page);

        await page.click('a[href="#activities"]');
        await expect(page.locator('#activities')).toHaveClass(/\bin\b/);

        await page.evaluate(() => window.jQuery('#frm-data-api-activities').trigger('submit'));

        // The .fail() handler passes xhr.responseText through renderResponse().
        await expect(page.locator('#response-activities')).toContainText('FAIL_PATH_ERROR');
    });

    test('the feedback-style $.ajax().fail().done() chain fires .done() under jQuery 3', async ({ page }) => {
        // The teacher-scoring page (feedback.php) builds its scoring inputs from the live
        // Reports API, so its saveScores() button cannot run offline. Instead we replay the
        // exact ajax chain shape that page uses and assert the .done() callback fires - which
        // is precisely what the .success()->.done() migration fixed.
        await page.goto(DATA_PAGE);
        await waitForJQuery(page);

        await page.route('**/xhr.php', (route) =>
            route.fulfill({ status: 200, contentType: 'application/json', body: '{"ok":true}' })
        );

        const outcome = await page.evaluate(() => {
            return new Promise((resolve) => {
                let failed = false;
                window
                    .jQuery.ajax({
                        url: 'xhr.php',
                        data: { request: '{}', endpoint: 'x', action: 'update' },
                        dataType: 'json',
                        type: 'POST',
                    })
                    .fail(function () {
                        failed = true;
                        resolve({ done: false, failed: failed });
                    })
                    .done(function (data) {
                        resolve({ done: true, failed: failed, ok: data && data.ok });
                    });
            });
        });

        expect(outcome.done).toBe(true);
        expect(outcome.failed).toBe(false);
        expect(outcome.ok).toBe(true);
    });
});
