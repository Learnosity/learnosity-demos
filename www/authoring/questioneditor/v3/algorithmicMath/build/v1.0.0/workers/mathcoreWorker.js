// For local requirejs build
self.define = function (Mathcore) {
    mathcore = Mathcore();
};

// For webpack build -- Questions v2.109 and later
self.LearnosityAmd = function (__, moduleObject) {
    var keys = Object.keys(moduleObject);
    var moduleFn = moduleObject[keys[0]];
    var module = {};

    moduleFn(module, {}, function () {});

    mathcore = module.exports;
};

// For LearnosityAmd requirejs build -- Questions v.2.108 and before
self.LearnosityAmd.define = function (__, Mathcore) {
    mathcore = Mathcore();
};

function calculate(value) {
    return mathcore.evaluate({ method: 'calculate' }, value);
}

var UPDATE_LIMIT = 20;
var mathcore;

// For api version before v2.109 - use this link
// importScripts('//questions.learnosity.com/latest/vendor/scoring/vendor/mathcore.js');

// For api version after v2.109 - use this link
importScripts('//questions.learnosity.com/latest/dist/vendor/mathcore.js');

/**
 * Returns the template string that will be passed into mathcore's calculate method
 * based on the provided set of variables
 * @param variables
 * @param template
 * @returns {string}
 */
var buildTemplateSpec = function (variables, template) {
    for (var name in variables) {
        template = template.replace('{{var:' + name + '}}', variables[name]);
    }

    return template;
};

/**
 * Helper Util
 * @type {{object: _.object, find: _.find}}
 * @private
 */
var _ = {
    object: function(list, values) {
        var result = {};
        for (var i = 0, length = list.length; i < length; i++) {
            if (values) {
                result[list[i]] = values[i];
            } else {
                result[list[i][0]] = list[i][1];
            }
        }
        return result;
    },
    find: function (array, callback) {
        var i, item;
        for (i = 0; i < array.length; i++) {
            item = array[i];
            if (callback(item, i) === true) {
                return item;
            }
        }
    }
};

self.addEventListener('message', function (e) {
    var options = JSON.parse(e.data);
    var variableNames = options.variableNames;
    var variableValues = options.variableValues;
    var addedAnswers = options.addedAnswers;
    var template = options.template;
    var updatedList = [];

    if (!mathcore) {
        self.postMessage({
            completed: true
        });
        close();

        return;
    }

    // Based on possible value of all variables to build the collection
    variableValues.forEach(function (values, rowIndex) {
        var itemData = {
            index: rowIndex,
            modified: false
        };
        var hasReachedTheEnd = rowIndex === variableValues.length - 1;
        var error, curAddedAnswer, templateSpec;

        if (addedAnswers) {
            curAddedAnswer = _.find(addedAnswers, function (item) {
                return item.row_index === rowIndex;
            });
        }

        // If user has manually set the {{var:correctAnswer}} value through added_answers
        // which will have format added_answers{ [row_index]: [value] }
        // example: added_answers: { 2: 35, 5: 60 } which means row 2 and row 5
        // of the table will have corresponding value 35 and 60.
        // So for those row, we add a new flag "modified" to tell our app
        // those row's response value has been setup manually (without using mathcore)
        if (curAddedAnswer) {
            itemData.value = curAddedAnswer.value;
            itemData.modified = true;
        } else {
            // For other row where value should be set automatically, we ask mathcore
            // to calculate and return response value for us
            templateSpec = buildTemplateSpec(_.object(variableNames, values), template);

            try {
                itemData.equation = templateSpec;
                itemData.value = calculate(templateSpec);

                if (typeof itemData.value === 'undefined') {
                    error = true;
                    itemData.value = '';
                }

            } catch (er) {
                // Fallback if mathcore can not calculate the end result
                itemData.value = '';

                if (!error) {
                    error = er;
                }
            }
        }

        updatedList.push(itemData);

        if (updatedList.length === UPDATE_LIMIT || hasReachedTheEnd) {
            self.postMessage({
                updatedList: updatedList
            });
            updatedList = [];

            if (hasReachedTheEnd) {
                self.postMessage({
                    completed: true,
                    error: error
                });
            }
        }
    });

    close();
}, false);
