require('./testPrimer.js');

const FormData = require('form-data');
const https = require('https');
const HostPage = require('../pageObjects/hostPage');
const DataObject = require('./getDataObjectForProvisioning');
const GlobalParameters = require ('./globalParameters.js');

const dataRequests = DataObject.getRequestObjects();

// Iterate over regions so content is added to consumer in that region
testConfig.regions.forEach(function (region) {
    const hostPage = new HostPage(testConfig.env, region);
    const dataApp = hostPage.initDataApp();

    const dataApiSrcPath = GlobalParameters.getDataApiSrc('data', hostPage.env, hostPage.learnosityRegion, hostPage.dataApiVersion);

    // Iterate over all data requests defined
    dataRequests.forEach(function (dataRequest) {
        let statusCode;
        const lrnRequest = dataApp.generateDataRequest(hostPage, dataRequest.body, dataRequest.method);
        const form = new FormData();

        form.append('security', lrnRequest.security);
        form.append('request', lrnRequest.request);
        form.append('action', lrnRequest.action);

        try {
            var response = https.request({
                'host' : dataApiSrcPath,
                'path' : '/' + hostPage.dataApiVersion + dataRequest.path,
                'method' : 'POST',
                'family': 4,
                'headers' : form.getHeaders()
            });

            form.pipe(response);

            response.on('response', function (res) {
                res.on('data', function (chunk) {
                    console.log('data: ' + chunk + '\r');
                });
                res.on('end', function () {
                    console.log('Finished data api call\n');
                    statusCode = res.statusCode;
                });
            });
        } catch (e) {
            console.log(e);
        }
    });
});
