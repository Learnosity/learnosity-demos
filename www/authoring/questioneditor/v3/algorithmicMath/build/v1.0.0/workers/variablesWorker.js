var MAX_ROW = 1000;

// Source -
// http://stackoverflow.com/questions/15298912/javascript-generating-combinations-from-n-arrays-with-m-elements
// This method returns an array which is the combination of all array arguments
// Example: cartesian([0], [1, 2], [3]) will return [ [0, 1, 3], [0, 2, 3] ]
var cartesian = function () {
    var r = [], arg = arguments, max = arg.length-1;
    function helper(arr, i) {
        for (var j=0, l=arg[i].length; j<l; j++) {
            var a = arr.slice(0); // clone arr
            a.push(arg[i][j]);
            if (i==max)
                r.push(a);
            else
                helper(a, i+1);
        }
    }
    helper([], 0);
    return r;
};

var getStep = function (permuations) {
    return Math.round(permuations.length / MAX_ROW);
};

var filterSelection = function (permuations, step) {
    var result = [];
    var length = permuations.length;
    var curIndex = 0;
    var i;

    if (length > MAX_ROW) {
        for (i = 0; i < MAX_ROW; i++) {
            result.push(permuations[curIndex]);

            if (curIndex + step < length) {
                curIndex += step;
            } else {
                curIndex = length - 1;
            }
        }
    } else {
        result = permuations;
    }

    return result;
};

var buildIteration = function (min, max, step, decimalPlace) {
    var result = [];
    var num;

    // Format decimalPlace
    decimalPlace = decimalPlace ? parseInt(decimalPlace) : null;

    for (num = min; num <= max; num += step) {
        if (decimalPlace) {
            num = Number(num.toFixed(decimalPlace));
        }
        result.push(num);
    }

    return result;
};

/**
 * Returns all the possible combination of the provided list of variables.
 * The return array should not have length higher than the MAX_ROW value (1000)
 * For example:
 * [{min: 0, max: 3, step: 1}, {min: 2, max: 6, step: 2}] will return
 * [ [0,2], [0,4], [0,6], [1,2], [1,4], [1,6], [3,2], [3,4], [3,6] ]
 * @param variables
 * @returns {array}
 */
var getVariablePossibleValues = function (variables) {
    var iterations = [];
    var permuations;

    if (!variables) {
        return [];
    }

    variables.forEach(function (data) {
        iterations.push(buildIteration(data.min, data.max, data.step, data.decimal_place));
    });

    permuations = cartesian.apply(null, iterations);

    return permuations;
};

self.addEventListener('message', function(e) {
    var permuations = getVariablePossibleValues(e.data);
    var permuationLength = permuations.length;
    var step = getStep(permuations);
    var variables = filterSelection(permuations, step);

    self.postMessage({
        variables: variables,
        step: step,
        permuationLength: permuationLength
    });
    close();
}, false);
