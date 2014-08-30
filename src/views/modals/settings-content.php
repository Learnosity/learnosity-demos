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

                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Navigation/Control Settings</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Intro Item</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_intro]" value="true"<?php if (isset($nav['show_intro']) && $nav['show_intro'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_intro]" value="false"<?php if (isset($nav['show_intro']) && $nav['show_intro'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Outro Item</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_outro]" value="true"<?php if (isset($nav['show_outro']) && $nav['show_outro'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_outro]" value="false"<?php if (isset($nav['show_outro']) && $nav['show_outro'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_prev" class="col-sm-6 control-label">Previous</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_prev]" value="true"<?php if (isset($nav['show_prev']) && $nav['show_prev'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_prev]" value="false"<?php if (isset($nav['show_prev']) && $nav['show_prev'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_next" class="col-sm-6 control-label">Next</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_next]" value="true"<?php if (isset($nav['show_next']) && $nav['show_next'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_next]" value="false"<?php if (isset($nav['show_next']) && $nav['show_next'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_pause" class="col-sm-6 control-label">Pause</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="time[show_pause]" value="true"<?php if (isset($time['show_pause']) && $time['show_pause'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="time[show_pause]" value="false"<?php if (isset($time['show_pause']) && $time['show_pause'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_save" class="col-sm-6 control-label">Save</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_save]" value="true"<?php if (isset($nav['show_save']) && $nav['show_save'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_save]" value="false"<?php if (isset($nav['show_save']) && $nav['show_save'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_submit" class="col-sm-6 control-label">Submit</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_submit]" value="true"<?php if (isset($nav['show_submit']) && $nav['show_submit'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_submit]" value="false"<?php if (isset($nav['show_submit']) && $nav['show_submit'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_fullscreencontrol" class="col-sm-6 control-label">Fullscreen</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_fullscreencontrol]" value="true"<?php if (isset($nav['show_fullscreencontrol']) && $nav['show_fullscreencontrol'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_fullscreencontrol]" value="false"<?php if (isset($nav['show_fullscreencontrol']) && $nav['show_fullscreencontrol'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_answermasking" class="col-sm-6 control-label">Response Masking</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_answermasking]" value="true"<?php if (isset($nav['show_answermasking']) && $nav['show_answermasking'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_answermasking]" value="false"<?php if (isset($nav['show_answermasking']) && $nav['show_answermasking'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_accessibility" class="col-sm-6 control-label">Accessibility Options</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_accessibility]" value="true"<?php if (isset($nav['show_accessibility']) && $nav['show_accessibility'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_accessibility]" value="false"<?php if (isset($nav['show_accessibility']) && $nav['show_accessibility'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_calculator" class="col-sm-6 control-label">Calculator</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_calculator][use_calculator]" value="true"<?php if (isset($nav['show_calculator']) && $nav['show_calculator'] !== false) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_calculator][use_calculator]" value="false"<?php if (isset($nav['show_calculator']) == false || $nav['show_calculator'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_calculator" class="col-sm-6 control-label">Calculator Mode</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_calculator][mode]" value="basic"<?php if (isset($nav['show_calculator']['mode']) && $nav['show_calculator']['mode'] === 'basic') { echo ' checked'; }; ?>> Basic &nbsp;
                                        <input type="radio" name="navigation[show_calculator][mode]" value="scientific"<?php if (isset($nav['show_calculator']['mode']) && $nav['show_calculator']['mode'] === 'scientific') { echo ' checked'; }; ?>> Scientific
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="toc" class="col-sm-6 control-label">Table of Contents</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[toc]" value="true"<?php if (isset($nav['toc']) && $nav['toc'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[toc]" value="false"<?php if (isset($nav['toc']) && $nav['toc'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="warning_on_change" class="col-sm-6 control-label">Warning if question(s) not attempted</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[warning_on_change]" value="true"<?php if (isset($nav['warning_on_change']) && $nav['warning_on_change'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[warning_on_change]" value="false"<?php if (isset($nav['warning_on_change']) && $nav['warning_on_change'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="skip_submit_confirmation" class="col-sm-6 control-label">Skip confirmation window on submit</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[skip_submit_confirmation]" value="true"<?php if (isset($nav['skip_submit_confirmation']) && $nav['skip_submit_confirmation'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[skip_submit_confirmation]" value="false"<?php if (isset($nav['skip_submit_confirmation']) && $nav['skip_submit_confirmation'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="scroll_to_test" class="col-sm-6 control-label">Scroll to the test element on test start</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[scroll_to_test]" value="true"<?php if (isset($nav['scroll_to_test']) && $nav['scroll_to_test'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[scroll_to_test]" value="false"<?php if (isset($nav['scroll_to_test']) && $nav['scroll_to_test'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="scroll_to_top" class="col-sm-6 control-label">Scroll to Top on item change</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[scroll_to_top]" value="true"<?php if (isset($nav['scroll_to_top']) && $nav['scroll_to_top'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[scroll_to_top]" value="false"<?php if (isset($nav['scroll_to_top']) && $nav['scroll_to_top'] === false) { echo ' checked'; }; ?>> Disable
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
                                    <label for="show_progress" class="col-sm-6 control-label">Progress Bar</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_progress]" value="true"<?php if (isset($nav['show_progress']) && $nav['show_progress'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_progress]" value="false"<?php if (isset($nav['show_progress']) && $nav['show_progress'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_time" class="col-sm-6 control-label">Timer</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="time[show_time]" value="true"<?php if (isset($time['show_time']) && $time['show_time'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="time[show_time]" value="false"<?php if (isset($time['show_time']) && $time['show_time'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_itemcount" class="col-sm-6 control-label">Item Count</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[show_itemcount]" value="true"<?php if (isset($nav['show_itemcount']) && $nav['show_itemcount'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[show_itemcount]" value="false"<?php if (isset($nav['show_itemcount']) && $nav['show_itemcount'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="idle_timeout" class="col-sm-6 control-label">Idle Timout Warning</label>
                                    <div class="col-sm-6">
                                         <input type="radio" name="configuration[idle_timeout][use_idle_timeout]" value="true"<?php if (isset($con['configuration']['idle_timeout']) &&  $con['configuration']['idle_timeout'] !== false) { echo ' checked'; }; ?>> Enable &nbsp;
                                         <input type="radio" name="configuration[idle_timeout][use_idle_timeout]" value="false"<?php if (isset($con['configuration']['idle_timeout']) === false || $con['configuration']['idle_timeout'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Idle Timeout Interval (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="0" step="1" class="form-control" name="configuration[idle_timeout][interval]" value="<?php if (isset($con['configuration']['idle_timeout']['interval'])) { echo $con['configuration']['idle_timeout']['interval']; } else { echo '0'; } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="auto_save" class="col-sm-6 control-label">Auto Save</label>
                                    <div class="col-sm-6">
                                         <input type="radio" name="navigation[auto_save][use_auto_save]" value="true"<?php if (isset($nav['auto_save']) && $nav['auto_save'] !== false) { echo ' checked'; }; ?>> Enable &nbsp;
                                         <input type="radio" name="navigation[auto_save][use_auto_save]" value="false"<?php if (isset($nav['auto_save']) === false || $nav['auto_save'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ui" class="col-sm-6 control-label">Auto Save UI Indicator</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[auto_save][ui]" value="true"<?php if (isset($nav['auto_save']['ui']) && $nav['auto_save']['ui'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[auto_save][ui]" value="false"<?php if (isset($nav['auto_save']['ui']) && $nav['auto_save']['ui'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="saveIntervalDuration" class="col-sm-6 control-label">Auto Save Interval (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="0" step="1" class="form-control" name="navigation[auto_save][saveIntervalDuration]" value="<?php if (isset($nav['auto_save']['saveIntervalDuration'])) { echo $nav['auto_save']['saveIntervalDuration']; } else { echo '0'; } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="scrolling_indicator" class="col-sm-6 control-label">Scrolling Indicator<br>(Horizontal Fixed layout only)</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="navigation[scrolling_indicator]" value="true"<?php if (isset($nav['scrolling_indicator']) && $nav['scrolling_indicator'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="navigation[scrolling_indicator]" value="false"<?php if (isset($nav['scrolling_indicator']) && $nav['scrolling_indicator'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="max_time" class="col-sm-6 control-label">Assessment Time (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="100" max="1000" step="100" class="form-control" name="time[max_time]" value="<?php if (isset($time['max_time'])) { echo $time['max_time']; }; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="warning_time" class="col-sm-6 control-label">End Assessment Warning Time (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="100" max="1000" step="100" class="form-control" name="time[warning_time]" value="<?php if (isset($time['warning_time'])) { echo $time['warning_time']; }; ?>">
                                    </div>
                                </div>
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
                                    <label for="ui_style" class="col-sm-6 control-label">Layout</label>
                                    <div class="col-sm-6">
                                        <select id="ui_style" name="ui_style">
                                            <option value="main"<?php if (isset($con['ui_style']) && $con['ui_style'] === 'main') { echo ' selected'; }; ?>>Main</option>
                                            <option value="horizontal"<?php if (isset($con['ui_style']) && $con['ui_style'] === 'horizontal') { echo ' selected'; }; ?>>Horizontal</option>
                                            <option value="horizontal-fixed"<?php if (isset($con['ui_style']) && $con['ui_style'] === 'horizontal-fixed') { echo ' selected'; }; ?>>Horizontal Fixed</option>
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
                                    <label for="transition" class="col-sm-6 control-label">Item Transition</label>
                                    <div class="col-sm-6">
                                        <select id="transition" name="navigation[transition]">
                                            <option value="slide"<?php if (isset($nav['transition']) && $nav['transition'] === 'slide') { echo ' selected'; }; ?>>Slide</option>
                                            <option value="fade"<?php if (isset($nav['transition']) && $nav['transition'] === 'fade') { echo ' selected'; }; ?>>Fade</option>
                                            <option value="toggle"<?php if (isset($nav['transition']) && $nav['transition'] === 'toggle') { echo ' selected'; }; ?>>Toggle</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="transition-speed" class="col-sm-6 control-label">Transition Speed (ms)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="100" max="1000" step="100" class="form-control" name="navigation[transition_speed]" value="<?php if (isset($nav['transition_speed'])) { echo $nav['transition_speed']; }; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="countdown_time" class="col-sm-6 control-label">Remote Control Countdown Time (sec)</label>
                                    <div class="col-sm-3">
                                        <input type="number" min="0" step="1" class="form-control" name="configuration[idle_timeout][countdown_time]" value="<?php if (isset($con['configuration']['idle_timeout']['countdown_time'])) { echo $con['configuration']['idle_timeout']['countdown_time']; } else { echo '0'; } ?>">
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
                        <div class="panel-heading"><h3>Administration Panel Settings</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_save" class="col-sm-6 control-label">Save</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="administration[options][show_save]" value="true"<?php if (isset($admin['options']['show_save']) && $admin['options']['show_save'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="administration[options][show_save]" value="false"<?php if (isset($admin['options']['show_save']) && $admin['options']['show_save'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_exit" class="col-sm-6 control-label">Exit</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="administration[options][show_exit]" value="true"<?php if (isset($admin['options']['show_exit']) && $admin['options']['show_exit'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="administration[options][show_exit]" value="false"<?php if (isset($admin['options']['show_exit']) && $admin['options']['show_exit'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_extend" class="col-sm-6 control-label">Extend</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="administration[options][show_extend]" value="true"<?php if (isset($admin['options']['show_extend']) && $admin['options']['show_extend'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="administration[options][show_extend]" value="false"<?php if (isset($admin['options']['show_extend']) && $admin['options']['show_extend'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6"></div>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Title Settings</h3></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="show_title" class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="radio" name="navigation[show_title]" value="true"<?php if (isset($nav['show_title']) && $nav['show_title'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                    <input type="radio" name="navigation[show_title]" value="false"<?php if (isset($nav['show_title']) && $nav['show_title'] === false) { echo ' checked'; }; ?>> Disable
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
                <button type="button" class="btn btn-primary" onclick="document.getElementById('frmSettings').submit();">Initialise <?php echo $service ?> &raquo;</button>
            </div>
        </div>
    </div>
</div>
