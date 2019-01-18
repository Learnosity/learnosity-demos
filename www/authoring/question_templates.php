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

//simple api request object for item list view, with optional creation of items
$request = [
    'mode'      => 'item_edit',
    'reference' => Uuid::generate(),
    'config'    => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => [
                    'ui'=> [
                        'layout'=> [
                            //set to "debug" to see attribute paths
                            'global_template'=> 'edit_preview'
                        ]
                    ],

                    //hide Learnosity default groups
					"template_defaults" => false,

                    //add one custom croup
                    "question_type_groups" => [[
                        "name" => "Custom Multiple Choice",
                        "reference" => "custommcq"
                    ]],

                    "question_type_templates" => [
                        "mcq" => [
                            [
								//always-visible name in add question tile view
								"name" => "MCQ - No student-facing defaults",
                                //rollover description in add question tile view
                                "description" => "MCQ without default distractor/stimulus values",
                                //custom question_type_group reference
                                "group_reference" => "custommcq",
                                //hidden elements not in a section
                                "hidden" => ["description", "penalty_score"],
                                //path to thumbnail
                                "image" => "//dw6y82u65ww8h.cloudfront.net/questiontypes/templates/qev3/mcqdefault.png",
                                //terms for search field in add question tile view to filter matching question templates
                                "hidden_search_terms" => ["mcq", "mc", "true", "false", "yes", "no",],
                                //new UUID reference for custom template
                                "reference" => "d2b4cda2-8381-4607-bca0-0eafeb9c6a63",
                                //question data defaults
                                "defaults" => [
                                    "options" => [
                                        [
                                            "label" => "",
                                            "value" => "0"
                                        ], [
                                            "label" => "",
                                            "value" => "1"
                                        ], [
                                            "label" => "",
                                            "value" => "2"
                                        ], [
                                            "label" => "",
                                            "value" => "3"
                                        ]
                                    ],
                                    "stimulus" => "",
                                    "type" => "mcq",
                                    "validation" => [
                                        "scoring_type" => "exactMatch",
                                        "valid_response" => [
                                            "score" => 1,
                                            "value" => [""]
                                        ]
                                    ]
                                ]
                            ], [
                                //see MCQ - "No student-facing defaults" template above for all comments
								"name" => "MCQ Multi - Simple UI",
								"description" => "MCQ Multi - No shuffle, multi-response, scoring extras, or layout options",
								"group_reference" => "custommcq",
								"hidden" => [
								        "description", "multiple_responses", "shuffle_options",
                                        "validation.automarkable","validation.min_score_if_attempted"
                                ],
                                //hidden sections. note that not all elements appear in sections, to support layout versatility.
                                //e.g. validation-related elements appear in More Options so they needn't clutter the answer area
                                "hidden_sections" => ["scoring","validation.automarkable_fields","layout"],
								"image" => "//dw6y82u65ww8h.cloudfront.net/questiontypes/templates/qev3/mcqmulti.png",
								"hidden_search_terms" => ["mcq", "mc", "multi"],
								"reference" => "f3764936-aab4-4e74-980d-58f7b0b2933b",
								"defaults" => [
									"options" => [
										[
											"label" => "[Choice A]",
											"value" => "0"
										], [
											"label" => "[Choice B]",
											"value" => "1"
										], [
											"label" => "[Choice C]",
											"value" => "2"
										], [
											"label" => "[Choice D]",
											"value" => "3"
										]
									],
									"stimulus" => "[This is the stem.",
									"type" => "mcq",
									"multiple_responses" => true,
									"validation" => [
										"scoring_type" => "exactMatch",
										"valid_response" => [
											"score" => 1,
											"value" => [""]
										]
									]
								]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
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

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Build Custom Question Templates</h2>
            <p>Create your own question templates that customize portions of the question editor layout and pre-populate the new question data with default values.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the author api to load into -->
        <div id="learnosity-author"></div>
    </div>

    <script src="<?php echo $url_authorapi; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
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
