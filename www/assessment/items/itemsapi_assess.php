<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain' => $domain
);

$request = [
    'activity_id' => 'itemsassessdemo',
    'name' => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'state' => 'initial',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => $studentid,
    'items' => [
        'Demo3',
        'Demo4',
        'accessibility_demo_6',
        'Demo6',
        'Demo7',
        'Demo8',
        'Demo9',
        'Demo10',
        'audioplayer-demo-1'
    ],
    'config' => [
        'title' => 'Demo activity - showcasing question types and assess options',
        'subtitle' => 'Walter White',
        'regions' => [
            'top-left' => [
                [
                    'type' => 'title_element'
                ],
                [
                    'type' => 'header_element',
                    'default_label_option' => 'regionHeaderTopLeft'
                ]
            ],
            'top-right' => [
                [
                    'type' => 'pause_button',
                    'position' => 'right'
                ],
                [
                    'type' => 'timer_element'
                ],
                [
                    'type' => 'reading_timer_element'
                ],
                [
                    'type' => 'itemcount_element'
                ],
                [
                    'type' => 'header_element',
                    'default_label_option' => 'regionHeaderTopRight'
                ]
            ],
            'items' => [
                [
                    'type' => 'slider_element'
                ],
                [
                    'type' => 'progress_element'
                ],
                [
                    'type' => 'header_element',
                    'default_label_option' => 'regionHeaderItems'
                ]
            ],
            'right' => [
                [
                    'type' => 'verticaltoc_element'
                ],
                [
                    'type' => 'save_button'
                ],
                [
                    'type' => 'fullscreen_button'
                ],
                [
                    'type' => 'reviewscreen_button'
                ],
                [
                    'type' => 'accessibility_button'
                ],
                [
                    'type' => 'calculator_button'
                ],
                [
                    'type' => 'flagitem_button'
                ],
                [
                    'type' => 'header_element',
                    'default_label_option' => 'regionHeaderRight'
                ]
            ],
            'bottom-right' => [
                [
                    'type' => 'next_button'
                ],
                [
                    'type' => 'previous_button'
                ],
                [
                    'type' => 'header_element',
                    'default_label_option' => 'regionHeaderBottomRight'
                ]
            ]

        ],
        'navigation' => [
            'show_progress' => false,
            'show_intro' => true,
            'show_outro' => true,
            'show_title' => false,
            'skip_submit_confirmation' => false,
            'warning_on_change' => false,
            'show_acknowledgements' => true,
            'auto_save' => [
                'ui' => false,
                'saveIntervalDuration' => 500
            ],
            'item_count' => [
                'question_count_option' => false
            ]
        ],
        'time' => [
            'max_time' => 1500,
            'limit_type' => 'soft',
            'warning_time' => 120
        ],
        'configuration' => [
            'shuffle_items' => false,
            'lazyload' => false,
            'fontsize' => 'normal',
            'onsubmit_redirect_url' => 'itemsapi_assess.php',
            'onsave_redirect_url' => 'itemsapi_assess.php',
            'ondiscard_redirect_url' => 'itemsapi_assess.php',
            'idle_timeout' => [
                'interval' => 300,
                'countdown_time' => 60
            ],
            'submit_criteria' => [
                'type' => 'attempted'
            ]
        ]
    ]
];


include 'utils/settings-override.php';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#" data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – Assess</h1>
        <p>With the flick of a switch make the items into an assessment. Truly write once - use anywhere.
        <p>
        <p>Type ctrl+shift+m to open the Administration Panel. The default password is <em>password</em>.</p>
    </div>
</div>

<div class="section">
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>

    $(document).ready(function () {

        function loadcssfile(filename, filetype){
            if (filetype=="css"){ //if filename is an external CSS file
                var fileref=document.createElement("link")
                fileref.setAttribute("rel", "stylesheet")
                fileref.setAttribute("type", "text/css")
                fileref.setAttribute("href", filename)
            }
            if (typeof fileref!="undefined")
                document.getElementsByTagName("head")[0].appendChild(fileref)
        }

        loadcssfile("regionsSettingsStyle.css", "css") ////dynamically load and add this .css file
        window.appHelper = {
            setTopLeftRegion: function () {
                var topLeftRegion = [];
                var topLeftElems = $('.top-leftContainer').children().toArray();

                for (var i = 0; i < topLeftElems.length; i++) {
                    var spanElem = $($(topLeftElems[i]).find('div')[0]).find('span');
                    var elem = $(spanElem[0]).html();
                    topLeftRegion.push({'type': regionLabelToElement[elem]});
                }
                topLeftRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderTopLeft'});
                return topLeftRegion;
            },
            setTopRightRegion: function () {
                var topRightRegion = [];
                var topRightElems = $('.top-rightContainer').children().toArray();

                for (var i = 0; i < topRightElems.length; i++) {
                    var spanElem = $($(topRightElems[i]).find('div')[0]).find('span');
                    var elem = $(spanElem[0]).html();
                    var presetSelected = $('#regionsPresetsSelector').val();
                    if (( presetSelected === 'main' ||
                        presetSelected === 'horizontal' ||
                        presetSelected === 'horizontal-fixed')
                        && elem === 'Pause') {
                        topRightRegion.push({'type': regionLabelToElement[elem], 'position': 'right'});
                    }
                    else {
                        topRightRegion.push({'type': regionLabelToElement[elem]});
                    }
                }
                topRightRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderTopRight'});
                return topRightRegion;
            },
            setItemsRegion: function () {
                var itemsRegion = [];
                var itemsElems = $('.itemsContainer').children().toArray();

                for (var i = 0; i < itemsElems.length; i++) {
                    var spanElem = $($(itemsElems[i]).find('div')[0]).find('span');
                    var elem = $(spanElem[0]).html();
                    var presetSelected = $('#regionsPresetsSelector').val();

                    if (elem === 'Slider') {
                        if(presetSelected === 'horizontal-fixed'){
                            itemsRegion.push({'type': regionLabelToElement[elem], 'scrollable_option': true});
                        }
                        else {
                            itemsRegion.push({'type': regionLabelToElement[elem]});
                        }

                    }
                    else {
                        itemsRegion.push({'type': regionLabelToElement[elem]});
                    }
                }
                itemsRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderItems'});
                return itemsRegion;
            },
            setRightRegion: function () {
                var rightRegion = [];
                var rightElems = $('.rightContainer').children().toArray();

                for (var i = 0; i < rightElems.length; i++) {
                    var spanElem = $($(rightElems[i]).find('div')[0]).find('span');
                    var elem = $(spanElem[0]).html();
                    rightRegion.push({'type': regionLabelToElement[elem]});
                }
                rightRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderRight'});
                return rightRegion;
            },
            setBottomLeftRegion: function () {
                var bottomLeftRegion = [];
                var bottomLeftElems = $('.bottom-leftContainer').children().toArray();

                for (var i = 0; i < bottomLeftElems.length; i++) {
                    var spanElem = $($(bottomLeftElems[i]).find('div')[0]).find('span');
                    var elem = $(spanElem[0]).html();
                    bottomLeftRegion.push({'type': regionLabelToElement[elem]});
                }
                bottomLeftRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderBottomLeft'});
                return bottomLeftRegion;
            },
            setBottomRightRegion: function () {
                var bottomRightRegion = [];
                var bottomRightElems = $('.bottom-rightContainer').children().toArray();

                for (var i = 0; i < bottomRightElems.length; i++) {
                    var spanElem = $($(bottomRightElems[i]).find('div')[0]).find('span');
                    var elem = $(spanElem[0]).html();
                    bottomRightRegion.push({'type': regionLabelToElement[elem]});
                }
                bottomRightRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderBottomRight'});
                return bottomRightRegion;
            },
            setBottomRegion: function () {
                var bottomRegion = [];
                var bottomElems = $('.bottomContainer').children().toArray();

                for (var i = 0; i < bottomElems.length; i++) {
                    var spanElem = $($(bottomElems[i]).find('div')[0]).find('span');
                    var elem = $(spanElem[0]).html();
                    bottomRegion.push({'type': regionLabelToElement[elem]});
                }
                bottomRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderBottom'});
                return bottomRegion;
            }
        };
        //to be used for loading the elements in UI
        var regionElementMap = {
                "pause_button": "Pause",
                "accessibility_button": "Accessibility",
                "calculator_button": "Calculator",
                "flagitem_button": "Flag Item",
                "fullscreen_button": "Full Screen",
                "masking_button": "Response Masking",
                "next_button": "Next",
                "previous_button": "Previous",
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
                "verticaltoc_element": "Pager Navigation",
                "horizontaltoc_element": "Table of Contents"

            };
        //to be used for setting up regions object/json
        var regionLabelToElement = swap(regionElementMap);
        var currentRegions = <?php echo json_encode($request['config']['regions']);?>;
        var btnIdCounter = 0;
        var region = {};
        var main = {
            'top-left': [
                {type: 'title_element'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderTopLeft'
                }
            ],
            'top-right': [
                {
                    type: 'pause_button',
                    position: 'right'
                },
                {type: 'timer_element'},
                {type: 'reading_timer_element'},
                {type: 'itemcount_element'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderTopRight'
                }
            ],
            items: [
                {
                    'type': 'slider_element'
                },
                {type: 'progress_element'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderItems'
                }
            ],
            right: [
                {type: 'verticaltoc_element'},
                {type: 'save_button'},
                {type: 'fullscreen_button'},
                {type: 'reviewscreen_button'},
                {type: 'accessibility_button'},
                {type: 'calculator_button'},
                {type: 'flagitem_button'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderRight'
                }
            ],
            'bottom-right': [
                {type: 'next_button'},
                {type: 'previous_button'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderBottomRight'
                }
            ]
        };

        var horizontal = {
            'top-left': [
                {type: 'title_element'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderTopLeft'
                }
            ],
            'top-right': [
                {
                    type: 'pause_button',
                    position: 'right'
                },
                {type: 'timer_element'},
                {type: 'reading_timer_element'},
                {type: 'itemcount_element'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderTopRight'
                }
            ],
            items: [
                {
                    'type': 'slider_element'
                },
                {type: 'progress_element'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderItems'
                }
            ],
            right: [
                {type: 'save_button'},
                {type: 'fullscreen_button'},
                {type: 'reviewscreen_button'},
                {type: 'accessibility_button'},
                {type: 'calculator_button'},
                {type: 'flagitem_button'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderRight'
                }
            ],
            bottom: [
                {type: 'next_button'},
                {type: 'horizontaltoc_element'},
                {type: 'previous_button'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderBottom'
                }
            ]
        };

        var horizontal_fixed = {
            'top-left': [
                {type: 'title_element'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderTopLeft'
                }
            ],
            'top-right': [
                {
                    type: 'pause_button',
                    position: 'right'
                },
                {type: 'timer_element'},
                {type: 'reading_timer_element'},
                {type: 'itemcount_element'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderTopRight'
                }
            ],
            items: [
                {
                    type: 'slider_element',
                    scrollable_option: true
                },
                {type: 'progress_element'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderItems'
                }
            ],
            right: [
                {type: 'save_button'},
                {type: 'fullscreen_button'},
                {type: 'reviewscreen_button'},
                {type: 'accessibility_button'},
                {type: 'calculator_button'},
                {type: 'flagitem_button'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderRight'
                }
            ],
            bottom: [
                {type: 'next_button'},
                {type: 'horizontaltoc_element'},
                {type: 'previous_button'},
                {
                    type: 'header_element',
                    default_label_option: 'regionHeaderBottom'
                }
            ]
        };
        var eventOptions = {
                readyListener: init,
                errorListener: function (event) {
                    console.log("error:" + event);
                }
            },
            itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

        function init() {
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
        function getActiveItem(items) {
            for (var item in items) {
                if (items.hasOwnProperty(item) && items[item].active === true) {
                    return items[item];
                }
            }
        }

        function toggleModalClass() {
            $('.modal-backdrop').css('display', 'none');
        }


        function swap(json) {
            var ret = {};
            for (var key in json) {
                ret[json[key]] = key;
            }
            return ret;
        }

        function removeElem(elem) {
            $(elem).parent().parent().remove();

        }

        function addElem(selectElemID, container) {
            var $selectElem = $(selectElemID);
            var hasTitle = false, hasBottomElement = false, hasBottomLeftElement = false;
            if ($selectElem.val() === 'none') {
                return;
            }
            if($('.top-leftContainer').children()[0] && $($('.top-leftContainer').children()[0]).find('span').html() === "Title"){
                hasTitle = true;
            }
            if($('.bottomContainer').children().length > 0){
                hasBottomElement = true;
            }
            if($('.bottom-leftContainer').children().length > 0){
                hasBottomLeftElement = true;
            }
            var text = $selectElem.val();
            $selectElem.val("");
            var elementLabelString = '<div class="elem-label"><span>' + regionElementMap[text] + '</span></div>';
            var buttonString = '<div class="close-btn-container"><button class="close-btn" id="close-btn-' + btnIdCounter + '">' + "×" + "</button></div>";
            var divElem = '<div class="elem-container">' + elementLabelString + buttonString + "</div>";
            var childCount = $(container).children().length;
            if(((container === ".top-leftContainer") && childCount < 4) ||
                ((container === ".top-rightContainer") && childCount < 4) ||
                ((container === ".itemsContainer") && childCount < 2) ||
                ((container === ".rightContainer") && childCount < 7) ||
                ((container === ".bottom-leftContainer") && childCount < 4) ||
                ((container === ".bottom-rightContainer") && childCount < 3) ||
                ((container === ".bottomContainer") && childCount < 6)
            ) {
                if((hasTitle && (container === ".top-leftContainer")) ||
                    ((!(hasTitle)) && (container === ".top-leftContainer") && childCount > 0 && regionElementMap[text] === "Title")
                ) {
                    alert("If you have a Title, it is not advisable to place additional elements in the Top Left Region. Please remove Title if you would like to place other elements.");
                }
                else if((hasBottomElement && (container === ".bottom-leftContainer"))||
                    (hasBottomLeftElement && (container === ".bottomContainer"))
                ){
                    alert("Bottom and Bottom Left Regions cannot be specified at the same time.");
                }
                else {
                    $(container).append(divElem);
                    $('#close-btn-' + btnIdCounter).click(function () {
                        removeElem(this);
                    });
                    btnIdCounter++;
                }
            }
            else{
                alert("You have reached the maximum number of elements which can be added in this region for this demo.");
            }

        }

        function loadElem(text, container) {
            var elementLabelString = '<div class="elem-label"><span>' + regionElementMap[text] + '</span></div>';
            var buttonString = '<div class="close-btn-container"><button class="close-btn" id="close-btn-' + btnIdCounter + '">' + "×" + "</button></div>";
            if(text === 'slider_element'){
                buttonString = '<div class="close-btn-container slider-elem"><button class="close-btn" id="close-btn-' + btnIdCounter + '" hidden>' + "×" + "</button></div>";
            }
            var divElem = '<div class="elem-container">' + elementLabelString + buttonString + "</div>";
            if(text === 'slider_element'){
                divElem = '<div class="elem-container slider-elem">' + elementLabelString + buttonString + "</div>";
            }
            $("." + container).append(divElem);
            $('#close-btn-' + btnIdCounter).click(function () {
                removeElem(this);
            });
            btnIdCounter++;

        }

        // add on change event handler for top left dropdown
        $('#topLeftElementAdder').on('change', function () {
            addElem('#topLeftElementAdder', '.top-leftContainer');
        });

        // add on change event handler for top right dropdown
        $('#topRightElementAdder').on('change', function () {
            addElem('#topRightElementAdder', '.top-rightContainer');
        });

        // add on change event handler for right dropdown
        $('#rightElementAdder').on('change', function () {
            addElem('#rightElementAdder', '.rightContainer');
        });

        // add on change event handler for bottom left dropdown
        $('#bottomLeftElementAdder').on('change', function () {
            addElem('#bottomLeftElementAdder', '.bottom-leftContainer');
        });


        // add on change event handler for bottom right dropdown
        $('#bottomRightElementAdder').on('change', function () {
            addElem('#bottomRightElementAdder', '.bottom-rightContainer');
        });


        // aadd on change event handler for bottom dropdown
        $('#bottomElementAdder').on('change', function () {
            addElem('#bottomElementAdder', '.bottomContainer');
        });

        // add on change event handler for items dropdown
        $('#itemsElementAdder').on('change', function () {
            addElem('#itemsElementAdder', '.itemsContainer');
        });

        //load current elements
        $.each(currentRegions, function (key, value) {
            $.each(value, function (index, elem) {
                    if (elem.type !== 'header_element') {
                        loadElem(elem.type, key + "Container");
                    }
                }
            );

        });

        //load current presets value
        if (JSON.stringify(currentRegions) === JSON.stringify(main)) {
            $('#regionsPresetsSelector').val('main');
        }
        else if (JSON.stringify(currentRegions) === JSON.stringify(horizontal)) {
            $('#regionsPresetsSelector').val('horizontal');
        }
        else if (JSON.stringify(currentRegions) === JSON.stringify(horizontal_fixed)) {
            $('#regionsPresetsSelector').val('horizontal-fixed');
        }
        else {
            $('#regionsPresetsSelector').val('custom');
        }

        $('#regionsPresetsSelector').on('change', function () {
            //remove all elements first
            $('.close-btn').click();
            //start adding necessary elements
            var $presetSelector = $('#regionsPresetsSelector').val();
            if ($presetSelector === 'main') {
                $.each(main, function (key, value) {
                    var region = key;
                    $.each(value, function (index, elem) {
                            if (elem.type != 'header_element') {
                                loadElem(elem.type, key + "Container");
                            }
                        }
                    );

                });
            }
            else if ($presetSelector === 'horizontal') {
                $.each(horizontal, function (key, value) {
                    var region = key;
                    $.each(value, function (index, elem) {
                            if (elem.type != 'header_element') {
                                loadElem(elem.type, key + "Container");
                            }
                        }
                    );

                });

            }
            else if ($presetSelector === 'horizontal-fixed') {
                $.each(horizontal_fixed, function (key, value) {
                    var region = key;
                    $.each(value, function (index, elem) {
                            if (elem.type != 'header_element') {
                                loadElem(elem.type, key + "Container");
                            }
                        }
                    );

                });
            }
            else {
                loadElem('slider_element', 'itemsContainer');
            }
        });

        $('#submitForm').on('click', function () {
            var appHelper = window.appHelper;

            region = {
                'top-left': appHelper.setTopLeftRegion(),
                'top-right': appHelper.setTopRightRegion(),
                'items': appHelper.setItemsRegion(),
                'right': appHelper.setRightRegion(),
                'bottom-left': appHelper.setBottomLeftRegion(),
                'bottom-right': appHelper.setBottomRightRegion(),
                'bottom': appHelper.setBottomRegion()
            };

            $.each(region, function (index, reg) {
                if (reg.length == 1) {
                    delete(region[index]);
                }
            });

            $('#regionsSetting').val(JSON.stringify(region));

            $('#frmSettings').submit();


        });
    });


</script>

<?php
include_once 'views/modals/settings-items.php';
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';

?>