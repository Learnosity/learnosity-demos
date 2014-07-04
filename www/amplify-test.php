<?php

    include_once 'config.php';
    include_once 'includes/header.php';

    use LearnositySdk\Request\Init;
    use LearnositySdk\Utils\Uuid;

    $security = array(
        'consumer_key' => $consumer_key,
        'domain'       => $domain
    );

// "questionsApiVersion":"v2"
// "assessApiVersion":"v2"

// 'ignore_validation'   => false,
// 'questionsApiVersion' => 'v2',
// 'assessApiVersion'    => 'v2',

    $request = array(
        'activity_id'    => 'Challenge_G6_U10_L2',
        'name'           => 'Challenge_G6_U10_L2',
        'rendering_type' => 'assess',
        'state'          => 'initial',
        'type'           => 'local_practice',
        'course_id'      => $courseid,
        'session_id'     => Uuid::generate(),
        'user_id'        => "denis",
        'items'          => array("act5","dd_00d355"),
        'config'         => array(
            'title'          => 'Challenge_G6_U10_L2: denis',
            'navigation' => array(
                'scroll_to_top'             => false,
                'scroll_to_test'            => false,
                'show_fullscreencontrol'    => true,
                'show_next'                 => true,
                'show_prev'                 => true,
                'show_save'                 => false,
                'show_submit'               => false,
                'show_title'                => true,
                'show_intro'                => false,
                'show_outro'                => false,
                'toc'                       => true,
            ),
                'time' => array(
                'max_time'     => 600,
                'limit_type'   => 'soft',
                'show_pause'   => false,
                'warning_time' => 60,
                'show_time'    => false
            ),
            'labelBundle' => array(
                'item' => 'Question'
            ),
            'ui_style'            => 'main',
            'configuration'       => array(
                'fontsize'   => 'normal',
                'questionsApiVersion' => 'v2',
                'assessApiVersion'    => 'v2'
            )
        )
    );

    include_once 'utils/settings-override.php';

    $Init = new Init('items', $security, $consumer_secret, $request);
    $signedRequest = $Init->generate();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta charset="utf-8">
        <title>Challenge_G6_U10_L2: denis</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="http://www.xrgb.com/amplify/learnosity/www/static/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="http://www.xrgb.com/amplify/learnosity/www/static/vendor/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="http://www.xrgb.com/amplify/learnosity/www/static/vendor/reveal/reveal.css">
        <link rel="stylesheet" href="http://www.xrgb.com/amplify/learnosity/www/static/vendor/codemirror/codemirror.css">
        <link rel="stylesheet" href="http://www.xrgb.com/amplify/learnosity/www/static/vendor/ladda/ladda.min.css">
        <link rel="stylesheet" href="http://www.xrgb.com/amplify/learnosity/www/static/css/main.css">
        <script src="http://www.xrgb.com/amplify/learnosity/www/static/vendor/jquery/jquery-1.11.0.min.js"></script><style type="text/css"></style>
        <script src="http://www.xrgb.com/amplify/learnosity/www/static/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="http://www.xrgb.com/amplify/learnosity/www/static/js/prettyPrint.js"></script>
        <script src="http://www.xrgb.com/amplify/learnosity/www/assessment/assess/readiness_utils.js"></script>
    </head>
    <body style="padding:0;">
        <div class="container">
            <div class="row">
                <button id="finish_button" style="float:right;margin:10px;padding:5px;" onclick="sendToReport()">Finish</button>
                <button id="check_button" style="float:right;margin:10px;padding:5px;" onclick="lrnItems.validateQuestions();">Check Answers</button>
                <div id="report">
                    <div>
                        <!-- Container for the assess api to load into -->
                        <span id="learnosity_assess" class="learnosity-assess"></span>
                    </div>
                </div>
                <script src="//items.staging.learnosity.com"></script>
                <script>
                    var eventOptions = {
                            readyListener: function () {
                            }
                        },
                        lrnItems = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

                    function sendToReport() {
                        var testName = "Challenge_G6_U10_L2: denis";
                        var itemList = ["Jump6_G_9_1_bi","Jump6_G_9_1_biii"] ;
                        var sessionId = "session-54bc7344-bcf7-4d22-9e1d-56c0b6dd4768_";

                        var activityId = "Challenge_G6_U10_L2";
                        var activityTitle = "Challenge_G6_U10_L2";

                        generate_report(itemList, sessionId, testName, '../../assignment-login.html?activity_id=' + activityId + '&activity_title=' + activityTitle, '../../assignment-menu.php');
                    }
                </script>
            </div></div>
        </body>
    </html>
