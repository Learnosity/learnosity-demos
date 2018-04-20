const TEST_PAGE = 'https://demos.learnosity.com/';


/**
 * Class for Demos Page
 * @type {DemosPage}
 */
module.exports = class DemosPage {
    constructor() {

        this.url = TEST_PAGE;

    }

    /**
     * Open Page in WebDriver
     */
    load(url = this.url) {
        browser.url(url);
    }

    /**
     * waitForDocumentReady
     */
    // waitForDocumentReady() {
    //     browser.executeAsync(function(done) {
    //         var newTimeout = setInterval(function() {myTimer();}, 1000);
    //         function myTimer() {
    //             if(window.document.readyState === "complete"){
    //                 clearInterval(newTimeout);
    //                 done();
    //             }
    //         }
    //     });
    // }
    waitForDocumentReady() {
        browser.executeAsync(function(done) {
            window.document.body.addEventListener('load', function () {
                done();
            });
            // window.addEventListener('load', function () {
            //     done();
            // });
        });
    }


    panelClick(section1, section2, panelName, buttonName) {
        

        browser.waitForVisible("=" + section1, 10000)
        browser.click("=" + section1);

        browser.waitForVisible("=" + section2, 10000)
        browser.click("=" + section2);

        browser.pause(1000);

        //this.waitForDocumentReady();
        var navigatingUrl;

        if (panelName != '' ) {
            browser.waitForVisible('.panel-title=' + panelName, 10000)
            var panel_title = browser.element('.panel-title=' + panelName)
            if (panel_title != '' ) {
                console.log("Found the panel titled " + panelName);
                var parent = panel_title.element('./../..');
                var button = parent.element('=' + buttonName);
                navigatingUrl = button.getAttribute("href");
                console.log("Button href = " + navigatingUrl);
                button.click();
            }
            else
            {
                console.log("Can't find the panel titled " + panelName);
                assert.fail("Failed to find panel titled " + panelName);
            }
        }


        // NEED TO WAIT TILL PAGE LOADS.

        //browser.pause(60000);
        
        
        // browser.waitUntil(function() {
        //     return browser.getUrl().indexOf(navigatingUrl) > -1; // the navigation that you are navigating to
        // }, 60000);

        

        // this.waitForDocumentReady();
        
        // var fail = false;
        // try {
        //     if (browser.alertText()) {
        //         browser.alertAccept();
        //         fail = true;
        //     }
        // }
        // catch (error) {

        // }
        // if (fail) {
        //     assert.fail("Alert popup detected");
        // }
    }
    
};
