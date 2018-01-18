var fs = require('fs');

/**
 * Given an array of files, search for a given string
 *
 * @param {array} files - array of files
 * @param {string} searchString - string to search for
 *
 */
function fileSearch(files, searchString) {
    'use strict';

    var matches = [];

    files.forEach(function (file) {
        var contents = fs.readFileSync(file).toString();

        if (contents.indexOf(searchString) > -1) {
            // Only add the file if `.only` is found in the contents
            if (matches.indexOf(file) === -1) {
                // Only add the file if it has not been added already
                matches.push(file);
            }
        }
    });
    return matches;
}

module.exports = fileSearch;
