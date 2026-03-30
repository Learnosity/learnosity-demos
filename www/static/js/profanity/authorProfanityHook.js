/**
 * authorProfanityHook
 * Monkey-patches LearnosityAuthor.init() to automatically inject a presave
 * profanity check. No per-page code changes are required.
 *
 * Depends on: LrnProfanityFilter (must be loaded first in the bundle).
 */
(function () {
    'use strict';

    var POLL_INTERVAL_MS = 100;
    var POLL_MAX_MS = 30000;

    function _scanObject(obj) {
        if (typeof obj === 'string') {
            return window.LrnProfanityFilter.containsProfanity(obj);
        }
        if (Array.isArray(obj)) {
            for (var i = 0; i < obj.length; i++) {
                if (_scanObject(obj[i])) { return true; }
            }
            return false;
        }
        if (obj !== null && typeof obj === 'object') {
            var keys = Object.keys(obj);
            for (var k = 0; k < keys.length; k++) {
                if (_scanObject(obj[keys[k]])) { return true; }
            }
        }
        return false;
    }

    function _attachPresave(authorApp) {
        authorApp.on('presave', function () {
            try {
                var item = authorApp.getItem();
                if (_scanObject(item)) {
                    alert('Save blocked: your content contains inappropriate language. Please review and remove any inappropriate words before saving.');
                    return false;
                }
            } catch (e) {
                console.warn('[LrnProfanityHook] Error during presave scan; allowing save.', e);
            }
            return true;
        });
    }

    function _wrapInit() {
        var originalInit = window.LearnosityAuthor.init.bind(window.LearnosityAuthor);

        window.LearnosityAuthor.init = function (initOptions, callbacks) {
            callbacks = callbacks || {};
            var originalReadyListener = callbacks.readyListener;

            callbacks.readyListener = function (authorApp) {
                window._lrnAuthorApp = authorApp;

                var attr = document.documentElement.getAttribute('data-profanity-locales');
                var locales = attr
                    ? attr.split(',').map(function (l) { return l.trim(); }).filter(Boolean)
                    : ['en'];

                window.LrnProfanityFilter.init({ locales: locales }).then(function () {
                    _attachPresave(authorApp);
                });

                if (typeof originalReadyListener === 'function') {
                    originalReadyListener(authorApp);
                }
            };

            return originalInit(initOptions, callbacks);
        };
    }

    function _pollForAuthor() {
        var elapsed = 0;
        var timer = setInterval(function () {
            if (window.LearnosityAuthor && typeof window.LearnosityAuthor.init === 'function') {
                clearInterval(timer);
                _wrapInit();
                return;
            }
            elapsed += POLL_INTERVAL_MS;
            if (elapsed >= POLL_MAX_MS) {
                clearInterval(timer);
                console.warn('[LrnProfanityHook] LearnosityAuthor was not detected after ' + (POLL_MAX_MS / 1000) + 's; profanity filter will not be active on this page.');
            }
        }, POLL_INTERVAL_MS);
    }

    _pollForAuthor();
})();
