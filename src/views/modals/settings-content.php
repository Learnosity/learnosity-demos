<div class="modal fade" id="settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $service ?> – Custom Settings</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="<?php echo $serviceShortcut ?>">
                    <input type="hidden" id="regionsSetting" name="regionsSetting" value="">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="presetsWrapper">
                                <div class="presetsLabel">
                                    <label for="presetsSelector" class="control-label">Presets</label>
                                </div>
                                <div class="presetsSelector">
                                    <select id="regionsPresetsSelector" name="regionsPresetsSelector">
                                        <optgroup label="Learnosity Defaults" id="defaultRegions">
                                            <option value="main">Main</option>
                                            <option value="horizontal">Horizontal</option>
                                            <option value="horizontal-fixed">Horizontal Fixed</option>
                                        </optgroup>
                                        <optgroup label="Customisations" id="customRegions">
                                            <option value="custom">Custom</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <h3>Region Settings</h3></div>
                        <div class="panel-body">

                                <div class="form-group">

                                    <?php include 'regions-settings.php'?>
<!--                                    --><?php //include 'table.php'; ?>
<!--                                    --><?php //include 'region-settings-content.php';?>
                                </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Navigation/Control Settings</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Intro Item</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_intro]"
                                               value="true"<?php if (isset($nav['show_intro']) && $nav['show_intro'] === true) {
                                            echo ' checked';
                                        }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_intro]"
                                               value="false"<?php if (isset($nav['show_intro']) && $nav['show_intro'] === false) {
                                            echo ' checked';
                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Outro Item</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_outro]"
                                               value="true"<?php if (isset($nav['show_outro']) && $nav['show_outro'] === true) {
                                            echo ' checked';
                                        }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_outro]"
                                               value="false"<?php if (isset($nav['show_outro']) && $nav['show_outro'] === false) {
                                            echo ' checked';
                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="submit_criteria" class="col-sm-6 control-label">Submit Criteria</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="configuration[submit_criteria][use_submit_criteria]"
                                               value="true"<?php if (isset($con['configuration']['submit_criteria']) && $con['configuration']['submit_criteria'] !== false) {
                                            echo ' checked';
                                        }; ?>> Enable &nbsp;
                                        <input type="radio" name="configuration[submit_criteria][use_submit_criteria]"
                                               value="false"<?php if (isset($con['configuration']['submit_criteria']) === false || $con['configuration']['submit_criteria'] === false) {
                                            echo ' checked';
                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="col-sm-6 control-label">Submit Criteria Type</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="configuration[submit_criteria][type]"
                                               value="attempted"<?php if (isset($con['configuration']['submit_criteria']['type']) && $con['configuration']['submit_criteria']['type'] === 'attempted') {
                                            echo ' checked';
                                        }; ?>> Attempted &nbsp;
                                        <input type="radio" name="configuration[submit_criteria][type]"
                                               value="valid"<?php if (isset($con['configuration']['submit_criteria']['type']) && $con['configuration']['submit_criteria']['type'] === 'valid') {
                                            echo ' checked';
                                        }; ?>> Valid
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="threshold" class="col-sm-6 control-label">Submit Criteria
                                        Threshold</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="0" max="100" step="10" class="form-control"
                                               name="configuration[submit_criteria][threshold]"
                                               value="<?php if (isset($con['configuration']['submit_criteria']['threshold'])) {
                                                   echo $con['configuration']['submit_criteria']['threshold'];
                                               } else {
                                                   echo '0';
                                               } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="warning_on_change" class="col-sm-6 control-label">Warning if question(s)
                                        not attempted</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[warning_on_change]"
                                               value="true"<?php if (isset($nav['warning_on_change']) && $nav['warning_on_change'] === true) {
                                            echo ' checked';
                                        }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[warning_on_change]"
                                               value="false"<?php if (isset($nav['warning_on_change']) && $nav['warning_on_change'] === false) {
                                            echo ' checked';
                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="skip_submit_confirmation" class="col-sm-6 control-label">Skip
                                        confirmation window on submit</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[skip_submit_confirmation]"
                                               value="true"<?php if (isset($nav['skip_submit_confirmation']) && $nav['skip_submit_confirmation'] === true) {
                                            echo ' checked';
                                        }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[skip_submit_confirmation]"
                                               value="false"<?php if (isset($nav['skip_submit_confirmation']) && $nav['skip_submit_confirmation'] === false) {
                                            echo ' checked';
                                        }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>UI / Time Settings</h3></div>
                        <div class="panel-body">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="configuration[reading_mode][reading_time]"
                                           class="col-sm-6 control-label">Reading Time (sec)</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="0" step="1" class="form-control"
                                               name="configuration[reading_mode][reading_time]"
                                               value="<?php if (isset($con['configuration']['reading_mode']['reading_time'])) {
                                                   echo $con['configuration']['reading_mode']['reading_time'];
                                               } else {
                                                   echo '0';
                                               } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="configuration[reading_mode][warning_time]"
                                           class="col-sm-6 control-label">Warning Reading Time (sec)</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="0" step="1" class="form-control"
                                               name="configuration[reading_mode][warning_time]"
                                               value="<?php if (isset($con['configuration']['reading_mode']['warning_time'])) {
                                                   echo $con['configuration']['reading_mode']['warning_time'];
                                               } else {
                                                   echo '0';
                                               } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Go To First Item When Reading Time
                                        Over</label>
                                    <div class="col-sm-6">
                                        <input type="radio"
                                               name="configuration[reading_mode][goto_first_item_on_reading_time_completion]"
                                               value="true"<?php if (isset($con['configuration']['reading_mode']['goto_first_item_on_reading_time_completion']) && $con['configuration']['reading_mode']['goto_first_item_on_reading_time_completion'] === true) {
                                            echo ' checked';
                                        }; ?>> Enable &nbsp;
                                        <input type="radio"
                                               name="configuration[reading_mode][goto_first_item_on_reading_time_completion]"
                                               value="false"<?php if (isset($con['configuration']['reading_mode']['goto_first_item_on_reading_time_completion']) && $con['configuration']['reading_mode']['goto_first_item_on_reading_time_completion'] === false) {
                                            echo ' checked';
                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="question_count_option" class="col-sm-6 control-label">Item Count based
                                        off Questions</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[item_count][question_count_option]"
                                               value="true"<?php if (isset($nav['item_count']['question_count_option']) && $nav['item_count']['question_count_option'] === true) {
                                            echo ' checked';
                                        }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[item_count][question_count_option]"
                                               value="false"<?php if (isset($nav['item_count']['question_count_option']) && $nav['item_count']['question_count_option'] === false) {
                                            echo ' checked';
                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="idle_timeout" class="col-sm-6 control-label">Idle Timout Warning</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="configuration[idle_timeout][use_idle_timeout]"
                                               value="true"<?php if (isset($con['configuration']['idle_timeout']) && $con['configuration']['idle_timeout'] !== false) {
                                            echo ' checked';
                                        }; ?>> Enable &nbsp;
                                        <input type="radio" name="configuration[idle_timeout][use_idle_timeout]"
                                               value="false"<?php if (isset($con['configuration']['idle_timeout']) === false || $con['configuration']['idle_timeout'] === false) {
                                            echo ' checked';
                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Idle Timeout Interval
                                        (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="0" step="1" class="form-control"
                                               name="configuration[idle_timeout][interval]"
                                               value="<?php if (isset($con['configuration']['idle_timeout']['interval'])) {
                                                   echo $con['configuration']['idle_timeout']['interval'];
                                               } else {
                                                   echo '0';
                                               } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="countdown_time" class="col-sm-6 control-label">Idle/Remote Control
                                        Timeout Countdown (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="0" step="1" class="form-control"
                                               name="configuration[idle_timeout][countdown_time]"
                                               value="<?php if (isset($con['configuration']['idle_timeout']['countdown_time'])) {
                                                   echo $con['configuration']['idle_timeout']['countdown_time'];
                                               } else {
                                                   echo '0';
                                               } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="auto_save" class="col-sm-6 control-label">Auto Save</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[auto_save][use_auto_save]"
                                               value="true"<?php if (isset($nav['auto_save']) && $nav['auto_save'] !== false) {
                                            echo ' checked';
                                        }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[auto_save][use_auto_save]"
                                               value="false"<?php if (isset($nav['auto_save']) === false || $nav['auto_save'] === false) {
                                            echo ' checked';
                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ui" class="col-sm-6 control-label">Auto Save UI Indicator</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[auto_save][ui]"
                                               value="true"<?php if (isset($nav['auto_save']['ui']) && $nav['auto_save']['ui'] === true) {
                                            echo ' checked';
                                        }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[auto_save][ui]"
                                               value="false"<?php if (isset($nav['auto_save']['ui']) && $nav['auto_save']['ui'] === false) {
                                            echo ' checked';
                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="saveIntervalDuration" class="col-sm-6 control-label">Auto Save Interval
                                        (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="0" step="1" class="form-control"
                                               name="navigation[auto_save][saveIntervalDuration]"
                                               value="<?php if (isset($nav['auto_save']['saveIntervalDuration'])) {
                                                   echo $nav['auto_save']['saveIntervalDuration'];
                                               } else {
                                                   echo '0';
                                               } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="max_time" class="col-sm-6 control-label">Assessment Time (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="100" max="1000" step="100" class="form-control"
                                               name="time[max_time]" value="<?php if (isset($time['max_time'])) {
                                            echo $time['max_time'];
                                        }; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="warning_time" class="col-sm-6 control-label">End Assessment Warning Time
                                        (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="100" max="1000" step="100" class="form-control"
                                               name="time[warning_time]"
                                               value="<?php if (isset($time['warning_time'])) {
                                                   echo $time['warning_time'];
                                               }; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_time" class="col-sm-6 control-label">Limit Type</label>
                                    <div class="col-sm-6">
                                        <select id="limit_type" name="time[limit_type]">
                                            <option value="soft"<?php if (isset($con['time']['limit_type']) && $con['time']['limit_type'] === 'soft') {
                                                echo ' selected';
                                            }; ?>>Soft
                                            </option>
                                            <option value="hard"<?php if (isset($con['time']['limit_type']) && $con['time']['limit_type'] === 'hard') {
                                                echo ' selected';
                                            }; ?>>Hard
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="transition" class="col-sm-6 control-label">Item Transition</label>
                                    <div class="col-sm-6">
                                        <select id="transition" name="navigation[transition]">
                                            <option value="fade"<?php if (isset($nav['transition']) && $nav['transition'] === 'fade') {
                                                echo ' selected';
                                            }; ?>>Fade
                                            </option>
                                            <option value="toggle"<?php if (isset($nav['transition']) && $nav['transition'] === 'toggle') {
                                                echo ' selected';
                                            }; ?>>Toggle
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="transition-speed" class="col-sm-6 control-label">Transition Speed
                                        (ms)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="100" max="1000" step="100" class="form-control"
                                               name="navigation[transition_speed]"
                                               value="<?php if (isset($nav['transition_speed'])) {
                                                   echo $nav['transition_speed'];
                                               }; ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Title Settings</h3></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Activity Title</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" id="title"
                                           placeholder="Override the default activity name"
                                           value="<?php if (isset($con['title'])) {
                                               echo $con['title'];
                                           }; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subtitle" class="col-sm-2 control-label">Activity Subtitle</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="subtitle" id="subtitle"
                                           placeholder="Subtitle of the activity"
                                           value="<?php if (isset($con['subtitle'])) {
                                               echo $con['subtitle'];
                                           }; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitForm">Initialise <?php echo $service ?>
                    &raquo;
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var main = {
        'top-left': [
            { type: 'title_element' },
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
            { type: 'timer_element' },
            { type: 'reading_timer_element' },
            { type: 'itemcount_element' },
            {
                type: 'header_element',
                default_label_option: 'regionHeaderTopRight'
            }
        ],
        right: [
            { type: 'verticaltoc_element' },
            { type: 'save_button' },
            { type: 'fullscreen_button' },
            { type: 'reviewscreen_button' },
            { type: 'accessibility_button' },
            { type: 'calculator_button' },
            { type: 'flagitem_button' },
            {
                type: 'header_element',
                default_label_option: 'regionHeaderRight'
            }
        ],
        'bottom-right': [
            { type: 'next_button' },
            { type: 'previous_button' },
            {
                type: 'header_element',
                default_label_option: 'regionHeaderBottomRight'
            }
        ]
    };

    var horizontal = {
        'top-left': [
            { type: 'title_element' },
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
            { type: 'timer_element' },
            { type: 'reading_timer_element' },
            { type: 'itemcount_element' },
            {
                type: 'header_element',
                default_label_option: 'regionHeaderTopRight'
            }
        ],
        right: [
            { type: 'save_button' },
            { type: 'fullscreen_button' },
            { type: 'reviewscreen_button' },
            { type: 'accessibility_button' },
            { type: 'calculator_button' },
            { type: 'flagitem_button' },
            {
                type: 'header_element',
                default_label_option: 'regionHeaderRight'
            }
        ],
        bottom: [
            { type: 'next_button' },
            { type: 'horizontaltoc_element' },
            { type: 'previous_button' },
            {
                type: 'header_element',
                default_label_option: 'regionHeaderBottom'
            }
        ]
    };

    var horizontal_fixed = {
        'top-left': [
            { type: 'title_element' },
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
            { type: 'timer_element' },
            { type: 'reading_timer_element' },
            { type: 'itemcount_element' },
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
        { type: 'progress_element' },
        {
            type: 'header_element',
            default_label_option: 'regionHeaderItems'
        }
    ],
        right: [
            { type: 'save_button' },
            { type: 'fullscreen_button' },
            { type: 'reviewscreen_button' },
            { type: 'accessibility_button' },
            { type: 'calculator_button' },
            { type: 'flagitem_button' },
            {
                type: 'header_element',
                default_label_option: 'regionHeaderRight'
            }
        ],
        bottom: [
            { type: 'next_button' },
            { type: 'horizontaltoc_element' },
            { type: 'previous_button' },
            {
                type: 'header_element',
                default_label_option: 'regionHeaderBottom'
            }
        ]
    };
    $(function () {

        $('#submitForm').on('click',function(){
            setTopLeftRegion();

            setTopRightRegion();

            setItemsRegion();

            setRightRegion();

            setBottomLeftRegion();

            setBottomRightRegion();

            setBottomRegion();

            region = {
                'top-left': topLeftRegion,
                'top-right': topRightRegion,
                'items': itemsRegion,
                'right': rightRegion,
                'bottom-left': bottomLeftRegion,
                'bottom-right': bottomRightRegion,
                'bottom': bottomRegion
            };

            $.each(region, function (index, reg){
                if (reg.length == 1){
                    delete(region[index]);
                }
            });

            $('#regionsSetting').val(JSON.stringify(region));

            $('#frmSettings').submit();


        });

    });
</script>
