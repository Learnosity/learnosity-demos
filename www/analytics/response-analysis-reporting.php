<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$request = [
    "reports" => [
        [
            "id" => "response-analysis-report",
            "type" => "response-analysis-by-item",
            "session_ids" => [
                "c8df0f45-2bfd-4d6c-9de1-20200224c001",
                "c8df0f45-2bfd-4d6c-9de1-20200224c002",
                "c8df0f45-2bfd-4d6c-9de1-20200224c003",
                "c8df0f45-2bfd-4d6c-9de1-20200224c004",
                "c8df0f45-2bfd-4d6c-9de1-20200224c005",
                "c8df0f45-2bfd-4d6c-9de1-20200224c006",
                "c8df0f45-2bfd-4d6c-9de1-20200224c007",
                "c8df0f45-2bfd-4d6c-9de1-20200224c008",
                "c8df0f45-2bfd-4d6c-9de1-20200224c009",
                "c8df0f45-2bfd-4d6c-9de1-20200224c010",
                "c8df0f45-2bfd-4d6c-9de1-20200224c011",
            ],
            "users" => [
                ["id" => "user_20200224a_00001", "name" => "Milhouse Vanhouten"],
                ["id" => "user_20200224c_00002", "name" => "Bart Simpson"],
                ["id" => "user_20200224c_00003", "name" => "Sherri Mackleberry"],
                ["id" => "user_20200224c_00004", "name" => "Nelson Muntz"],
                ["id" => "user_20200224c_00005", "name" => "Terri Mackleberry"],
                ["id" => "user_20200224c_00006", "name" => "Lewis Clark"],
                ["id" => "user_20200224c_00007", "name" => "Adrian Belew"],
                ["id" => "user_20200224c_00008", "name" => "Martin Prince"],
                ["id" => "user_20200224c_00009", "name" => "Wendell Borton"],
                ["id" => "user_20200224c_00010", "name" => "Nina Skalka"],
                ["id" => "user_20200224c_00011", "name" => "Sophie Jensen"],
            ],
            "item_reference_map" => [
                ["reference" => "20200224_responseAnalysis_i01", "name" => "Item 1" ],
                ["reference" => "20200224_responseAnalysis_i02", "name" => "Item 2" ],
                ["reference" => "20200224_responseAnalysis_i03", "name" => "Item 3" ],
                ["reference" => "20200224_responseAnalysis_i04", "name" => "Item 4" ],
                ["reference" => "20200224_responseAnalysis_i05", "name" => "Item 5" ],
                ["reference" => "20200224_responseAnalysis_i06", "name" => "Item 6" ],
                ["reference" => "20200224_responseAnalysis_i07", "name" => "Item 7" ],
                ["reference" => "20200224_responseAnalysis_i08", "name" => "Item 8" ],
                ["reference" => "20200224_responseAnalysis_i09", "name" => "Item 9" ],
                ["reference" => "20200224_responseAnalysis_i10", "name" => "Item 10"]
            ]
        ]
    ]
];

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Response Analysis Reporting</h2>
            <p>Our out-of-the-box response analysis report lets educators view a summary of students’ responses at a glance so they can quickly identify common misconceptions and take targeted actions to address individual or group needs.</p>
        </div>
    </div>
    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="response-analysis-by-item">Response Analysis by Item</a></h3>
        <p>See a summary of class responses at a glance:</p>
        <ul>
            <li>Click on an Item header to drill into the detail view and see full responses.</li>
            <li>Within the detail view, click on student names to highlight groupings of students who responded the same way.</li>
        </ul>
        <div id="response-analysis-report"></div>
    </div>

    <style>
        /* Temporary fix for missing min-height. */
        #response-analysis-report > div {
            height: 600px;
        }
    </style>

    <script src="<?php echo $url_reports; ?>"></script>
    <script>

        var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
