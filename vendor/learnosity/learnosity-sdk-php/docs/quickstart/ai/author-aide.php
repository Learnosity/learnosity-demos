<?php

    /**
     * Copyright (c) 2021 Learnosity, MIT License
     *
     * Basic example of embedding Author aide API
     */

    // - - - - - - Section 1: server-side configuration - - - - - - //

    // Include server side Learnosity SDK, and set up variables related to user access
    require_once __DIR__ . '/../../../bootstrap.php';
    $config = require_once __DIR__ . '/../config.php'; // Load security keys from config.php.
    use LearnositySdk\Request\Init;

    // Author aide API configuration parameters.
    $request = [
        'user' => [
            'id'       => 'brian',
            'firstname' => 'Brian',
            'lastname' => 'Smith',
            'email' => 'test@test.com'
        ]
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

    // Use Learnosity SDK to construct Author aide API configuration parameters,
    // and sign them securely with the $security and $consumerSecret parameters.
    $init = new Init(
        'authoraide',
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
        <h1> AuthorAide Example</h1>

        <!-- Author aide API will render the author app into this div. -->
        <div id="aiApp"></div>

        <!-- Include the Author aide API library. -->
        <script src="https://authoraide.learnosity.com"></script>

        <!-- Initiate Author aide API rendering, using the JSON blob of signed params. -->
        <script>
            var authoraideApp = LearnosityAuthorAide.init(
                <?php echo $initOptions ?>,
                '#aiApp'
            );
        </script>
    </body>
</html>
