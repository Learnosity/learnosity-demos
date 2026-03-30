/**
 * LrnProfanityFilter
 * Loads locale-specific word lists via XHR and exposes profanity-checking helpers.
 *
 * Usage:
 *   LrnProfanityFilter.init({ locales: ['en', 'es'] }).then(function() { ... });
 *   LrnProfanityFilter.containsProfanity('some text'); // => boolean
 */
window.LrnProfanityFilter = (function () {
    'use strict';

    var _ready = false;
    var _regex = null;
    var _words = {};

    // Resolve the base URL for word list JSON files relative to this script.
    // Falls back to a relative path when document.currentScript is unavailable.
    function _baseUrl() {
        var script = document.currentScript;
        if (script && script.src) {
            return script.src.replace(/\/[^/]+$/, '/wordlists/');
        }
        return '/static/js/profanity/wordlists/';
    }

    var _wordlistBase = _baseUrl();

    function _stripHtml(html) {
        try {
            var doc = new DOMParser().parseFromString(html, 'text/html');
            return doc.body ? (doc.body.textContent || '') : html;
        } catch (e) {
            // DOMParser unavailable; fall back to plain string
            return html.replace(/<[^>]*>/g, ' ');
        }
    }

    function _compile() {
        var all = [];
        Object.keys(_words).forEach(function (locale) {
            _words[locale].forEach(function (w) {
                all.push(w);
            });
        });
        if (!all.length) {
            _regex = null;
            return;
        }
        // Sort longest-first so multi-word phrases match before substrings.
        all.sort(function (a, b) { return b.length - a.length; });
        var escaped = all.map(function (w) {
            return w.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        });
        // Use lookahead/lookbehind instead of \b so accented characters
        // (e.g. cabrón) and multi-word phrases are handled correctly.
        _regex = new RegExp('(?<![a-zA-Z\u00C0-\u024F])(' + escaped.join('|') + ')(?![a-zA-Z\u00C0-\u024F])', 'gi');
    }

    function _loadLocale(locale) {
        return new Promise(function (resolve) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', _wordlistBase + locale + '.json', true);
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        var list = JSON.parse(xhr.responseText);
                        if (Array.isArray(list)) {
                            _words[locale] = list;
                        } else {
                            console.warn('[LrnProfanityFilter] Word list for "' + locale + '" is not an array; skipping.');
                        }
                    } catch (e) {
                        console.warn('[LrnProfanityFilter] Failed to parse word list for "' + locale + '":', e);
                    }
                } else {
                    console.warn('[LrnProfanityFilter] Could not load word list for "' + locale + '" (HTTP ' + xhr.status + '); skipping.');
                }
                resolve();
            };
            xhr.onerror = function () {
                console.warn('[LrnProfanityFilter] Network error loading word list for "' + locale + '"; skipping.');
                resolve();
            };
            xhr.send();
        });
    }

    function init(opts) {
        _ready = false;
        var locales;
        if (opts && Array.isArray(opts.locales) && opts.locales.length) {
            locales = opts.locales;
        } else {
            var attr = document.documentElement.getAttribute('data-profanity-locales');
            locales = attr ? attr.split(',').map(function (l) { return l.trim(); }).filter(Boolean) : ['en'];
        }

        var promises = locales.map(function (locale) {
            return _loadLocale(locale);
        });

        return Promise.all(promises).then(function () {
            _compile();
            _ready = true;
        });
    }

    function isReady() {
        return _ready;
    }

    function getMatches(text) {
        if (!_regex) { return []; }
        var plain = _stripHtml(text);
        _regex.lastIndex = 0;
        var matches = [];
        var m;
        while ((m = _regex.exec(plain)) !== null) {
            matches.push(m[0].toLowerCase());
        }
        return matches;
    }

    function containsProfanity(text) {
        if (!_regex) { return false; }
        var plain = _stripHtml(text);
        _regex.lastIndex = 0;
        return _regex.test(plain);
    }

    function addWords(words, locale) {
        var key = locale || 'custom';
        if (!_words[key]) {
            _words[key] = [];
        }
        _words[key] = _words[key].concat(
            words.filter(function (w) { return typeof w === 'string'; })
        );
        _compile();
    }

    return {
        init: init,
        isReady: isReady,
        containsProfanity: containsProfanity,
        getMatches: getMatches,
        addWords: addWords
    };
})();
