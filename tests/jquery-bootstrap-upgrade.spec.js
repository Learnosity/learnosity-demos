// Smoke test for the jQuery 1.11.3 -> 3.7.1 and Bootstrap 3.1.0 -> 3.4.1 upgrade (LRN-52745).
//
// Goal: confirm no regression in the jQuery-driven UI after the version jump. The bundled
// libraries live in www/static/dist/all.min.js and are loaded by every demo page via
// src/includes/header.php.
//
// Scope note: the pen-test remediation asked us to click through five features (asset-upload
// modal, end-to-end item preview modal, reports click-events modal, analytics tooltips, and
// the question-editor sortable). In the current app only some of those are reachable:
//   - Tooltips (analytics data page)          -> live, driven here on the real page.
//   - Asset-upload modal                      -> real page; opened via Bootstrap's API because
//                                                its only trigger is the live Author API.
//   - Reports click-events modal              -> real page; opened via Bootstrap's API because
//                                                its only trigger is a live Reports API event.
//   - End-to-end item preview / QE sortable   -> orphaned source files; no served URL renders
//                                                them, so the sortable behaviour is verified by
//                                                mounting the real fragment markup on a live page.
//
// What this really guards against is the library upgrade itself: that jQuery 3.7.1 and the
// Bootstrap 3.4.1 plugins (modal, tooltip) plus html5sortable still load and function together.

const { test, expect } = require('@playwright/test');

const JQUERY_VERSION = '3.7.1';
const BOOTSTRAP_VERSION = '3.4.1';

// Any demo page pulls in the bundle; the analytics data page is a lightweight one that also
// hosts the tooltip feature, so we reuse it as the default fixture.
const DATA_PAGE = '/analytics/data/index.php';
const ASSET_PAGE = '/authoring/dam-asset-request.php';
const REPORTS_PAGE = '/analytics/reports-click-events.php';

// Wait until the bundled jQuery has attached itself to the page.
async function waitForJQuery(page) {
    await page.waitForFunction(() => typeof window.jQuery === 'function' && !!window.jQuery.fn, null, {
        timeout: 10000,
    });
}

test.describe('LRN-52745 jQuery/Bootstrap upgrade smoke test', () => {
    test('bundle loads jQuery 3.7.1 and the Bootstrap 3.4.1 plugins', async ({ page }) => {
        await page.goto(DATA_PAGE);
        await waitForJQuery(page);

        const versions = await page.evaluate(() => {
            const $ = window.jQuery;
            return {
                jquery: $.fn.jquery,
                // Bootstrap 3 plugins expose their version on the plugin Constructor.
                modal: $.fn.modal && $.fn.modal.Constructor && $.fn.modal.Constructor.VERSION,
                tooltip: $.fn.tooltip && $.fn.tooltip.Constructor && $.fn.tooltip.Constructor.VERSION,
                collapse: $.fn.collapse && $.fn.collapse.Constructor && $.fn.collapse.Constructor.VERSION,
            };
        });

        expect(versions.jquery).toBe(JQUERY_VERSION);
        // Every Bootstrap JS plugin used by the demos must report the upgraded version.
        expect(versions.modal).toBe(BOOTSTRAP_VERSION);
        expect(versions.tooltip).toBe(BOOTSTRAP_VERSION);
        expect(versions.collapse).toBe(BOOTSTRAP_VERSION);
    });

    test('Bootstrap tooltips initialise and show on the analytics data page', async ({ page }) => {
        await page.goto(DATA_PAGE);
        await waitForJQuery(page);

        // The .glyphicon-question-sign helpers carry data-toggle="tooltip" + a title, and
        // www/analytics/data/index.php runs $('.glyphicon-question-sign').tooltip({container:'body'})
        // on ready. They sit inside collapsed accordion panels, so they're in the DOM but hidden.
        const tooltipCount = await page.locator('.glyphicon-question-sign[data-toggle="tooltip"]').count();
        expect(tooltipCount).toBeGreaterThan(0);

        // Drive the real Bootstrap tooltip plugin on the first trigger and assert it renders.
        // On show, Bootstrap 3 moves title -> data-original-title and adds aria-describedby.
        const shown = await page.evaluate(() => {
            const $ = window.jQuery;
            const $trigger = $('.glyphicon-question-sign[data-toggle="tooltip"]').first();
            // Ensure the plugin is attached even if the page's ready handler hasn't fired yet.
            $trigger.tooltip({ container: 'body' });
            $trigger.tooltip('show');
            const describedBy = $trigger.attr('aria-describedby');
            return {
                describedBy: describedBy || null,
                // The visible tooltip element Bootstrap injects into <body>.
                tooltipVisible: $('body > .tooltip.in').length > 0,
                titleMoved: !!$trigger.attr('data-original-title'),
            };
        });

        expect(shown.titleMoved).toBe(true);
        expect(shown.describedBy).not.toBeNull();
        expect(shown.tooltipVisible).toBe(true);
    });

    test('Bootstrap modal (asset upload) opens and closes on the authoring page', async ({ page }) => {
        await page.goto(ASSET_PAGE);
        await waitForJQuery(page);

        // The .modal.img-upload markup is static in the DOM (src/views/modals/asset-upload.php);
        // its real trigger is the live Author API, so we drive Bootstrap's modal API directly to
        // prove the 3.4.1 modal plugin works under jQuery 3.7.1.
        const modal = page.locator('.modal.img-upload');
        await expect(modal).toHaveCount(1);

        await page.evaluate(() => window.jQuery('.modal.img-upload').modal('show'));
        // Bootstrap adds the "in" class and sets display:block when a modal is shown.
        await expect(modal).toHaveClass(/\bin\b/);
        await expect(modal).toBeVisible();

        // The gallery thumbnails the demo wires click handlers onto should be present.
        await expect(page.locator('.asset-img-gallery img').first()).toHaveCount(1);

        await page.evaluate(() => window.jQuery('.modal.img-upload').modal('hide'));
        await expect(modal).not.toBeVisible();
    });

    test('Bootstrap modal (reports click-events) opens and closes', async ({ page }) => {
        await page.goto(REPORTS_PAGE);
        await waitForJQuery(page);

        // #lrn-reports-demos-modal is a static empty modal; its trigger is a live Reports API
        // click:score event. Assert the modal plugin can show/hide it under the new stack.
        const modal = page.locator('#lrn-reports-demos-modal');
        await expect(modal).toHaveCount(1);

        await page.evaluate(() => window.jQuery('#lrn-reports-demos-modal').modal('show'));
        await expect(modal).toHaveClass(/\bin\b/);
        await expect(modal).toBeVisible();

        await page.evaluate(() => window.jQuery('#lrn-reports-demos-modal').modal('hide'));
        await expect(modal).not.toBeVisible();
    });

    test('html5sortable plugin and jQuery helpers work under jQuery 3.7.1', async ({ page }) => {
        // The question-editor settings modal (src/views/modals/settings-questioneditor.php) is
        // orphaned - no served URL renders it. But its sortable list and the jQuery calls around
        // it ($.map, $.trim, .sortable(), .data(), .appendTo()) are exactly the patterns most at
        // risk in a jQuery 1->3 jump. We load the real html5sortable plugin from the app, mount
        // the real fragment markup, and re-run the source's own logic to prove it still works.
        await page.goto(DATA_PAGE);
        await waitForJQuery(page);

        // The sortable plugin is served by the app at this path (used by the QE settings modal).
        await page.addScriptTag({ url: '/static/vendor/html5sortable/jquery.sortable.min.js' });
        await page.waitForFunction(() => !!(window.jQuery && window.jQuery.fn.sortable), null, {
            timeout: 10000,
        });

        const result = await page.evaluate(() => {
            const $ = window.jQuery;

            // Mount the exact list from settings-questioneditor.php.
            const refs = ['basic', 'formatting', 'validation', 'metadata', 'advanced'];
            const $list = $('<ul class="sortable"></ul>');
            refs.forEach(function (ref) {
                $('<li></li>').attr('data-reference', ref).text(ref).appendTo($list);
            });
            $('body').append($list);

            // .sortable() init (html5sortable) - this is the plugin call from the source.
            $('.sortable').sortable();

            // getAccordionOrder() from the source: uses $.map + $.trim + .data().
            const order = $.map($('ul.sortable li'), function (val) {
                return $.trim($(val).data('reference'));
            });

            // renderAccordions() reordering logic from the source: .find() + .appendTo().
            const desired = ['advanced', 'basic', 'metadata', 'formatting', 'validation'];
            desired.forEach(function (ref) {
                const item = $('ul.sortable').find("[data-reference='" + ref + "']");
                item.appendTo($('ul.sortable'));
            });
            const reordered = $.map($('ul.sortable li'), function (val) {
                return $.trim($(val).data('reference'));
            });

            // Draggable attribute is what html5sortable applies to the list items.
            const draggableCount = $('ul.sortable li[draggable="true"]').length;

            return {
                sortableIsFunction: typeof $.fn.sortable === 'function',
                order: order,
                reordered: reordered,
                draggableCount: draggableCount,
            };
        });

        expect(result.sortableIsFunction).toBe(true);
        // $.map / $.trim / .data() read the references in original order.
        expect(result.order).toEqual(['basic', 'formatting', 'validation', 'metadata', 'advanced']);
        // .find()/.appendTo() reordering produced the requested order.
        expect(result.reordered).toEqual(['advanced', 'basic', 'metadata', 'formatting', 'validation']);
        // html5sortable marked every item draggable.
        expect(result.draggableCount).toBe(5);
    });
});
