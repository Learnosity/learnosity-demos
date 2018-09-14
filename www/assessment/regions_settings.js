/**
 * Created by kitamieltumulak on 1/9/17.
 */
$(document).ready(function () {

    //this function dynamically appends a css style sheet to this page
    function loadCssFile(filename, filetype) {
        if (filetype == "css") { //if filename is an external CSS file
            var fileref = document.createElement("link");
            fileref.setAttribute("rel", "stylesheet");
            fileref.setAttribute("type", "text/css");
            fileref.setAttribute("href", filename);
        }
        if (typeof fileref != "undefined")
            document.getElementsByTagName("head")[0].appendChild(fileref)
    }

    //dynamically load and add this css file for regions setting UI
    loadCssFile("regions_settings_style.css", "css");
    window.appHelper = {
        setTopRegion: function () {
            var topRegion = [];
            var topElems = $('.topContainer').children().toArray();

            for (var i = 0; i < topElems.length; i++) {
                var spanElem = $($(topElems[i]).find('div')[0]).find('span');
                var elem = $(spanElem[0]).html();
                topRegion.push({'type': regionLabelToElement[elem]});
            }
            topRegion.push({'type': 'header_element', 'default_label_option': 'regionHeaderTop'});
            return topRegion;
        },
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
                    if (presetSelected === 'horizontal-fixed') {
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
    const regionElementMap = {
        // Buttons
        'accessibility_button': 'Accessibility',
        'calculator_button': 'Calculator',
        'flagitem_button': 'Flag Item',
        'fullscreen_button': 'Full Screen',
        'masking_button': 'Masking',
        'next_button': 'Next',
        'pause_button': 'Pause',
        'previous_button': 'Previous',
        'protractor_button': 'Protractor',
        'reviewscreen_button': 'Review Screen',
        'ruler_button': 'Ruler',
        'save_button': 'Save',
        'submit_button': 'Submit',

        // Elements
        'horizontaltoc_element': 'Pager Navigation',
        'itemcount_element': 'Item Count',
        'progress_element': 'Progress',
        'reading_timer_element': 'Reading Timer',
        'separator_element': 'Separator',
        'timer_element': 'Timer',
        'title_element': 'Title',
        'verticaltoc_element': 'Table of Contents',

        // Items
        'slider_element': 'Slider'
    };
    //to be used for setting up regions object
    const regionLabelToElement = swap(regionElementMap);
    var btnIdCounter = 0;
    var region = {};

    //regions main preset value
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

    //regions horizontal preset value
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

    //regions horizontal-fixed preset value
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

    //this function swaps key and value of objects
    function swap(json) {
        var ret = {};
        for (var key in json) {
            ret[json[key]] = key;
        }
        return ret;
    }

    //this function removes the region element from its container
    function removeElem(elem) {
        $(elem).parent().parent().remove();
    }

    //this function appends the element to corresponding region
    function addElem(selectElemID, container) {
        var $selectElem = $(selectElemID);
        var hasTitle = false, hasBottomElement = false, hasBottomLeftElement = false;
        if ($selectElem.val() === 'none') {
            return;
        }
        if ($('.top-leftContainer').children()[0] && $($('.top-leftContainer').children()[0]).find('span').html() === "Title") {
            hasTitle = true;
        }
        if ($('.bottomContainer').children().length > 0) {
            hasBottomElement = true;
        }
        if ($('.bottom-leftContainer').children().length > 0) {
            hasBottomLeftElement = true;
        }
        var text = $selectElem.val();
        $selectElem.val("");
        var elementLabelString = '<div class="elem-label"><span>' + regionElementMap[text] + '</span></div>';
        var buttonString = '<div class="close-btn-container"><button class="close-btn" id="close-btn-' + btnIdCounter + '">' + "×" + "</button></div>";
        var divElem = '<div class="elem-container">' + elementLabelString + buttonString + "</div>";
        var childCount = $(container).children().length;

        //condition below is for setting a limit to the number of elements that can be added per region
        if (((container === ".topContainer") && childCount < 6) ||
            ((container === ".top-leftContainer") && childCount < 4) ||
            ((container === ".top-rightContainer") && childCount < 4) ||
            ((container === ".itemsContainer") && childCount < 2) ||
            ((container === ".rightContainer") && childCount < 7) ||
            ((container === ".bottom-leftContainer") && childCount < 4) ||
            ((container === ".bottom-rightContainer") && childCount < 3) ||
            ((container === ".bottomContainer") && childCount < 6)
        ) {
            if ((hasTitle && (container === ".top-leftContainer")) ||
                ((!(hasTitle)) && (container === ".top-leftContainer") && childCount > 0 && regionElementMap[text] === "Title")
            ) {
                alert("If you have a Title, it is not advisable to place additional elements in the Top Left Region. Please remove Title if you would like to place other elements.");
            }
            else if ((hasBottomElement && (container === ".bottom-leftContainer")) ||
                (hasBottomLeftElement && (container === ".bottomContainer"))
            ) {
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
        else {
            alert("You have reached the maximum number of elements which can be added in this region for this demo.");
        }

    }

    //this function is used for loading the elements based on the request json
    function loadElem(text, container) {
        var elementLabelString = '<div class="elem-label"><span>' + regionElementMap[text] + '</span></div>';
        var buttonString = '<div class="close-btn-container"><button class="close-btn" id="close-btn-' + btnIdCounter + '">' + "×" + "</button></div>";
        if (text === 'slider_element') {
            buttonString = '<div class="close-btn-container slider-elem"><button class="close-btn" id="close-btn-' + btnIdCounter + '" hidden>' + "×" + "</button></div>";
        }
        var divElem = '<div class="elem-container">' + elementLabelString + buttonString + "</div>";
        if (text === 'slider_element') {
            divElem = '<div class="elem-container slider-elem">' + elementLabelString + buttonString + "</div>";
        }
        $("." + container).append(divElem);
        $('#close-btn-' + btnIdCounter).click(function () {
            removeElem(this);
        });
        btnIdCounter++;

    }

    // add on change event handler for top dropdown
    $('#topElementAdder').on('change', function () {
        addElem('#topElementAdder', '.topContainer');
    });

    // add on change event handler for top left dropdown
    $('#top-leftElementAdder').on('change', function () {
        addElem('#top-leftElementAdder', '.top-leftContainer');
    });

    // add on change event handler for top right dropdown
    $('#top-rightElementAdder').on('change', function () {
        addElem('#top-rightElementAdder', '.top-rightContainer');
    });

    // add on change event handler for items dropdown
    $('#itemsElementAdder').on('change', function () {
        addElem('#itemsElementAdder', '.itemsContainer');
    });

    // add on change event handler for right dropdown
    $('#rightElementAdder').on('change', function () {
        addElem('#rightElementAdder', '.rightContainer');
    });

    // add on change event handler for bottom left dropdown
    $('#bottom-leftElementAdder').on('change', function () {
        addElem('#bottom-leftElementAdder', '.bottom-leftContainer');
    });

    // add on change event handler for bottom right dropdown
    $('#bottom-rightElementAdder').on('change', function () {
        addElem('#bottom-rightElementAdder', '.bottom-rightContainer');
    });

    // aadd on change event handler for bottom dropdown
    $('#bottomElementAdder').on('change', function () {
        addElem('#bottomElementAdder', '.bottomContainer');
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
        //start adding corresponding elements
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

        //set up regions object before form submission
        region = {
            'top': appHelper.setTopRegion(),
            'top-left': appHelper.setTopLeftRegion(),
            'top-right': appHelper.setTopRightRegion(),
            'items': appHelper.setItemsRegion(),
            'right': appHelper.setRightRegion(),
            'bottom-left': appHelper.setBottomLeftRegion(),
            'bottom-right': appHelper.setBottomRightRegion(),
            'bottom': appHelper.setBottomRegion()
        };

        //unset region if it only contains the header element
        $.each(region, function (index, reg) {
            if (reg.length == 1) {
                delete(region[index]);
            }
        });

        //insert regions stringified object to hidden input
        $('#regionsSetting').val(JSON.stringify(region));

        //submit form
        $('#frmSettings').submit();


    });
});
