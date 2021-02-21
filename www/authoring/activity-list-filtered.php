<?php

    //common environment attributes including search paths. not specific to Learnosity
    include_once '../env_config.php';

    //site scaffolding
    include_once 'includes/header.php';

    //common Learnosity config elements including API version control vars
    include_once '../lrn_config.php';

    //alias(es) to eliminate the need for fully qualified classname(s) from sdk
    use LearnositySdk\Request\Init;


    //security object. timestamp added by SDK
    $security = [
        'consumer_key' => $consumer_key,
        'domain'       => $domain
    ];

    //simple api request object, with additional common features added and commented
    $request = [
        'mode'      => 'activity_list',
        'config'    => [
            'activity_list' => [
                //demo specific: filter content by user and tag
                'filter' => [
                    'restricted' => [
                        //display only items created by the current user (defined at top-level)
                        'current_user' => false,
                        //display only items created by specific users (array of strings from user.id)
                        "tags" => [
                            //if set to true, then a user can save activities which do not have the tags required by the tag filters below
                            "allow_filtered_tags_overwrite" => true,
                            "all" => [
                                [
                                    "type" => "course",
                                    "name" => ["commoncore"]
                                ],
                                [
                                    "type" => "Grade"
                                ]
                            ],
                            "either" => [
                                [
                                    "type" => "subject",
                                    "name" => ["Math", "English"]
                                ],
                                [
                                    "type" => "Grade",
                                    "name" => ["Grade 11"]
                                ]
                            ],
                            "none" => [
                                [
                                    "type" => "adaptive-lifecycle",
                                    "name" => ["operational"]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        //user for whom this API is initialized. recorded when editing item content.
        'user' => [
            'id'        => 'demos-site',
            'firstname' => 'Demos',
            'lastname'  => 'User',
            'email'     => 'demos@learnosity.com'
        ]
    ];

    $Init = new Init('author', $security, $consumer_secret, $request);
    $signedRequest = $Init->generate();

    ?>

    <!--site scaffolding-->
    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Filter Activities in Your Item Bank</h2>
            <p>The activity list mode allows authors to search the Learnosity hosted item bank for existing activities.
                In this case, we've also passed configuration to only show activities that match certain criteria, using tagging.</p>
        </div>
    </div>


    <div class="section pad-sml">
        <!--HTML placeholder that is replaced by Author API-->
        <div id="learnosity-author"></div>
    </div>


    <!-- version of api maintained in lrn_config.php file -->
    <script src="<?php echo $url_authorapi; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready and/or error event(s)
        var callbacks = {
            readyListener: function () {
                console.log("Author API has successfully initialized.");
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObject, callbacks);
    </script>


<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';