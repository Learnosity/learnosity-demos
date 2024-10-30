<?php

    /**
     * Copyright (c) 2021 Learnosity, MIT License
     *
     * Basic example of embedding Author API for creating Items,
     * using mode: item_list.
     */

    // - - - - - - Section 1: server-side configuration - - - - - - //

    // Include server side Learnosity SDK, and set up variables related to user access.
    require_once __DIR__ . '/../../../bootstrap.php';
    $config = require_once __DIR__ . '/../config.php'; // Load security keys from config.php.
    use LearnositySdk\Request\Init;

    // Author API configuration parameters.
    $request = [
        'mode' => 'item_list', // Display the Item list view on load.
        'title.show' => true,
        'user' => [
            'id'       => 'author123456' // Unique author id
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
        'consumer_key' => $consumerKey,
    ];

    // Use Learnosity SDK to construct Author API configuration parameters,
    // and sign them securely with the $security and $consumerSecret parameters.
    $init = new Init(
        'author',
        $security,
        $consumerSecret,
        $request
    );
    $initOptions = $init->generate(); // JSON blob of signed config params.
    ?>

<!-- Section 2: Web page content. -->
<!DOCTYPE html>
<html>
    <head><link rel='stylesheet' type='text/css' href='../css/style.css'></head>
    <body>
        <h1>Authoring Items Example</h1>

        <!-- Author API will render the author app into this div. -->
        <div id='learnosity-author'></div>

        <!-- Include the Author API library. -->
        <script src='https://authorapi.learnosity.com?latest-lts'></script>

        <!-- Initiate Author API rendering, using the JSON blob of signed params. -->
        <script>
            var authorApp = LearnosityAuthor.init(
                <?php echo $initOptions ?>
            );
        </script>
    </body>
</html>
