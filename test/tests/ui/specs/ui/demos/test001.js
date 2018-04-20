const DemosPage = require('../../../pageObjects/demosPage');

const dataItems = [ 
    // data
    ['Demos', 'Authoring', 'Author API', 'Activity List', 'Demo'],
    ['Demos', 'Authoring', 'Author API', 'Item List', 'Demo'],
    ['Demos', 'Authoring', 'Author API', 'Item List – Routing', 'Demo'],
    ['Demos', 'Authoring', 'Author API', 'Activity Edit', 'Demo'],
    ['Demos', 'Authoring', 'Author API', 'Item Edit', 'Demo'],
    ['Demos', 'Authoring', 'Author API', 'Item List – Simple authoring', 'Demo'],
    ['Demos', 'Authoring', 'Author API', 'Item Edit – Events', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V3', 'Full examples', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V3', 'Edit panel layout', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V3', 'Custom Question Editor Templates', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V3', 'Simple Layouts', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V3', 'Directly Edit a Question', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V3', 'Teacher Authoring', 'MCQ'],
    ['Demos', 'Authoring', 'Question Editor API V3', 'Teacher Authoring', 'Math'],
    ['Demos', 'Authoring', 'Question Editor API V3', 'Teacher Authoring', 'Cloze D&D'],
    ['Demos', 'Authoring', 'Question Editor API V3', 'Test Dynamic Content with Questions Editor', 'Demo (Algorithmic Math)'],
    ['Demos', 'Authoring', 'Question Editor API V2', 'Full examples', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V2', 'Directly Edit a Question', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V2', 'Custom Question Type Templates', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V2', 'Digital Asset Management', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V2', 'Customise', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V2', 'Features', 'Demo'],
    ['Demos', 'Authoring', 'Question Editor API V2', 'Teacher Authoring', 'Demo (Match List)'],
    ['Demos', 'Authoring', 'Question Editor API V2', 'Teacher Authoring', 'Demo (Plot Points)'],
    ['Demos', 'Authoring', 'Question Editor API V2', 'Test Custom Initialisation JSON', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Use our Assessment Layer', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Accessibility', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Formative Distractor Rationale', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Item Branching Assessment', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Testlet Adaptive Assessment', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Failed Submission', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Restrict Responses Demo', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Render Questions Inline (no Assessment Layer)', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Worked Solutions (hints)', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Activities', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Item Adaptive Assessment', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Sections', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Locking Questions', 'Demo'],
    ['Demos', 'Assessment', 'Items API', 'Texthelp Demo', 'Demo'],
    ['Demos', 'Assessment', 'Questions API', 'Question Types Overview', 'Demo'],
    ['Demos', 'Assessment', 'Questions API', 'Math Formula Question Type', 'Demo'],
    ['Demos', 'Assessment', 'Questions API', 'Advanced Audio Examples', 'Demo'],
    ['Demos', 'Assessment', 'Questions API', 'Features', 'Demo'],
    ['Demos', 'Assessment', 'Questions API', 'Graph Plotting Question Type', 'Demo'],
    ['Demos', 'Assessment', 'Assess API', '', ''],
    ['Demos', 'Analytics', 'Reports API', 'Report Types', 'Demo'],
    ['Demos', 'Analytics', 'Reports API', 'Live Progress Tracking', 'Demo'],
    ['Demos', 'Analytics', 'Reports API', 'No UI (Raw data only)', 'Demo'],
    ['Demos', 'Analytics', 'Reports API', '', ''],
    ['Demos', 'Case Studies', 'Teacher Feedback', 'Rich Feedback', 'Demo'],
    ['Demos', 'Case Studies', 'Teacher Feedback', 'Simple Scoring', 'Demo'],
    ['Demos', 'Case Studies', 'Printing Items', 'Printing Demo', 'Demo'],
    ['Demos', 'Case Studies', 'Printing Items', 'Printing Key Answer Demo', 'Demo'],
    ['Demos', 'Case Studies', 'Gallery Style UI', '', ''],
    ['Demos', 'Case Studies', 'xAPI Events', '', ''],
    ['Demos', 'Case Studies', 'End to End Demo', 'End to End (Add items)', 'Demo'],
    ['Demos', 'Case Studies', 'End to End Demo', 'End to End (Select existing items)', 'Demo'],
    ['Demos', 'Case Studies', 'Custom Questions', 'Custom Short Text', 'Demo'],
    ['Demos', 'Case Studies', 'Custom Questions', 'Custom Mathcore', 'Demo'],
    ['Demos', 'Case Studies', 'Custom Questions', 'Custom Implementation', 'Demo'],
    ['Demos', 'Case Studies', 'Custom Questions', 'Custom Percentage Bar', 'Demo'],
    ['Demos', 'Case Studies', 'Custom Questions', 'Custom Box Whisker', 'Demo'],
    ['Demos', 'Case Studies', 'Spanish Demo', '', ''],
];

let demosPage;

describe('site-demos', function () {
        var originalTimeout;
        
        beforeEach(function () {
            originalTimeout = jasmine.DEFAULT_TIMEOUT_INTERVAL;
            jasmine.DEFAULT_TIMEOUT_INTERVAL = 120000;
            demosPage = new DemosPage();
            // demosPage.load('https://demos.learnosity.com/');
        });

        afterEach(function() {
          jasmine.DEFAULT_TIMEOUT_INTERVAL = originalTimeout;
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
            // it(section1 + '/' + section2 + '/' + section3 + '/' + section4, function () {
            it('test001', function () {
                demosPage.load('https://demos.learnosity.com/');
                demosPage.panelClick(section2, section3, section4, section5);
            });
        });
    
    });
    