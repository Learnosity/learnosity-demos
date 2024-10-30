<?php

    /**
     * Copyright (c) 2021 Learnosity, MIT License
     *
     * Basic example of embedding student reports using Reports API.
     */

    // - - - - - - Section 1: server-side configuration - - - - - - //

    // Include server side Learnosity SDK, and set up variables related to user access
    require_once __DIR__ . '/../../../bootstrap.php';
    $config = require_once __DIR__ . '/../config.php'; // Load security keys from config.php.
    use LearnositySdk\Request\Init;

    $request = [
        // Array of report objects, one per report to render.
        'reports' => [
            // First report object.
            [
                'type'        => 'sessions-summary',    // Desired report to render.
                'id'          => 'quickstart-report-1', // ID of the <span> in which to render.
                'user_id'     => 'student_0001',        // Unique student identifier.
                'session_ids' => ['ef4f80b8-e281-41f4-9efd-349b7eb9dd37'] // The session(s) to report on.
            ],
            // Second report object.
            [
                'type'        => 'sessions-summary-by-tag',
                'id'          => 'quickstart-report-2',
                'user_id'     => 'student_0001',
                'session_ids' => [ 'ef4f80b8-e281-41f4-9efd-349b7eb9dd37' ],

                // This report requires a preconfigured 'tag hierarchy', which is used to categorize
                // the student's score into a drill down report of learning areas.
                'hierarchy'   => 'quickstart_examples_hierarchy_001'
            ],
        ]
    ];

    // Public & private security keys required to access Learnosity APIs and
    // data. These keys grant access to Learnosity's public demos account,
    // loaded from a configuration file on line 12.
    // Learnosity will provide keys for your own private account.
    $consumerKey = $config['consumerKey'];
    $consumerSecret = $config['consumerSecret'];

    // Parameters used to create security authorization.
    $security = [
        'domain'       => $_SERVER['SERVER_NAME'],
        'consumer_key' => $consumerKey
    ];

    // Use Learnosity SDK to construct Reports API configuration parameters,
    // and sign them securely with the $security and $consumerSecret parameters.
    $init = new Init(
        'reports',
        $security,
        $consumerSecret,
        $request
    );
    $initOptions = $init->generate();
    ?>

<!-- Section 2: Web page content. -->
<!DOCTYPE html>
<html>
    <head><link rel="stylesheet" type="text/css" href="../css/style.css"></head>
    <body>
        <h1>Student Reporting Example</h1>

        <!-- Reports API will render each report into
             the <span> with matching `id` attribute.
        -->
        <h2>Quickstart report 1: individual student assessment results</h2>
        <span class="learnosity-report" id="quickstart-report-1"></span>

        <h2>Quickstart report 2: student performance by subject area</h2>
        <span class="learnosity-report" id="quickstart-report-2"></span>

        <!-- Load the Reports API library -->
        <script src="https://reports.learnosity.com/?latest-lts"></script>

        <!-- Initiate Reports API rendering, using the JSON blob of signed params.  -->
        <script>
            var reportsApp = LearnosityReports.init(
                <?php echo $initOptions ?>
            );
        </script>
    </body>
</html>
