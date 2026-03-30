/**
 * LrnProfanityFilter — A generic client-side profanity detection module.
 *
 * Loads word lists from JSON files and exposes methods to check text for profanity.
 * Assigned to window.LrnProfanityFilter.
 *
 * NOTE: Short terms like "ass" are prone to false positives (matching "assignment",
 * "class", etc.). The allowlist mechanism or the word list itself should be tuned
 * for production use.
 */
(function () {
    'use strict';

    var _ready = false;
    var _words = [];
    var _allowlist = [];
    var _regex = null;
    var _wordlistBasePath = '/static/js/profanity/wordlists';

    /* ------------------------------------------------------------------ */
    /*  Internal helpers                                                   */
    /* ------------------------------------------------------------------ */

    /**
     * Escape special regex metacharacters in a string.
     */
    function escapeRegex(str) {
        return str.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    }

    /**
     * Compile the combined regex from the current word list.
     *
     * - Words are sorted longest-first so multi-word phrases match before substrings.
     * - Single-word entries are wrapped with \b word boundaries.
     * - Multi-word phrases use \s+ for internal spaces and \b only at the outer edges.
     *
     * NOTE: \b can behave poorly with apostrophes and some punctuation. More
     * sophisticated boundary handling could be added if needed.
     */
    function compileRegex() {
        if (_words.length === 0) {
            _regex = null;
            return;
        }

        var sorted = _words.slice().sort(function (a, b) {
            return b.length - a.length;
        });

        var parts = sorted.map(function (word) {
            var hasSpace = /\s/.test(word);
            if (hasSpace) {
                // Multi-word phrase: escape each segment, join with \s+
                var segments = word.split(/\s+/).map(escapeRegex);
                return '\\b' + segments.join('\\s+') + '\\b';
            }
            return '\\b' + escapeRegex(word) + '\\b';
        });

        _regex = new RegExp('(' + parts.join('|') + ')', 'gi');
    }

    /**
     * Normalise text before checking for profanity.
     *
     * Steps:
     *  1. Strip HTML tags.
     *  2. Lowercase.
     *  3. Collapse whitespace (including non-breaking spaces).
     *  4. Remove zero-width / confusable Unicode characters.
     *  5. Strip combining diacritical marks (NFD decomposition).
     *  6. Trim.
     */
    function normalise(text) {
        if (typeof text !== 'string') return '';

        // 1. Strip HTML tags
        var result = text.replace(/<[^>]+>/g, ' ');

        // 2. Lowercase
        result = result.toLowerCase();

        // 3. Collapse runs of whitespace (incl. &nbsp; / \u00A0)
        result = result.replace(/[\s\u00A0]+/g, ' ');

        // 4. Remove zero-width characters and common confusables
        result = result.replace(/[\u200B\u200C\u200D\u200E\u200F\uFEFF\u00AD]/g, '');

        // 5. Strip accents / diacritics via NFD decomposition
        if (typeof result.normalize === 'function') {
            result = result.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        }

        // 6. Trim
        result = result.trim();

        return result;
    }

    /**
     * Fetch a JSON word list for the given locale via XHR.
     * Returns a Promise that resolves with the parsed array.
     */
    function fetchWordList(locale) {
        return new Promise(function (resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', _wordlistBasePath + '/' + encodeURIComponent(locale) + '.json', true);
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        var list = JSON.parse(xhr.responseText);
                        if (Array.isArray(list)) {
                            resolve(list);
                        } else {
                            reject(new Error('Word list for "' + locale + '" is not an array'));
                        }
                    } catch (e) {
                        reject(new Error('Failed to parse word list for "' + locale + '": ' + e.message));
                    }
                } else {
                    reject(new Error('Failed to fetch word list for "' + locale + '": HTTP ' + xhr.status));
                }
            };
            xhr.onerror = function () {
                reject(new Error('Network error fetching word list for "' + locale + '"'));
            };
            xhr.send();
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Public API                                                         */
    /* ------------------------------------------------------------------ */

    window.LrnProfanityFilter = {

        /**
         * Initialise the profanity filter.
         *
         * @param {Object} [opts]
         * @param {string[]} [opts.locales] - Locale codes to load (default: ['en']).
         *   Falls back to the data-profanity-locales attribute on <html>.
         * @param {string[]} [opts.allowlist] - Words to exclude from detection.
         * @param {string} [opts.wordlistBasePath] - Base URL path for word list JSON files.
         * @returns {Promise} Resolves when all word lists have loaded.
         */
        init: function (opts) {
            opts = opts || {};

            // Optional base path override for word list files
            if (opts.wordlistBasePath) {
                _wordlistBasePath = opts.wordlistBasePath;
            }

            // Determine locales
            var locales = opts.locales;
            if (!locales || !locales.length) {
                var attr = document.documentElement.getAttribute('data-profanity-locales');
                locales = attr ? attr.split(/[,\s]+/).filter(Boolean) : ['en'];
            }

            // Allowlist
            if (Array.isArray(opts.allowlist)) {
                _allowlist = opts.allowlist.map(function (w) { return w.toLowerCase(); });
            }

            // Fetch all locale word lists in parallel
            var fetches = locales.map(function (locale) {
                return fetchWordList(locale);
            });

            return Promise.all(fetches).then(function (results) {
                _words = [];
                results.forEach(function (list) {
                    list.forEach(function (word) {
                        var lower = word.toLowerCase();
                        if (_words.indexOf(lower) === -1) {
                            _words.push(lower);
                        }
                    });
                });
                compileRegex();
                _ready = true;
            });
        },

        /**
         * Check whether the given text contains profanity.
         *
         * @param {string} text
         * @returns {boolean}
         */
        containsProfanity: function (text) {
            if (!_ready || !_regex) return false;
            var normalised = normalise(text);
            _regex.lastIndex = 0;
            var match;
            while ((match = _regex.exec(normalised)) !== null) {
                if (_allowlist.indexOf(match[1].toLowerCase()) === -1) {
                    return true;
                }
            }
            return false;
        },

        /**
         * Return an array of matched profane words (excluding allowlisted terms).
         *
         * @param {string} text
         * @returns {string[]}
         */
        getMatches: function (text) {
            if (!_ready || !_regex) return [];
            var normalised = normalise(text);
            var matches = [];
            _regex.lastIndex = 0;
            var match;
            while ((match = _regex.exec(normalised)) !== null) {
                var word = match[1].toLowerCase();
                if (_allowlist.indexOf(word) === -1 && matches.indexOf(word) === -1) {
                    matches.push(word);
                }
            }
            return matches;
        },

        /**
         * Dynamically add words to the profane-word list and recompile the regex.
         *
         * @param {string[]} words
         */
        addWords: function (words) {
            if (!Array.isArray(words)) return;
            words.forEach(function (word) {
                var lower = word.toLowerCase();
                if (_words.indexOf(lower) === -1) {
                    _words.push(lower);
                }
            });
            compileRegex();
        },

        /**
         * Add words to the allowlist (false-positive exclusions).
         *
         * @param {string[]} words
         */
        addAllowlistWords: function (words) {
            if (!Array.isArray(words)) return;
            words.forEach(function (word) {
                var lower = word.toLowerCase();
                if (_allowlist.indexOf(lower) === -1) {
                    _allowlist.push(lower);
                }
            });
        },

        /**
         * Whether the filter has been initialised and is ready.
         *
         * @returns {boolean}
         */
        isReady: function () {
            return _ready;
        }
    };
})();
