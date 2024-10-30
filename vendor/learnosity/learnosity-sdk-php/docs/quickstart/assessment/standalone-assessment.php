<?php

    /**
     * Copyright (c) 2021 Learnosity, MIT License
     *
     * Basic example of embedding a standalone assessment using Items API
     * with `rendering_type: "assess"`.
     */

    // - - - - - - Section 1: server-side configuration - - - - - - //

    // Include server side Learnosity SDK, and set up variables related to user access
    require_once __DIR__ . '/../../../bootstrap.php';
    $config = require_once __DIR__ . '/../config.php'; // Load security keys from config.php.
    use LearnositySdk\Request\Init;
    use LearnositySdk\Utils\Uuid;
    $user_id = Uuid::generate();
    $session_id = Uuid::generate();

    // Items API configuration parameters.
    $request = [
        // Unique student identifier, a UUID generated on line 16.
        'user_id'        => $user_id,
        // A reference of the Activity to retrieve from the Item bank, defining
        // which Items will be served in this assessment.
        'activity_template_id' => 'quickstart_examples_activity_template_001',
        // Uniquely identifies this specific assessment attempt session for
        // save/resume, data retrieval and reporting purposes. A UUID generated on line 17.
        'session_id'     => $session_id,
        // Used in data retrieval and reporting to compare results
        // with other users submitting the same assessment.
        'activity_id'    => 'quickstart_examples_activity_001',
        // Selects a rendering mode, `assess` type is a "standalone" mode (loading a
        //  complete assessment player for navigation, VS `inline`, for embedded).
        'rendering_type' => 'assess',
        // Selects the context for the student response storage. `submit_practice`
        // mode means student response storage in the Learnosity cloud, for grading.
        'type'           => 'submit_practice',
        // Human-friendly display name to be shown in reporting.
        'name'           => 'Items API Quickstart',
        // Can be set to `initial, `resume` or `review`. Optional. Default = `initial`.
        'state'          => 'initial'
    ];

    // Public & private security keys required to access Learnosity APIs and
    // data. These keys grant access to Learnosity's public demos account,
    // loaded from a configuration file on line 13.
    // Learnosity will provide keys for your own private account.
    $consumerKey = $config['consumerKey'];
    $consumerSecret = $config['consumerSecret'];

    // Parameters used to create security authorization.
    $security = [
        'domain'       => $_SERVER['SERVER_NAME'],
        'consumer_key' => $consumerKey
    ];

    // Use Learnosity SDK to construct Items API configuration parameters,
    // and sign them securely with the $security and $consumerSecret parameters.
    $init = new Init(
        'items',
        $security,
        $consumerSecret,
        $request
    );
    $initOptions = $init->generate(); // JSON blob of signed config params.
    ?>

<!-- Section 2: Web page content. -->
<!DOCTYPE html>
<html>
    <head><link rel="stylesheet" type="text/css" href="../css/style.css"></head>
    <body>
        <h1>Standalone Assessment Example</h1>

        <!-- Items API will render the assessment app into this div. -->
        <div id="learnosity_assess"></div>

        <!-- Load the Items API library. -->
        <script src="https://items.learnosity.com/?latest-lts"></script>

        <!-- Initiate Items API assessment rendering, using the JSON blob of signed params. -->
        <script>
            var itemsApp = LearnosityItems.init(
                <?php echo $initOptions ?>
            );
        </script>
    </body>
</html>
