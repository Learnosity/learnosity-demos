(function () {
    'use strict';

    var POLL_INTERVAL_MS = 100;
    var POLL_TIMEOUT_MS = 30000;

    function _walkObject(obj, check) {
        if (typeof obj === 'string') return check(obj);
        if (Array.isArray(obj)) {
            for (var i = 0; i < obj.length; i++) {
                if (_walkObject(obj[i], check)) return true;
            }
            return false;
        }
        if (obj !== null && typeof obj === 'object') {
            var keys = Object.keys(obj);
            for (var k = 0; k < keys.length; k++) {
                if (_walkObject(obj[keys[k]], check)) return true;
            }
        }
        return false;
    }

    function _isSaveButton(el) {
        // Walk up from the click target to see if it's inside a Learnosity save button
        while (el && el !== document.body) {
            // Check for common Learnosity Author API save button patterns
            if (
                (el.getAttribute && el.getAttribute('data-authorapi-selector') === 'save') ||
                (el.classList && (
                    el.classList.contains('lrn_btn_save') ||
                    el.classList.contains('lrn-author-save-button')
                ))
            ) {
                return true;
            }
            // Also check for buttons/elements with "Save" text inside #learnosity-author.
            // \u2714 is the checkmark (✔) that the Author API prepends to the Save button label.
            if (
                el.tagName === 'BUTTON' &&
                el.closest && el.closest('#learnosity-author') &&
                el.textContent && el.textContent.trim().match(/^\u2714?\s*Save/i)
            ) {
                return true;
            }
            el = el.parentElement;
        }
        return false;
    }

    function _attachSaveInterceptor(authorApp) {
        var attr = document.documentElement.getAttribute('data-profanity-locales');
        var locales = attr ? attr.split(',').map(function (s) { return s.trim(); }) : ['en'];

        window.LrnProfanityFilter.init({ locales: locales }).then(function () {
            // Use capturing phase so we can intercept before Learnosity's handler
            document.addEventListener('click', function (event) {
                if (!_isSaveButton(event.target)) {
                    return;
                }

                try {
                    var item = authorApp.getItem();
                    if (!item) return; // No item data, let save proceed

                    var found = _walkObject(item, function (str) {
                        return window.LrnProfanityFilter.containsProfanity(str);
                    });

                    if (found) {
                        event.stopImmediatePropagation();
                        event.preventDefault();
                        alert('Save blocked: your content contains inappropriate language. Please review and remove any inappropriate words before saving.');
                    }
                } catch (e) {
                    // If there's an error checking, allow the save to proceed
                    console.warn('[authorProfanityHook] Error during save interception, allowing save:', e);
                }
            }, true); // true = capturing phase

            console.log('[authorProfanityHook] Save button profanity interceptor attached.');
        });
    }

    // Poll for the authorApp global that each page creates after calling LearnosityAuthor.init()
    function _waitForAuthorApp() {
        var elapsed = 0;
        var timer = setInterval(function () {
            if (window.authorApp && typeof window.authorApp.on === 'function') {
                clearInterval(timer);
                _attachSaveInterceptor(window.authorApp);
                return;
            }
            elapsed += POLL_INTERVAL_MS;
            if (elapsed >= POLL_TIMEOUT_MS) {
                clearInterval(timer);
                console.warn('[authorProfanityHook] authorApp not found within ' + (POLL_TIMEOUT_MS / 1000) + 's');
            }
        }, POLL_INTERVAL_MS);
    }

    _waitForAuthorApp();
})();
