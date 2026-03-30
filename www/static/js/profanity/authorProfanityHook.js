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

    function _attachPresave(authorApp) {
        var attr = document.documentElement.getAttribute('data-profanity-locales');
        var locales = attr ? attr.split(',').map(function (s) { return s.trim(); }) : ['en'];

        window.LrnProfanityFilter.init({ locales: locales }).then(function () {
            authorApp.on('presave', function () {
                try {
                    var item = authorApp.getItem();
                    var found = _walkObject(item, function (str) {
                        return window.LrnProfanityFilter.containsProfanity(str);
                    });
                    if (found) {
                        alert('Save blocked: your content contains inappropriate language. Please review and remove any inappropriate words before saving.');
                        return false;
                    }
                    return true;
                } catch (e) {
                    console.warn('[authorProfanityHook] Error during presave scan, allowing save:', e);
                    return true;
                }
            });
            console.log('[authorProfanityHook] Presave profanity filter attached.');
        });
    }

    // Poll for the authorApp global that each page creates after calling LearnosityAuthor.init()
    function _waitForAuthorApp() {
        var elapsed = 0;
        var timer = setInterval(function () {
            if (window.authorApp && typeof window.authorApp.on === 'function') {
                clearInterval(timer);
                _attachPresave(window.authorApp);
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
