window.LrnProfanityFilter = (function () {
    'use strict';

    var _regex = null;
    var _ready = false;
    var _words = [];

    function _stripHtml(html) {
        return html.replace(/<[^>]+>/g, ' ');
    }

    function _compileRegex() {
        if (_words.length === 0) {
            _regex = null;
            return;
        }
        // Sort longest first so multi-word phrases match before substrings
        var sorted = _words.slice().sort(function (a, b) {
            return b.length - a.length;
        });
        var escaped = sorted.map(function (w) {
            return w.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        });
        _regex = new RegExp('\\b(' + escaped.join('|') + ')\\b', 'i');
    }

    function _loadWordList(locale) {
        return new Promise(function (resolve) {
            var xhr = new XMLHttpRequest();
            var url = '/static/js/profanity/wordlists/' + locale + '.json';
            xhr.open('GET', url, true);
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        var list = JSON.parse(xhr.responseText);
                        if (Array.isArray(list)) {
                            _words = _words.concat(list.map(function (w) {
                                return String(w).toLowerCase();
                            }));
                        }
                    } catch (e) {
                        console.warn('[LrnProfanityFilter] Failed to parse word list for locale "' + locale + '":', e);
                    }
                } else {
                    console.warn('[LrnProfanityFilter] Word list not found for locale "' + locale + '" (HTTP ' + xhr.status + ')');
                }
                resolve();
            };
            xhr.onerror = function () {
                console.warn('[LrnProfanityFilter] Network error loading word list for locale "' + locale + '"');
                resolve();
            };
            xhr.send();
        });
    }

    function init(opts) {
        opts = opts || {};
        var locales = opts.locales;
        if (!Array.isArray(locales) || locales.length === 0) {
            var attr = document.documentElement.getAttribute('data-profanity-locales');
            locales = attr ? attr.split(',').map(function (s) { return s.trim(); }) : ['en'];
        }
        _ready = false;
        _words = [];
        _regex = null;
        var promises = locales.map(function (locale) {
            return _loadWordList(locale);
        });
        return Promise.all(promises).then(function () {
            _compileRegex();
            _ready = true;
        });
    }

    function containsProfanity(text) {
        if (!_regex || !text) {
            return false;
        }
        var plain = _stripHtml(String(text));
        return _regex.test(plain);
    }

    function getMatches(text) {
        if (!_regex || !text) {
            return [];
        }
        var plain = _stripHtml(String(text));
        var globalRegex = new RegExp(_regex.source, 'gi');
        var matches = plain.match(globalRegex);
        return matches ? matches.map(function (m) { return m.toLowerCase(); }) : [];
    }

    function addWords(words, locale) {
        if (!Array.isArray(words)) {
            return;
        }
        _words = _words.concat(words.map(function (w) {
            return String(w).toLowerCase();
        }));
        _compileRegex();
    }

    function isReady() {
        return _ready;
    }

    return {
        init: init,
        containsProfanity: containsProfanity,
        getMatches: getMatches,
        addWords: addWords,
        isReady: isReady
    };
})();
