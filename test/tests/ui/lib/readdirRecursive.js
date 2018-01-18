var fs = require('fs');
var p = require('path');

/**
 * Given a path to a directory, return a list of all files in that directory
 *
 * @param {array} files - array of files
 * @param {string} searchString - string to search for
 *
 */
function recursiveReaddirSync(path) {
    'use strict';

    var list = [];
    var files = fs.readdirSync(path);
    var stats;

    files.forEach(function (file) {
        stats = fs.lstatSync(p.join(path, file));

        if (stats.isDirectory()) {
            list = list.concat(recursiveReaddirSync(p.join(path, file)));
        } else {
            list.push(p.join(path, file));
        }
    });

    return list;
}

module.exports = recursiveReaddirSync;
