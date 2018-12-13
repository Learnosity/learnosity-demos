
<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;


$item_ref = Uuid::generate();

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'mode'      => 'item_edit',
    'reference' => $item_ref,
    'config'    => array(
        'item_edit' => array(
            'widget' => array(
                'edit'   => true,
                'delete' => true
            )
        ),
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => array(
                    'ui' => array(
                        'layout'             => 'edit_preview',
                        'public_methods'     => array(),
                        'question_tiles'     => false,
                        'documentation_link' => false,
                        'change_button'      => true,
                        'source_button'      => false,
                        'fixed_preview'      => true,
                        'advanced_group'     => false,
                        'search_field'       => false
                    ),
                    'question_type_templates' => json_decode('{
        "custom_box_whisker": {
            "group_reference": "custom_q_types",
            "name": "Box & Whisker",
            "defaults": {
                "type": "custom",
                "js": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker_js.php",
                "css" : "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker.css",
                "stimulus": "Draw a <b>box & whisker</b> chart for the following: <b>6, 2, 5, 3, 6, 10, 11, 6</b>",
      "params_line_min": 0,
      "params_line_max": 17,
      "params_step": 0.5,
      "params_mark_small": 0,
      "params_mark_big": 1,
      "params_width": 600,
      "params_height": 150,
      "params_range_1": 2,
      "params_range_2": 14,
      "params_quartile_1": 4,
      "params_median": 6,
      "params_quartile_3": 10,
      "params_box1_color": "#bbbbbb",
      "params_box2_color": "#999999",
      "valid_range_1": 2,
      "valid_range_2": 11,
      "valid_quartile_1": 4,
      "valid_median": 6,
      "valid_quartile_3": 8.5,
      "score": 1
            },
            "description": "Create a box & whisker plot."
        }
    }'),
                    'question_type_groups' => json_decode('[
        {
            "name": "Custom Question Types",
            "reference": "custom_q_types"
        }
    ]'),
                    'custom_question_types' => json_decode('[
        {
            "version": "0.0.1",
            "name": "Box & Whisker",
            "custom_type": "custom_box_whisker",
            "editor_layout": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker_template.html",
            "type": "custom",
            "editor_schema": {
                "hidden_question": false,
                "attributes": {
                    "params_line_min": {
                        "type": "number",
                        "required": true,
                        "default": 0,
                        "name": "params_line_min"
                    },
                    "params_line_max": {
                        "type": "number",
                        "required": true,
                        "default": 17,
                        "name": "params_line_max"
                    },
                    "params_step": {
                        "type": "number",
                        "required": true,
                        "default": 0.5,
                        "name": "params_stepn"
                    },
                    "params_mark_small": {
                        "type": "number",
                        "required": true,
                        "default": 0,
                        "name": "params_mark_small"
                    },
                    "params_mark_big": {
                        "type": "number",
                        "required": true,
                        "default": 1,
                        "name": "params_mark_big"
                    },
                    "params_width": {
                        "type": "number",
                        "required": true,
                        "default": 600,
                        "name": "params_width"
                    },
                    "params_height": {
                        "type": "number",
                        "required": true,
                        "default": 150,
                        "name": "params_height"
                    },
                    "params_range_1": {
                        "type": "number",
                        "required": true,
                        "default": 2,
                        "name": "params_range_1"
                    },
                    "params_range_2": {
                        "type": "number",
                        "required": true,
                        "default": 14,
                        "name": "params_range_2"
                    },
                    "params_quartile_1": {
                        "type": "number",
                        "required": true,
                        "default": 4,
                        "name": "params_quartile_1"
                    },
                    "params_median": {
                        "type": "number",
                        "required": true,
                        "default": 6,
                        "name": "params_median"
                    },
                    "params_quartile_3": {
                        "type": "number",
                        "required": true,
                        "default": 10,
                        "name": "params_quartile_3"
                    },
                    "params_box1_color": {
                        "type": "string",
                        "required": true,
                        "default": "#bbbbbb",
                        "name": "params_box1_color"
                    },
                    "params_box2_color": {
                        "type": "string",
                        "required": true,
                        "default": "#999999",
                        "name": "params_box2_color"
                    },
                    "valid_range_1": {
                        "type": "number",
                        "required": true,
                        "default": 2,
                        "name": "valid_range_1"
                    },
                    "valid_range_2": {
                        "type": "number",
                        "required": true,
                        "default": 11,
                        "name": "valid_range_2"
                    },
                    "valid_quartile_1": {
                        "type": "number",
                        "required": true,
                        "default": 4,
                        "name": "valid_quartile_1"
                    },
                    "valid_median": {
                        "type": "number",
                        "required": true,
                        "default": 6,
                        "name": "valid_median"
                    },
                    "valid_quartile_3": {
                        "type": "number",
                        "required": true,
                        "default": 8.5,
                        "name": "valid_quartile_3"
                    },
                    "score": {
                        "type": "number",
                        "required": true,
                        "default": 1,
                        "name": "score"
                    }
                }
            },
            "js": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker_js.php",
            "css" : "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker.css"
        }
    ]'),
                    'dependencies' => [
                        'questions_api' => [
                            'init_options' => [
                                'beta_flags' => [
                                    'reactive_views' => true
                                ]
                            ]
                        ]
                    ]
                )
            ],
            'questions_api' => [
                'init_options' => [
                    'beta_flags' => [
                        'reactive_views' => true
                    ]
                ]
            ]
        ]
    ),
    'user' => array(
        'id'        => 'demos-site',
        'firstname' => 'Demos',
        'lastname'  => 'User',
        'email'     => 'demos@learnosity.com'
    )
);

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h1>End to End Demo – Authoring</h1>
        <p>Learnosity's Author API enable professional authors (as well as teachers) to create and edit content.</p>
        <p>Questions are saved to the Learnosity item bank to be included in the assessment.</p>
    </div>
</div>

<div class="section">
    <div class="row">
        <div id="notifications" class="col-md-2"></div>
        <div class="col-md-10">
            <div id="learnosity-author"></div>
        </div>
    </div>
    <p class="text-right">
        <br>
        <a class="btn btn-primary btn-md btn-addMore">Add more</a>
        <a class="btn btn-primary btn-md btn-goToAssessment">Go to Assessment</a>
    </p>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>;
    var itemIDs = new Array();
    var activeItemID = '<?php echo $item_ref; ?>';


    var authorApp = LearnosityAuthor.init(initOptions, {

        readyListener: function () {
            authorApp.on('save:success', function (event) {
                saveItemID(activeItemID);
            });
        }

    });

    $(document).ready(function(){
        //add more question handler
        $(".btn-addMore").click(function(){
            activeItemID = guid();
            authorApp.setItem(activeItemID);
        });
        //go to assessment handler
        $(".btn-goToAssessment").click(function(){
            window.location = 'assessment.php?itemIDs=' + itemIDs.join(",");
        });
    });

    function showNotification (itemID) {
         var $message = $('<a/>').text('Item ' + itemIDs.length)
                                 .attr('onclick','editItem("' + itemID + '")')
                                 .attr('style','cursor:pointer')
        var $closeBtn = $('<button/>').attr('type', 'button')
                                      .attr('data-dismiss', 'alert')
                                      .attr('aria-hidden', 'true')
                                      .attr('title', 'Delete question')
                                      .attr('onclick', 'removeItem("' + itemID + '")')
                                      .addClass('close')
                                      .text('×');
        var $notification = $('<div/>').addClass('alert alert-info alert-dismissable')
                                       .attr('id', 'ItemNotification' + itemID)
                                       .append($closeBtn)
                                       .append($message);
        $('#notifications').append($notification);
    }

    function guid() {
      function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
          .toString(16)
          .substring(1);
      }
      return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
        s4() + '-' + s4() + s4() + s4();
    }

    function saveItemID(itemID) {
        if(jQuery.inArray(itemID, itemIDs) == -1){
            itemIDs.push(itemID);
            showNotification(itemID);
        }
    }

    function removeItem(itemID) {
        itemIDs.splice(itemIDs.indexOf(itemID), 1);
        $("#ItemNotification" + itemID).remove();
    }

    function editItem(itemID) {
        activeItemID = itemID;
        authorApp.setItem(itemID);
    }
</script>


<?php
    include_once 'includes/footer.php';
