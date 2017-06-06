<link href="regionsSettingsStyle.css" rel="stylesheet" type="text/css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_id'    => 'itemsassessdemo',
    'name'           => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'type'           => 'submit_practice',
    'session_id'     => Uuid::generate(),
    'user_id'        => $studentid,
    'items'          => array(
        'Demo3',
        'Demo4',
        'accessibility_demo_6',
        'Demo6',
        'Demo7',
        'Demo8',
        'Demo9',
        'Demo10',
        'audioplayer-demo-1'
    ),
    'config'         => array(
        'title'                      => 'Demo activity - showcasing question types and assess options',
        'subtitle'                   => 'Walter White',
        'regions'=> [
            'top-left' => [
                array(
                    'type' => 'title_element'
                ),
                array(
                    'type' => 'header_element',
                    'default_label_option' => 'regionHeaderTopLeft'
                )
            ],
            'top-right' => [
                array(
                    'type' => 'pause_button',
                    'position' => 'right'
                ),
                array(
                    'type' => 'timer_element'
                ),
                array(
                    'type' => 'reading_timer_element'
                ),
                array(
                    'type' => 'itemcount_element'
                ),
                array(
                    'type' => 'header_element',
                    'default_label_option' => 'regionHeaderTopRight'
                )
            ],
            'right' => [
                array(
                    'type' => 'verticaltoc_element'
                ),
                array(
                    'type' => 'save_button'
                ),
                array(
                    'type' => 'fullscreen_button'
                ),
                array(
                    'type' => 'reviewscreen_button'
                ),
                array(
                    'type' => 'accessibility_button'
                ),
                array(
                    'type' => 'calculator_button'
                ),
                array(
                    'type' => 'flagitem_button'
                ),
                array(
                    'type' => 'header_element',
                    'default_label_option' => 'regionHeaderRight'
                )
            ],
            'bottom-right' => [
                array(
                    'type' => 'next_button'
                ),
                array(
                    'type' => 'previous_button'
                ),
                array(
                    'type' => 'header_element',
                    'default_label_option' => 'regionHeaderBottomRight'
                )
            ]

        ],
        'navigation' => array(
            'show_progress' => false,
            'show_intro'               => true,
            'show_outro'               => true,
            'show_title'               => false,
            'skip_submit_confirmation' => false,
            'warning_on_change'        => false,
            'show_acknowledgements'    => true,
            'auto_save'                => array(
                'ui' => false,
                'saveIntervalDuration' => 500
            ),
            'item_count' => array(
                'question_count_option' => false
            )
        ),
        'time' => array(
            'max_time'     => 1500,
            'limit_type'   => 'soft',
            'warning_time' => 120
        ),
        'configuration'       => array(
            'shuffle_items'          => false,
            'lazyload'               => false,
            'fontsize'               => 'normal',
            'onsubmit_redirect_url'  => 'itemsapi_assess.php',
            'onsave_redirect_url'    => 'itemsapi_assess.php',
            'ondiscard_redirect_url' => 'itemsapi_assess.php',
            'idle_timeout'           => array(
                'interval'       => 300,
                'countdown_time' => 60
            ),
            'submit_criteria' => array(
                'type' => 'attempted'
            )
        )
    )
);


include 'utils/settings-override.php';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h1>Items API – Assess</h1>
            <p>With the flick of a switch make the items into an assessment. Truly write once - use anywhere.<p>
            <p>Type ctrl+shift+m to open the Administration Panel. The default password is <em>password</em>.</p>
        </div>
    </div>

    <div class="section">
        <!-- Container for the items api to load into -->
        <div id="learnosity_assess"></div>
    </div>
    <script src="<?php echo $url_items; ?>"></script>
    <script>
        var currentRegions = <?php echo json_encode($request['config']['regions']);?>;
        var btnIdCounter = 0;
        var eventOptions = {
                readyListener: init,
                errorListener: function (event){
                    console.log("error:" + event);
                }
            },
            itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

        function init () {
            var assessApp = itemsApp.assessApp();

            assessApp.on('item:load', function () {
                console.log('Active item:', getActiveItem(this.getItems()));
            });

            assessApp.on('test:submit:success', function () {
                toggleModalClass();
            });
        }

        /**
         * Returns the active item if using the Assess API
         * @param  {object} items Object of all items currently loaded
         * @return {object}       Current active item
         */
        function getActiveItem (items) {
            for (var item in items) {
                if (items.hasOwnProperty(item) && items[item].active === true) {
                    return items[item];
                }
            }
        }

        function toggleModalClass () {
            $('.modal-backdrop').css('display', 'none');
        }
        var topLeftRegion = [];
        var topRightRegion = [];
        var itemsRegion = [];
        var rightRegion = [];
        var bottomLeftRegion = [];
        var bottomRightRegion = [];
        var bottomRegion = [];
        var region = {};
        var regionElementMap = {
            "pause_button": "Pause",
            "accessibility_button": "Accessibility",
            "calculator_button": "Calculator",
            "flagitem_button": "Flag Item",
            "fullscreen_button": "Full Screen",
            "masking_button": "Response Masking",
            "next_button": "Next",
            "previous_button": "Pause",
            "reviewscreen_button": "Review Screen",
            "save_button": "Save",
            "submit_button": "Submit",
            "itemcount_element": "Item Count",
            "reading_timer_element": "Reading Timer",
            "timer_element": "Timer",
            "title_element": "Title",
            "progress_element": "Progress",
            "slider_element": "Slider",
            "vertical_element": "Vertical",
            "verticaltoc_element": "Vertical TOC",
            "horizontaltoc_element": "Horizontal TOC"

        };
        var regionElementToLabel = swap(regionElementMap);

        function swap(json){
            var ret = {};
            for(var key in json){
                ret[json[key]] = key;
            }
            return ret;
        }
        function removeElem(elem) {
            $(elem).parent().parent().remove();

        }

        function addElem(selectElemID, container){
            if($(selectElemID).val() != 'none'){
                var text = $(selectElemID).val();
                $(selectElemID).val("");
                var elementLabelString = '<div class="elem-label"><span>' + regionElementMap[text] + '</span></div>';
                var buttonString = '<div class="close-btn-container"><button class="close-btn" id="close-btn-'+btnIdCounter+ '">' + "×" + "</button></div>";
                var divElem = '<div class="elem-container">' + elementLabelString + buttonString + "</div>";
                $(container).append(divElem);
                $('#close-btn-'+ btnIdCounter).click(function(){
                    removeElem(this);
                });
                btnIdCounter++;
                $(this).attr("disabled", "disabled");
                $(this).removeAttr("disabled");
            }

        }
        function loadElem(text, container){
            var elementLabelString = '<div class="elem-label"><span>' + regionElementMap[text] + '</span></div>';
            var buttonString = '<div class="close-btn-container"><button class="close-btn" id="close-btn-'+btnIdCounter+ '">' + "×" + "</button></div>";
            var divElem = '<div class="elem-container">' + elementLabelString + buttonString + "</div>";
            $("."+ container).append(divElem);
            $('#close-btn-'+ btnIdCounter).click(function(){
                removeElem(this);
            });
            btnIdCounter++;

        }

        function setTopLeftRegion () {
            topLeftRegion = [];
            var topLeftElems = $('.top-leftContainer').children().toArray();

            for(var i=0; i< topLeftElems.length; i++){
                var spanElem = $($(topLeftElems[i]).find('div')[0]).find('span');
                var elem = $(spanElem[0]).html();
                topLeftRegion.push({'type': regionElementToLabel[elem]});
            }
            topLeftRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderTopLeft'});

        }
        function setTopRightRegion () {
            topRightRegion = [];
            var topRightElems = $('.top-rightContainer').children().toArray();

            for(var i=0; i< topRightElems.length; i++){
                var spanElem = $($(topRightElems[i]).find('div')[0]).find('span');
                var elem = $(spanElem[0]).html();
                if(($('#regionsPresetsSelector').val() == 'main' ||
                    $('#regionsPresetsSelector').val() == 'horizontal' ||
                    $('#regionsPresetsSelector').val() == 'horizontal-fixed')
                    && elem == 'pause_button'){
                    topRightRegion.push({'type': regionElementToLabel[elem], 'position': 'right'});
                }
                else {
                    topRightRegion.push({'type': regionElementToLabel[elem]});
                }
            }
            topRightRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderTopRight'});

        }
        function setItemsRegion () {
            itemsRegion = [];
            var itemsElems = $('.itemsContainer').children().toArray();

            for(var i=0; i< itemsElems.length; i++){
                var spanElem = $($(itemsElems[i]).find('div')[0]).find('span');
                var elem = $(spanElem[0]).html();
                if($('#regionsPresetsSelector').val() == 'horizontal-fixed' && elem == 'slider_element'){
                    itemsRegion.push({'type': regionElementToLabel[elem], 'scrollable_option': true});
                }
                else {
                    itemsRegion.push({'type': regionElementToLabel[elem]});
                }
            }
           itemsRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderItems'});

        }
        function setRightRegion () {
            rightRegion = [];
            var rightElems = $('.rightContainer').children().toArray();

            for(var i=0; i< rightElems.length; i++){
                var spanElem = $($(rightElems[i]).find('div')[0]).find('span');
                var elem = $(spanElem[0]).html();
                rightRegion.push({'type': regionElementToLabel[elem]});
            }
            rightRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderRight'});

        }
        function setBottomLeftRegion () {
            bottomLeftRegion = [];
            var bottomLeftElems = $('.bottom-leftContainer').children().toArray();

            for(var i=0; i< bottomLeftElems.length; i++){
                var spanElem = $($(bottomLeftElems[i]).find('div')[0]).find('span');
                var elem = $(spanElem[0]).html();
                bottomLeftRegion.push({'type': regionElementToLabel[elem]});
            }
            bottomLeftRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderBottomLeft'});

        }
        function setBottomRightRegion () {
            bottomRightRegion = [];
            var bottomRightElems = $('.bottom-rightContainer').children().toArray();

            for(var i=0; i< bottomRightElems.length; i++){
                var spanElem = $($(bottomRightElems[i]).find('div')[0]).find('span');
                var elem = $(spanElem[0]).html();
                bottomRightRegion.push({'type': regionElementToLabel[elem]});
            }
            bottomRightRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderBottomRight'});

        }
        function setBottomRegion () {
            bottomRegion = [];
            var bottomElems = $('.bottomContainer').children().toArray();

            for(var i=0; i< bottomElems.length; i++){
                var spanElem = $($(bottomElems[i]).find('div')[0]).find('span');
                var elem = $(spanElem[0]).html();
                bottomRegion.push({'type': regionElementToLabel[elem]});
            }
            bottomRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderBottom'});
        }

        $(document).ready(function () {

            // add autocomplete and keypress event for top left
            $('#topLeftElementAdder').on('change', function() {
                addElem('#topLeftElementAdder', '.top-leftContainer');
            });

            // add autocomplete and keypress event for top right
            $('#topRightElementAdder').on('change', function() {
                addElem('#topRightElementAdder', '.top-rightContainer');
            });

            // add autocomplete and keypress event for right
            $('#rightElementAdder').on('change', function() {
                addElem('#rightElementAdder', '.rightContainer');
            });

            // add autocomplete and keypress event for bottom left
            $('#bottomLeftElementAdder').on('change', function() {
                addElem('#bottomLeftElementAdder', '.bottom-leftContainer');
            });


            // add autocomplete and keypress event for bottom right
            $('#bottomRightElementAdder').on('change', function() {
                addElem('#bottomRightElementAdder', '.bottom-rightContainer');
            });


            // add autocomplete and keypress event for bottom
            $('#bottomElementAdder').on('change', function() {
                addElem('#bottomElementAdder', '.bottomContainer');
            });

            // add autocomplete and keypress event for items
            $('#itemsElementAdder').on('change', function() {
                addElem('#itemsElementAdder', '.itemsContainer');
            });
            //load current elements
            $.each(currentRegions, function (key, value){
                var region = key;
                $.each( value, function (index,elem){
                    if(elem.type != 'header_element') {
                        loadElem(elem.type, key + "Container");
                    }
                    }
                );

            });

            //load current preset value
            if(JSON.stringify(currentRegions) == JSON.stringify(main)){
                $('#regionsPresetsSelector').val('main');
            }
            else if(JSON.stringify(currentRegions) == JSON.stringify(horizontal)){
                $('#regionsPresetsSelector').val('horizontal');
            }
            else if(JSON.stringify(currentRegions) == JSON.stringify(horizontal_fixed)){
                $('#regionsPresetsSelector').val('horizontal-fixed');
            }
            else {
                $('#regionsPresetsSelector').val('custom');
            }

            $('#regionsPresetsSelector').on('change', function(){
                //remove all elements first
                $('.close-btn').click();
                //start adding necessary elements
                if($('#regionsPresetsSelector').val() == 'main'){
                    $.each(main, function (key, value){
                        var region = key;
                        $.each( value, function (index,elem){
                                if(elem.type != 'header_element') {
                                    loadElem(elem.type, key + "Container");
                                }
                            }
                        );

                    });
                }
                else if($('#regionsPresetsSelector').val() == 'horizontal'){
                    $.each(horizontal, function (key, value){
                        var region = key;
                        $.each( value, function (index,elem){
                                if(elem.type != 'header_element') {
                                    loadElem(elem.type, key + "Container");
                                }
                            }
                        );

                    });

                }
                else if($('#regionsPresetsSelector').val() == 'horizontal-fixed'){
                    $.each(horizontal_fixed, function (key, value){
                        var region = key;
                        $.each( value, function (index,elem){
                                if(elem.type != 'header_element') {
                                    loadElem(elem.type, key + "Container");
                                }
                            }
                        );

                    });
                }
            });


        });



    </script>

<?php
include_once 'views/modals/settings-items.php';
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';

?>