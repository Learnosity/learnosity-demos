<?php

include_once '../config.php';
include_once 'utils/uuid.php';
include_once 'utils/RequestHelper.php';
include_once 'includes/header.php';

$uniqueResponseIdSuffix = UUID::generateUuid();
$assessdomain = 'assess.learnosity.com';
$activitySignature = hash("sha256", $consumer_key . '_' . $assessdomain . '_' . $timestamp . '_' . $studentid . '_' . $consumer_secret);
$request = array(
    'name'       => 'Demo Activity',
    'state'      => 'initial',
    'navigation' => array(
        'scroll_to_top'          => false,
        'scroll_to_test'         => false,
        'show_fullscreencontrol' => true,
        'show_next'              => true,
        'show_prev'              => true,
        'show_save'              => false,
        'show_submit'            => true,
        'show_title'             => true,
        'intro_sheet'            => '',
        'show_intro'             => true,
        'toc'                    => array(
            'show_itemcount' => true
        )
    ),
    'time' => array(
        'max_time'     => 600,
        'limit_type'   => 'soft',
        'show_pause'   => true,
        'warning_time' => 60,
        'show_time'    => true
    ),
    'labelBundle' => array(
        'appName' => 'Assess Demo',
        'sheet'   => 'Question'
    ),
    'ui_style'      => 'main',
    'configuration' => array(
        'questionsApiVersion'   => 'v2',
        'fontsize'              => 'normal',
    ),
    'questionsApiActivity' => json_decode(
        '{
            "consumer_key": "' . $consumer_key . '",
            "timestamp": "' . $timestamp . '",
            "signature": "' . $activitySignature . '",
            "user_id": "' . $studentid . '",
            "type": "submit_practice",
            "state": "initial",
            "id": "assessdemo_' . UUID::generateUuid() . '",
            "name": "Assess API - Demo",
            "course_id": "' . $courseid . '"
        }')
);

$signedRequest = Json::encode($request);


?>
<style>
.connected, .sortable, .exclude, .handles {
    margin: auto;
    padding: 0;
    width: 100%;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.sortable.grid {
    overflow: hidden;
}
.connected li, .sortable li, .exclude li, .handles li {
    list-style: none;
    border: 1px solid #CCC;
    background: #F6F6F6;
    font-family: "Tahoma";
    color: #1C94C4;
    margin: 5px;
    padding: 5px;
    height: 22px;
}
.handles span {
    cursor: move;
}
li.disabled {
    opacity: 0.5;
}
.sortable.grid li {
    line-height: 80px;
    float: left;
    width: 80px;
    height: 80px;
    text-align: center;
}
li.highlight {
    background: #FEE25F;
}
#connected {
    width: 440px;
    overflow: hidden;
    margin: auto;
}
.connected {
    float: left;
    width: 200px;
}
.connected.no2 {
    float: right;
}
li.sortable-placeholder {
    border: 1px dashed #CCC;
    background: none;
}
</style>
    <div class="jumbotron">
    <h1>End to End - Authoring</h1>
    <p>Create the Questions you want, and take the test!<p>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-10">
            <form id="item_ref" style="float:right">
                <fieldset>
                    <input id="reference" placeholder="Reference">
                    <input id="description" placeholder="Description">

                    <button id="save" class="btn btn-primary btn-md">Save</button>
                    <button id="new" class="btn btn-success btn-md">New</button>
                    <button id="delete" class="btn btn-danger btn-md">Delete</button>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="text-center">
                <h4>Questions</h4>
            </div>
            <hr>
            <ul class="sortable">
                <li id="mcq_geo_irish_1"><span>::</span>Irish Geo 1</li>
                <li id="formula_math_g_3"><span>::</span>Math Equation 1</li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="learnosity-question-editor"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary btn-lg btn-block center-block btn-blurb" id="taketest"  data-toggle="modal" data-target="#initialisation-preview">Take the test!</a>
            </div>
        </div>
        <br>
    </div>
    <script src="//questioneditor.learnosity.com"></script>
    <script src="//assess.learnosity.com"></script>
    <script src="<?php echo $env['www'] ?>static/vendor/jquery/jquery.sortable.min.js"></script>

    <script>


    var questions = {
        "mcq_geo_irish_1" : {
            "instant_feedback": true,
            "options": [{
                "value": "0",
                "label": "Dublin"
            }, {
                "value": "1",
                "label": "Galway"
            }, {
                "value": "2",
                "label": "Maynooth"
            }],
            "stimulus": "<h3>What is the capital city of Ireland?</h3>\n",
            "type": "mcq",
            "ui_style": {},
            "validation": {
            "scoring_type": "exactMatch",
                "valid_response": {
                    "value": ["0"]
                }
            }
        },
        "formula_math_g_3" : {
            "instant_feedback": true,
            "is_math": true,
            "stimulus": "<h3>Enter the formula for the roots of a Quadratic Equation</h3>\n",
            "template": "\\frac{-b \\pm \\sqrt{{{response}}^2 - {{response}}c}}{{{response}}}",
            "type": "formula",
            "validation": {
        "scoring_type": "exactMatch",
        "valid_response": {
            "value": [{
                "method": "equivSymbolic",
                "value": "\\frac{-b \\pm \\sqrt{b^2 - 4ac}}{2a}",
                "options": {
                    "allowDecimal": false
                }
            }]
        }
    }
        }
    };

    var selected;
    var lrnActivity = LearnosityQuestionEditor.init();
    var initOptions = <?php echo $signedRequest; ?>;

    function guid() {
      function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
                   .toString(16)
                   .substring(1);
      }
      return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
             s4() + '-' + s4() + s4() + s4();
    }

    var addListClick = function() {
        console.log($(this));
        console.log($(this).attr("id"));
        console.log(questions[$(this).attr("id")]);
        lrnActivity.setJson(questions[$(this).attr("id")]);
        $('#delete').prop('disabled', false);
        selected = $(this).attr("id");
        $('#reference').val(selected); 
        $('#description').val($(this).html().substr(15));
    }

    var removeElem = function() {
        questions[selected] = null;
        $('.sortable > li#' + selected).remove();
        $('#delete').prop('disabled', true);
        selected = null;
        $('#reference').val(""); 
        $('#description').val("");
        LearnosityQuestionEditor.init();
    }

    var saveElem = function() {
        console.log("hello!");
        if ($('#reference').val() != "") {


            selected = $('#reference').val();

            if ($('#description').val() == "") {
                var desc = selected;
            } else {
                var desc = $('#description').val();
            }

            console.log(selected);

            if(!$(".sortable").has("li#" + selected)[0]) {
                $('.sortable').append($("<li id=\"" + selected + "\"></li>").html("<span>::</span>" + desc));
                $('.sortable').sortable({handle: 'span'});
                $('.sortable > li#' + selected).click(addListClick);
            }
            lrnActivity.getJson(function(json) {
                console.log(json);
                questions[selected] = json;
            });
            $('#delete').prop('disabled', false);
        } else {
            alert("Please enter a reference id");
        }
        return false;
    }

    var newElem = function() {
        selected = null;
        LearnosityQuestionEditor.init();
    }

    var takeTest = function() {
        var session_id = guid();
        var items = [];
        var questionList = [];

        $(".sortable > li").each(function( index ) {
            var identifier = $(this).attr("id");
            var question = questions[identifier];
            var item = {
                "reference" : identifier,
                "content" : "<span class=\"learnosity-response question-" + identifier + session_id + "\"></span>",
                "workflow" : [],
                "response_ids" : [ identifier + session_id ],
                "feature_ids" : [] 
            };
            console.log(identifier);
            console.log(question);
            console.log(questions);
            question.response_id = identifier + session_id;


            questionList.push(question);
            items.push(item);


        });
        initOptions.items = items;
        initOptions.questionsApiActivity.questions = questionList;
        LearnosityAssess.init(initOptions, "learnosity_assess");
    }




    $('#delete').prop('disabled', true);
    $('#delete').click(removeElem);
    $('#save').click(saveElem);
    $('#new').click(newElem);
    $('#taketest').click(takeTest);

    $('.sortable').sortable({handle: 'span'});
    $('.sortable > li').click(addListClick);




    </script>
    <script src="<?php echo $env['www'] ?>static/vendor/head.min.js"></script>
    <?php
    include_once 'views/modals/endtoend-assess.php';
    include_once 'includes/footer.php';
    ?>
