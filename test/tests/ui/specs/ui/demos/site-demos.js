const DemosPage = require('../../../pageObjects/demosPage');

const dataItems = require("./data");

let demosPage;

describe('site-demos', function () {
    
        before(function () {
            demosPage = new DemosPage();
            // demosPage.load('https://demos.learnosity.com/');
        });
    
        it.skip('test1', function () {
    
        });

        dataItems.forEach(function (dataItem) {
            
            // console.log(dataItem)

            var section1 = dataItem[0]
            var section2 = dataItem[1]
            var section3 = dataItem[2]
            var section4 = dataItem[3]
            var section5 = dataItem[4]

            //console.log(section1)
            //console.log(section2)
            //console.log(section3)
            //console.log(section4)
            //console.log(section5)
            it(section1 + '/' + section2 + '/' + section3 + '/' + section4, function () {
                demosPage.load('https://demos.learnosity.com/');
                demosPage.panelClick(section2, section3, section4, section5);
            });
        });
    
    });
    
