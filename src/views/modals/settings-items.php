<!--
********************************************************************
*
* Setup the Items API Settings modal
*
********************************************************************
-->
<?php
    // Shortcuts for convenience
    $con  = $request['config'];
    $nav  = $request['config']['navigation'];
    $time = $request['config']['time'];
?>
<div class="modal fade" id="settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Items API – Custom Settings</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="items">

                    <div class="panel panel-info">
                        <div class="panel-heading">Navigation/Control Settings</div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_prev" class="col-sm-6 control-label">Show Previous</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_prev]" value="true"<?php if (isset($nav['show_prev']) && $nav['show_prev'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[show_prev]" value="false"<?php if (isset($nav['show_prev']) && $nav['show_prev'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_next" class="col-sm-6 control-label">Show Next</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_next]" value="true"<?php if (isset($nav['show_next']) && $nav['show_next'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[show_next]" value="false"<?php if (isset($nav['show_next']) && $nav['show_next'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_save" class="col-sm-6 control-label">Show Save</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_save]" value="true"<?php if (isset($nav['show_save']) && $nav['show_save'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[show_save]" value="false"<?php if (isset($nav['show_save']) && $nav['show_save'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_submit" class="col-sm-6 control-label">Show Submit</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_submit]" value="true"<?php if (isset($nav['show_submit']) && $nav['show_submit'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[show_submit]" value="false"<?php if (isset($nav['show_submit']) && $nav['show_submit'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label for="show_accessibility" class="col-sm-6 control-label">Show Accessibility</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_accessibility]" value="true"<?php if (isset($nav['show_accessibility']) && $nav['show_accessibility'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[show_accessibility]" value="false"<?php if (isset($nav['show_accessibility']) && $nav['show_accessibility'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_answermasking" class="col-sm-6 control-label">Show Response Masking</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_answermasking]" value="true"<?php if (isset($nav['show_answermasking']) && $nav['show_answermasking'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[show_answermasking]" value="false"<?php if (isset($nav['show_answermasking']) && $nav['show_answermasking'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_pause" class="col-sm-6 control-label">Show Pause</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="time[show_pause]" value="true"<?php if (isset($time['show_pause']) && $time['show_pause'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="time[show_pause]" value="false"<?php if (isset($time['show_pause']) && $time['show_pause'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="toc" class="col-sm-6 control-label">Show Table of Contents</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[toc]" value="true"<?php if (isset($nav['toc']) && $nav['toc'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[toc]" value="false"<?php if (isset($nav['toc']) && $nav['toc'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_fullscreencontrol" class="col-sm-6 control-label">Show Fullscreen</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_fullscreencontrol]" value="true"<?php if (isset($nav['show_fullscreencontrol']) && $nav['show_fullscreencontrol'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[show_fullscreencontrol]" value="false"<?php if (isset($nav['show_fullscreencontrol']) && $nav['show_fullscreencontrol'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_calculator" class="col-sm-6 control-label">Show Calculator</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_calculator]" value="true"<?php if (isset($nav['show_calculator']) && $nav['show_calculator'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[show_calculator]" value="false"<?php if (isset($nav['show_calculator']) && $nav['show_calculator'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="warning_on_change" class="col-sm-6 control-label">Show warning if not question not attempted</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[warning_on_change]" value="true"<?php if (isset($nav['warning_on_change']) && $nav['warning_on_change'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[warning_on_change]" value="false"<?php if (isset($nav['warning_on_change']) && $nav['warning_on_change'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="skip_submit_confirmation" class="col-sm-6 control-label">Skip confirmation window on submit</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[skip_submit_confirmation]" value="true"<?php if (isset($nav['skip_submit_confirmation']) && $nav['skip_submit_confirmation'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[skip_submit_confirmation]" value="false"<?php if (isset($nav['skip_submit_confirmation']) && $nav['skip_submit_confirmation'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p>The following are recommended to be turned on if using the <em>horizontal fixed</em> layout.</p>
                                </div>
                                <div class="form-group">
                                    <label for="scroll_to_top" class="col-sm-6 control-label">Scroll to top</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[scroll_to_top]" value="true"<?php if (isset($nav['scroll_to_top']) && $nav['scroll_to_top'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[scroll_to_top]" value="false"<?php if (isset($nav['scroll_to_top']) && $nav['scroll_to_top'] === false || !isset($nav['scroll_to_top'])) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="scroll_to_test" class="col-sm-6 control-label">Scroll to test</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[scroll_to_test]" value="true"<?php if (isset($nav['scroll_to_test']) && $nav['scroll_to_test'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[scroll_to_test]" value="false"<?php if (isset($nav['scroll_to_test']) && $nav['scroll_to_test'] === false || !isset($nav['scroll_to_test'])) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">UI / Time Settings</div>
                        <div class="panel-body">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_progress" class="col-sm-6 control-label">Show Progress Bar</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_progress]" value="true"<?php if (isset($nav['show_progress']) && $nav['show_progress'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[show_progress]" value="false"<?php if (isset($nav['show_progress']) && $nav['show_progress'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_time" class="col-sm-6 control-label">Show Time</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="time[show_time]" value="true"<?php if (isset($time['show_time']) && $time['show_time'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="time[show_time]" value="false"<?php if (isset($time['show_time']) && $time['show_time'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_itemcount" class="col-sm-6 control-label">Show Item Count</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_itemcount]" value="true"<?php if (isset($nav['show_itemcount']) && $nav['show_itemcount'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[show_itemcount]" value="false"<?php if (isset($nav['show_itemcount']) && $nav['show_itemcount'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="scrolling_indicator" class="col-sm-6 control-label">Show Scrolling Indicator<br>(horizontal-fixed layout only)</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[scrolling_indicator]" value="true"<?php if (isset($nav['scrolling_indicator']) && $nav['scrolling_indicator'] === true) { echo ' checked'; }; ?>> True
                                        <input type="radio" name="navigation[scrolling_indicator]" value="false"<?php if (isset($nav['scrolling_indicator']) && $nav['scrolling_indicator'] === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="idle_timeout" class="col-sm-6 control-label">Idle Timout</label>
                                    <div class="col-sm-6">
                                         <input type="radio" name="configuration[idle_timeout][use_idle_timeout]" value="true"<?php if (isset($con['configuration']['idle_timeout'])) { echo ' checked'; }; ?>> True
                                         <input type="radio" name="configuration[idle_timeout][use_idle_timeout]" value="false"<?php if ( isset($con['configuration']['idle_timeout']) === false) { echo ' checked'; }; ?>> False
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Interval (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="0" step="1" class="form-control" name="configuration[idle_timeout][interval]" value="<?php if (isset($con['configuration']['idle_timeout']['interval'])) { echo $con['configuration']['idle_timeout']['interval']; } else { echo '0'; } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="countdown_time" class="col-sm-6 control-label">Countdown Time (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="0" step="1" class="form-control" name="configuration[idle_timeout][countdown_time]" value="<?php if (isset($con['configuration']['idle_timeout']['countdown_time'])) { echo $con['configuration']['idle_timeout']['countdown_time']; } else { echo '0'; } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_time" class="col-sm-6 control-label">Limit Type</label>
                                    <div class="col-sm-6">
                                        <select id="limit_type" name="time[limit_type]">
                                            <option value="soft"<?php if (isset($con['time']['limit_type']) && $con['time']['limit_type'] === 'soft') { echo ' selected'; }; ?>>Soft</option>
                                            <option value="hard"<?php if (isset($con['time']['limit_type']) && $con['time']['limit_type'] === 'hard') { echo ' selected'; }; ?>>Hard</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ui_style" class="col-sm-6 control-label">UI Style</label>
                                    <div class="col-sm-6">
                                        <select id="ui_style" name="ui_style">
                                            <option value="main"<?php if (isset($con['ui_style']) && $con['ui_style'] === 'main') { echo ' selected'; }; ?>>Main</option>
                                            <option value="horizontal"<?php if (isset($con['ui_style']) && $con['ui_style'] === 'horizontal') { echo ' selected'; }; ?>>Horizontal</option>
                                            <option value="horizontal-fixed"<?php if (isset($con['ui_style']) && $con['ui_style'] === 'horizontal-fixed') { echo ' selected'; }; ?>>Horizontal Fixed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="transition" class="col-sm-6 control-label">Transition</label>
                                    <div class="col-sm-6">
                                        <select id="transition" name="navigation[transition]">
                                            <option value="slide"<?php if (isset($nav['transition']) && $nav['transition'] === 'slide') { echo ' selected'; }; ?>>Slide</option>
                                            <option value="fade"<?php if (isset($nav['transition']) && $nav['transition'] === 'fade') { echo ' selected'; }; ?>>Fade</option>
                                            <option value="toggle"<?php if (isset($nav['transition']) && $nav['transition'] === 'toggle') { echo ' selected'; }; ?>>Toggle</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fontsize" class="col-sm-6 control-label">Font Size</label>
                                    <div class="col-sm-6">
                                        <select id="fontsize" name="configuration[fontsize]">
                                            <option value="small"<?php if (isset($con['configuration']['fontsize']) && $con['configuration']['fontsize'] === 'small') { echo ' selected'; }; ?>>Small</option>
                                            <option value="normal"<?php if (isset($con['configuration']['fontsize']) && $con['configuration']['fontsize'] === 'normal') { echo ' selected'; }; ?>>Normal</option>
                                            <option value="large"<?php if (isset($con['configuration']['fontsize']) && $con['configuration']['fontsize'] === 'large') { echo ' selected'; }; ?>>Large</option>
                                            <option value="xlarge"<?php if (isset($con['configuration']['fontsize']) && $con['configuration']['fontsize'] === 'xlarge') { echo ' selected'; }; ?>>X Large</option>
                                            <option value="xxlarge"<?php if (isset($con['configuration']['fontsize']) && $con['configuration']['fontsize'] === 'xxlarge') { echo ' selected'; }; ?>>XX Large</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="warning_time" class="col-sm-6 control-label">Warning Time (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="100" max="1000" step="100" class="form-control" name="time[warning_time]" value="<?php if (isset($time['warning_time'])) { echo $time['warning_time']; }; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="transition-speed" class="col-sm-6 control-label">Transition Speed (ms)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="100" max="1000" step="100" class="form-control" name="navigation[transition_speed]" value="<?php if (isset($nav['transition_speed'])) { echo $nav['transition_speed']; }; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="transition-speed" class="col-sm-6 control-label">Custom Stylesheet</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="configuration[stylesheet]" value="<?php if (isset($con['configuration']['stylesheet'])) { echo $con['configuration']['stylesheet']; }; ?>">
                                    </div>
                                    <div class="col-sm-12">
                                        <p class="help-block pull-right">eg http://demos.learnosity.com/assessment/items/custom.css</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">Title Settings</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="show_title" class="col-sm-2 control-label">Show Title</label>
                                <div class="col-sm-10">
                                    <input type="radio" name="navigation[show_title]" value="true"<?php if (isset($nav['show_title']) && $nav['show_title'] === true) { echo ' checked'; }; ?>> True
                                    <input type="radio" name="navigation[show_title]" value="false"<?php if (isset($nav['show_title']) && $nav['show_title'] === false) { echo ' checked'; }; ?>> False
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Activity Title</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Override the default activity name" value="<?php if (isset($con['title'])) { echo $con['title']; }; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subtitle" class="col-sm-2 control-label">Activity Subtitle</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Subtitle of the activity" value="<?php if (isset($con['subtitle'])) { echo $con['subtitle']; }; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('frmSettings').submit();">Initialise Items API &raquo;</button>
            </div>
        </div>
    </div>
</div>
