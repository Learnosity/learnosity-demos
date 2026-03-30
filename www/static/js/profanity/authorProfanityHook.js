/**
 * Author API Profanity Hook
 *
 * Intercepts Save button clicks on Learnosity Author API demo pages and blocks
 * saves when profanity is detected in the current item JSON.
 *
 * This hook is bundled into all.min.js which loads on every page. It only
 * activates on Author API pages where window.authorApp exists and has a
 * getItem() method. On all other pages it no-ops.
 *
 * DOM interception is required because the Learnosity Author API does not
 * expose a presave event. The only save-related event (save:success) fires
 * after the save has already completed.
 */
(function () {
    'use strict';

    var _initialised = false;
    var POLL_INTERVAL = 100;   // ms
    var POLL_TIMEOUT  = 30000; // ms

    /**
     * Walk up the DOM tree from a given element looking for a Save button.
     *
     * Uses a tiered detection strategy, prioritising stable attributes:
     *   Tier 1: data-authorapi-selector="save" or data-lrn-role="save"
     *   Tier 2: .lrn_btn_save or .lrn-author-save-button
     *   Tier 3: <button> whose trimmed textContent is exactly "Save"
     *
     * @param {Element} el - The event target element.
     * @returns {boolean} True if the click target is (or is inside) a Save button.
     */
    function isSaveButton(el) {
        var node = el;
        while (node && node !== document) {
            // Tier 1 — data attributes
            if (
                (node.getAttribute && node.getAttribute('data-authorapi-selector') === 'save') ||
                (node.getAttribute && node.getAttribute('data-lrn-role') === 'save')
            ) {
                return true;
            }

            // Tier 2 — class names
            if (node.classList && (
                node.classList.contains('lrn_btn_save') ||
                node.classList.contains('lrn-author-save-button')
            )) {
                return true;
            }

            // Tier 3 — <button> with text "Save" (last resort)
            if (
                node.tagName === 'BUTTON' &&
                node.textContent && node.textContent.trim() === 'Save'
            ) {
                return true;
            }

            node = node.parentElement;
        }
        return false;
    }

    /**
     * Recursively extract all string values from an object / array.
     *
     * @param {*} obj
     * @returns {string}
     */
    function extractStrings(obj) {
        var parts = [];
        if (typeof obj === 'string') {
            parts.push(obj);
        } else if (Array.isArray(obj)) {
            for (var i = 0; i < obj.length; i++) {
                parts.push(extractStrings(obj[i]));
            }
        } else if (obj && typeof obj === 'object') {
            var keys = Object.keys(obj);
            for (var j = 0; j < keys.length; j++) {
                parts.push(extractStrings(obj[keys[j]]));
            }
        }
        return parts.join(' ');
    }

    /**
     * Attach the capturing-phase click listener on `document`.
     *
     * The `true` (capturing phase) argument is critical — it ensures our handler
     * runs before Learnosity's own click handlers so we can preventDefault /
     * stopImmediatePropagation before the save reaches the API.
     */
    function attachClickInterceptor() {
        document.addEventListener('click', function (event) {
            // Only intercept if the filter is ready
            if (!window.LrnProfanityFilter || !window.LrnProfanityFilter.isReady()) {
                return;
            }

            // Only intercept clicks on Save buttons
            if (!isSaveButton(event.target)) {
                return;
            }

            // Retrieve the current item JSON from the Author API
            var item;
            try {
                item = window.authorApp.getItem();
            } catch (e) {
                // If getItem() fails, allow the save to proceed
                return;
            }

            if (!item) return;

            // Extract all string values and check for profanity
            var text = extractStrings(item);
            var matches = window.LrnProfanityFilter.getMatches(text);

            if (matches.length > 0) {
                event.preventDefault();
                event.stopImmediatePropagation();
                window.alert(
                    'Save blocked: profanity detected.\n\nPlease remove the following ' +
                    'before saving:\n• ' + matches.join('\n• ')
                );
            }
        }, true);
    }

    /**
     * Poll for window.authorApp until it appears or the timeout is reached.
     * If authorApp is found and has getItem(), initialise the profanity filter
     * and attach the click interceptor.
     */
    function pollForAuthorApp() {
        var elapsed = 0;
        var interval = setInterval(function () {
            elapsed += POLL_INTERVAL;

            if (
                window.authorApp &&
                typeof window.authorApp.getItem === 'function'
            ) {
                clearInterval(interval);

                if (_initialised) return;
                _initialised = true;

                // Determine locales from the <html> element attribute
                var attr = document.documentElement.getAttribute('data-profanity-locales');
                var locales = attr ? attr.split(/[,\s]+/).filter(Boolean) : ['en'];

                // Optional wordlist base path override
                var basePath = document.documentElement.getAttribute('data-profanity-wordlist-path');
                var initOpts = { locales: locales };
                if (basePath) {
                    initOpts.wordlistBasePath = basePath;
                }

                // Initialise the profanity filter (loads word lists asynchronously)
                if (window.LrnProfanityFilter) {
                    window.LrnProfanityFilter.init(initOpts).then(function () {
                        attachClickInterceptor();
                    }).catch(function (err) {
                        // Silently fail — do not block authoring if word lists fail to load
                        if (typeof console !== 'undefined' && console.error) {
                            console.error('[authorProfanityHook] Failed to initialise profanity filter:', err);
                        }
                    });
                }
            }

            if (elapsed >= POLL_TIMEOUT) {
                clearInterval(interval);
            }
        }, POLL_INTERVAL);
    }

    // Start polling immediately when the script loads
    pollForAuthorApp();
})();
