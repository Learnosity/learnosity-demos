// Configire Test Environment
var chai = require('chai');
var availableEnvironments = ['prod', 'staging', 'vg', 'escrow'];
var testConfig = {};

global.expect = chai.expect;
global.assert = chai.assert;
global.testConfig = testConfig;

if (process.env._ENV === undefined) {
    testConfig.env = 'prod';
} else {
    if (new RegExp('^' + availableEnvironments.join('$|^') + '$').test(process.env._ENV)) {
        testConfig.env = process.env._ENV;
    } else {
        throw 'Unknown environment: ' + availableEnvironments.join();
    }
}
