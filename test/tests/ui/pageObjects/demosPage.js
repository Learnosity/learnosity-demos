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
    waitForDocumentReady() {
        browser.executeAsync(function(done) {
            var newTimeout = setInterval(function() {myTimer();}, 100);
            function myTimer() {
                if(window.document.readyState === "complete"){
                    clearInterval(newTimeout);
                    done();
                }
            }
        });
    }

    panelClick(section1, section2, panelName, buttonName) {
        browser.waitForVisible("=" + section1, 5000)
        browser.click("=" + section1);

        browser.waitForVisible("=" + section2, 5000)
        browser.click("=" + section2);

        //browser.pause(5000);

        this.waitForDocumentReady();

        if (panelName != '' ) {
            browser.waitForVisible('.panel-title=' + panelName, 5000)
            var panel_title = browser.element('.panel-title=' + panelName)
            if (panel_title != '' ) {
                console.log("Found the panel titled " + panelName);
                var parent = panel_title.element('./../..');
                parent.element('=' + buttonName).click();
            }
            else
            {
                console.log("Can't find the panel titled " + panelName);
                assert.fail("Failed to find panel titled " + panelName);
            }
        }

        this.waitForDocumentReady();
        
        var fail = false;
        try {
            if (browser.alertText()) {
                browser.alertAccept();
                fail = true;
            }
        }
        catch (error) {

        }
        if (fail) {
            assert.fail("Alert popup detected");
        }
    }
    
};
