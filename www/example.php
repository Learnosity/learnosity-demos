    <html>

<head>
    <script src="static/vendor/jquery/jquery-1.10.2.min.js"></script>
</head>

<body>



    <?php
    //insert php at top of body
    //this code section generates our security pattern, and creates the initialisation object


    $security = array(
        "consumer_key"    => "yis0TYCu7U9V4o7M",
        //change to knerdx.r.staging.knewton.net
        "domain"          => "demos.vg.learnosity.com",
        "timestamp"       => strftime('%Y%m%d-%H%M'),
        );

    $consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';


    $request = array(
        rendering_type => "inline",
        user_id => "demo_student",
        session_id => "b0280bcb-223c-4c33-a978-88a94d79d901",
        items => array(
            "frac_note_1",
            "frac_note_2",
            "frac_note_3"
            ),
        type => "submit_practice",
        state => "initial",
        activity_id => "itemsassessdemo",
        name => "Items API demo - assess activity",
        course_id => "demo_yis0TYCu7U9V4o7M",
        config => array(
            ignore_validation => false,
            ui_style => "horizontal-fixed",
            questionsApiVersion => 'v2'
            )
        );


    $signatureArray = array_merge(array(), $security);
    array_push($signatureArray, $consumer_secret);
    array_push($signatureArray, json_encode($request));
    $preHashString = implode("_", $signatureArray);
    $security['signature'] = hash('sha256', $preHashString);


    $initOptions = array(
        "security" => $security,
        "request" => $request
    );

    ?>

    <!-- 
        Each of the below three Spans is the insertion point for a question
    -->

    <span class="learnosity-item" data-reference="frac_note_1"></span>
    <span class="learnosity-item" data-reference="frac_note_2"></span>
    <span class="learnosity-item" data-reference="frac_note_3"></span>
        

    <!--
        Insert just before last body tag 
    -->
    <script src="https://items.learnosity.com/"></script>
    <script type="text/javascript">

    //Match Item Names to Module Id's
    var moduleNames = {
        "frac_note_1" : {
            module_id : "6a142970-c7c6-43be-ab65-9a87ebb5f500"
        },
        "frac_note_2" : {
            module_id : "4d4506ee-6590-43cd-a026-6e38c4e5aa98"
        },
        "frac_note_3" : {
            module_id : "86b20c4b-724c-4e6f-afd9-4cf3782a431f"
        },
        getModuleId : function(fullId) {
            var val;
            $.each(this, function(idx, value) {
                if(typeof value !== 'function') {
                    if(fullId.search(idx) >= 0) {
                        val = value.module_id;
                    } else {
                    }
                }
            });
            return val;
        }
    };



    //Trigger initApp on LearnosityApp ready
    var eventOptions = {
        readyListener: initApp
    };

    //put JSON encoded init object into JS
    var initOptions = <?php echo(json_encode($initOptions));?>


    var lrnActiv = LearnosityItems.init(initOptions, eventOptions);

    //generate correctly formatted time string.
    function convertTime ( currDate ) { 
        var dDay = ("0" + currDate.getDate()).slice(-2);
        var dMonth = ("0" + (currDate.getMonth()+1)).slice(-2);
        var dYear = currDate.getFullYear();
        var dHours = ("0" + currDate.getHours()).slice(-2);
        var dMinutes = ("00" + currDate.getUTCMinutes()).slice(-2);
        var dSeconds = ("00" + currDate.getUTCSeconds()).slice(-2);
        var dTimeOffset = ("00" + currDate.getTimezoneOffset()).slice(-2);
        var dTimeOffsetHours = ("00" + Math.abs(Math.floor(dTimeOffset/60))).slice(-2);
        var dTimeOffsetMinutes = ("00" + dTimeOffset%60).slice(-2);
        var dTimeDirection = (dTimeOffset < 0) ? "+" : "-" ;

        return dYear + "-" + dMonth + "-" + dDay + "T" + dHours + ":" + dMinutes + ":" + dSeconds + dTimeDirection + dTimeOffsetHours + ":" + dTimeOffsetMinutes; 
    }

    function initApp() {

        lrnActiv.getQuestions(function(questions){

            /*
                for every question, add event handler to check each time "checkAnswer" is clicked,
                and if the question has been attempted, POST JSON Knewton Object to /event

                Format for post will be:
                response=4&module_id=1&interaction_end_time=2014-01-29T16%3A01%3A42-00%3A00&is_complete=true&is_correct=false&score=0 
            */

            $.each(questions, function(idx, value) {
                $("div #" + idx).find(".lrn_validate").click(function() {

                    var knewtonObj = {
                        module_id : moduleNames.getModuleId(idx),
                        interaction_end_time: convertTime(new Date()),
                        is_complete : true
                    };


                    lrnActiv.attemptedQuestions(function(attemptedQuestions) {
                        if($.inArray(idx, attemptedQuestions) >= 0) {
                            //if attempted
                            lrnActiv.getResponses(function(responses) {

                                if(responses[idx].value != "") {
                                    lrnActiv.validItems(function(validItems){
                                        var correct = false;
                                        $.each(validItems, function(valIdx, value) {
                                            if(typeof value[idx] !== 'undefined') {
                                                correct = value[idx];
                                                return false;
                                            }
                                        });
                                        knewtonObj.response = responses[idx].value;
                                        if(correct) {

                                            knewtonObj.is_correct = true;
                                            knewtonObj.score = 1;

                                            console.log("Question is true");

                                        } else {

                                            knewtonObj.is_correct = false;
                                            knewtonObj.score = 0;

                                            console.log("Question is false");
                                        }
                                    });
                                    console.log('KnewtonObj: ', knewtonObj);

                                    $.ajax({
                                        type: "POST",
                                        url: "/event",
                                        data: knewtonObj,
                                    }).done(function() {
                                        console.log("POST succeeded");
                                    }).fail(function() {
                                        console.log("POST failed");
                                    });
                                }
                            });
                        }
                    });
                });
            });
        });
    }

    </script>
</body>
</html>
