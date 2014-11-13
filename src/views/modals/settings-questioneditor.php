<!--
********************************************************************
*
* Setup the Question Editor API Settings modal
*
********************************************************************
-->
<?php
    // Shortcuts for convenience
    $base  = $request['base_question_type'];
    $ui  = $request['ui'];

    $service = 'Question Editor API';
    $serviceShortcut = 'questioneditor';
?>

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
                        <div class="panel-heading"><h3>Basic Settings</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="fixed_preview" class="col-sm-6 control-label">Change Accordion Order</label>
                                    <div class="col-sm-6">
                                        <ul class="sortable">
                                            <li data-reference="basic"><span class="glyphicon glyphicon-move"></span> Basic</li>
                                            <li data-reference="formatting"><span class="glyphicon glyphicon-move"></span> Formatting</li>
                                            <li data-reference="validation"><span class="glyphicon glyphicon-move"></span> Validation</li>
                                            <li data-reference="metadata"><span class="glyphicon glyphicon-move"></span> Metadata</li>
                                            <li data-reference="advanced"><span class="glyphicon glyphicon-move"></span> Advanced</li>
                                        </ul>
                                        <input type="hidden" name="accordion-order" id="accordion-order" value="<?php if (isset($request['accordion-order'])) { echo $request['accordion-order']; } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-6 control-label">Hide Accordion(s)</label>
                                    <div class="col-sm-6">
                                        <label for="hide_attribute_group_basic" class="control-label">
                                            <input type="checkbox" name="hide_attribute_group_basic" id="hide_attribute_group_basic" value="true"<?php if (isset($request['hide_attribute_group_basic'])) { echo ' checked'; }; ?>> Basic
                                        </label><br>
                                        <label for="hide_attribute_group_formatting" class="control-label">
                                            <input type="checkbox" name="hide_attribute_group_formatting" id="hide_attribute_group_formatting" value="true"<?php if (isset($request['hide_attribute_group_formatting'])) { echo ' checked'; }; ?>> Formatting <br>
                                        </label><br>
                                        <label for="hide_attribute_group_validation" class="control-label">
                                            <input type="checkbox" name="hide_attribute_group_validation" id="hide_attribute_group_validation" value="true"<?php if (isset($request['hide_attribute_group_validation'])) { echo ' checked'; }; ?>> Validation <br>
                                        </label><br>
                                        <label for="hide_attribute_group_metadata" class="control-label">
                                            <input type="checkbox" name="hide_attribute_group_metadata" id="hide_attribute_group_metadata" value="true"<?php if (isset($request['hide_attribute_group_metadata'])) { echo ' checked'; }; ?>> Metadata <br>
                                        </label><br>
                                        <label for="hide_attribute_group_advanced" class="control-label">
                                            <input type="checkbox" name="hide_attribute_group_advanced" id="hide_attribute_group_advanced" value="true"<?php if (isset($request['hide_attribute_group_advanced'])) { echo ' checked'; }; ?>> Advanced
                                        </label><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <?php if (!isset($removeOverrideFields) || !in_array('widget_type', $removeOverrideFields)) { ?>
                                <div class="form-group">
                                    <label for="widget_type" class="col-sm-6 control-label">Editor Type</label>
                                    <div class="col-sm-6">
                                        <select id="widget_type" name="widget_type">
                                            <option value="response"<?php if (isset($request['widget_type']) && $request['widget_type'] === 'response') { echo ' selected'; }; ?>>Questions</option>
                                            <option value="feature"<?php if (isset($request['widget_type']) && $request['widget_type'] === 'feature') { echo ' selected'; }; ?>>Features</option>
                                            <option value="feedback"<?php if (isset($request['widget_type']) && $request['widget_type'] === 'feedback') { echo ' selected'; }; ?>>Feedback</option>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="layout" class="col-sm-6 control-label">Layout</label>
                                    <div class="col-sm-6">
                                        <select id="layout" name="ui[layout]">
                                            <option value="2-column"<?php if (isset($ui['layout']) && $ui['layout'] === '2-column') { echo ' selected'; }; ?>>2 Column</option>
                                            <option value="tabbed"<?php if (isset($ui['layout']) && $ui['layout'] === 'tabbed') { echo ' selected'; }; ?>>Tabbed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fixed_preview" class="col-sm-6 control-label">Scroll Preview Panel</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="ui[fixed_preview]" value="true"<?php if (isset($ui['fixed_preview']) && $ui['fixed_preview'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="ui[fixed_preview]" value="false"<?php if (isset($ui['fixed_preview']) && $ui['fixed_preview'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_change_button" class="col-sm-6 control-label">Change Question Type</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="ui[change_button]" value="true"<?php if (isset($ui['change_button']) && $ui['change_button'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="ui[change_button]" value="false"<?php if (isset($ui['change_button']) && $ui['change_button'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_source_button" class="col-sm-6 control-label">Source View</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="ui[source_button]" value="true"<?php if (isset($ui['source_button']) && $ui['source_button'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="ui[source_button]" value="false"<?php if (isset($ui['source_button']) && $ui['source_button'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_documentation_link" class="col-sm-6 control-label">Documentation Link</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="ui[documentation_link]" value="true"<?php if (isset($ui['documentation_link']) && $ui['documentation_link'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="ui[documentation_link]" value="false"<?php if (isset($ui['documentation_link']) && $ui['documentation_link'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="getResponses" class="col-sm-6 control-label">Show getResponses()</label>
                                    <div class="col-sm-6">
                                        <?php
                                            $checkPublicMethods = false;
                                            if (isset($ui['public_methods']) && is_array($ui['public_methods']) && $ui['public_methods'][0] === 'getResponses') {
                                                $checkPublicMethods = true;
                                            }
                                        ?>
                                        <input type="radio" name="ui[public_methods]" value="getResponses"<?php if ($checkPublicMethods) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="ui[public_methods]" value=""<?php if (!$checkPublicMethods) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3>Hiding Attributes</h3>
                            <p>Note that most, but not all question attributes are shown below.</p>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <fieldset>
                                    <legend>Validation &amp; Scoring</legend>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Scoring Type</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[validation.scoring_type]" value="false"<?php if (!isset($base['hidden']) || !in_array('validation.scoring_type', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[validation.scoring_type]" value="true"<?php if (isset($base['hidden']) && in_array('validation.scoring_type', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Score</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[validation.valid_response.score]" value="false"<?php if (!isset($base['hidden']) || !in_array('validation.valid_response.score', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[validation.valid_response.score]" value="true"<?php if (isset($base['hidden']) && in_array('validation.valid_response.score', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Penalty</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[validation.penalty]" value="false"<?php if (!isset($base['hidden']) || !in_array('validation.penalty', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[validation.penalty]" value="true"<?php if (isset($base['hidden']) && in_array('validation.penalty', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Provide Instant Feedback</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[instant_feedback]" value="false"<?php if (!isset($base['hidden']) || !in_array('instant_feedback', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[instant_feedback]" value="true"<?php if (isset($base['hidden']) && in_array('instant_feedback', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Feedback Attempts Allowed</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[feedback_attempts]" value="false"<?php if (!isset($base['hidden']) || !in_array('feedback_attempts', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[feedback_attempts]" value="true"<?php if (isset($base['hidden']) && in_array('feedback_attempts', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Alternate Responses</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[validation.alt_responses]" value="false"<?php if (!isset($base['hidden']) || !in_array('validation.alt_responses', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[validation.alt_responses]" value="true"<?php if (isset($base['hidden']) && in_array('validation.alt_responses', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Duplicate Responses</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[duplicate_responses]" value="false"<?php if (!isset($base['hidden']) || !in_array('duplicate_responses', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[duplicate_responses]" value="true"<?php if (isset($base['hidden']) && in_array('duplicate_responses', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Multiple Responses</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[multiple_responses]" value="false"<?php if (!isset($base['hidden']) || !in_array('multiple_responses', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[multiple_responses]" value="true"<?php if (isset($base['hidden']) && in_array('multiple_responses', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Metadata</legend>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Metadata (entire section)</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[metadata]" value="false"<?php if (!isset($base['hidden']) || !in_array('metadata', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[metadata]" value="true"<?php if (isset($base['hidden']) && in_array('metadata', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Distractor Rationale</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[metadata.distractor_rationale]" value="false"<?php if (!isset($base['hidden']) || !in_array('metadata.distractor_rationale', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[metadata.distractor_rationale]" value="true"<?php if (isset($base['hidden']) && in_array('metadata.distractor_rationale', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Distractor Rationale Per Response</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[metadata.distractor_rationale_response_level]" value="false"<?php if (!isset($base['hidden']) || !in_array('metadata.distractor_rationale_response_level', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[metadata.distractor_rationale_response_level]" value="true"<?php if (isset($base['hidden']) && in_array('metadata.distractor_rationale_response_level', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Rubric Reference</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[metadata.rubric_reference]" value="false"<?php if (!isset($base['hidden']) || !in_array('metadata.rubric_reference', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[metadata.rubric_reference]" value="true"<?php if (isset($base['hidden']) && in_array('metadata.rubric_reference', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Sample Answer</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[metadata.sample_answer]" value="false"<?php if (!isset($base['hidden']) || !in_array('metadata.sample_answer', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[metadata.sample_answer]" value="true"<?php if (isset($base['hidden']) && in_array('metadata.sample_answer', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Acknowledgements</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[metadata.acknowledgements]" value="false"<?php if (!isset($base['hidden']) || !in_array('metadata.acknowledgements', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[metadata.acknowledgements]" value="true"<?php if (isset($base['hidden']) && in_array('metadata.acknowledgements', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Image</legend>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Image (entire section)</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[image]" value="false"<?php if (!isset($base['hidden']) || !in_array('image', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[image]" value="true"<?php if (isset($base['hidden']) && in_array('image', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Image URI</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[image.src]" value="false"<?php if (!isset($base['hidden']) || !in_array('image.src', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[image.src]" value="true"<?php if (isset($base['hidden']) && in_array('image.src', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Image URI (deprecated)</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[img_src]" value="false"<?php if (!isset($base['hidden']) || !in_array('img_src', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[img_src]" value="true"<?php if (isset($base['hidden']) && in_array('img_src', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Image Scale</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[image.scale]" value="false"<?php if (!isset($base['hidden']) || !in_array('image.scale', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[image.scale]" value="true"<?php if (isset($base['hidden']) && in_array('image.scale', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Image Alt Text</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[image.alt]" value="false"<?php if (!isset($base['hidden']) || !in_array('image.alt', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[image.alt]" value="true"<?php if (isset($base['hidden']) && in_array('image.alt', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Image Title</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[image.title]" value="false"<?php if (!isset($base['hidden']) || !in_array('image.title', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[image.title]" value="true"<?php if (isset($base['hidden']) && in_array('image.title', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-lg-6">
                                <fieldset>
                                    <legend>UI &amp; Formatting</legend>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">UI Style (entire section)</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[ui_style]" value="false"<?php if (!isset($base['hidden']) || !in_array('ui_style', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[ui_style]" value="true"<?php if (isset($base['hidden']) && in_array('ui_style', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Font Size</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[ui_style.fontsize]" value="false"<?php if (!isset($base['hidden']) || !in_array('ui_style.fontsize', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[ui_style.fontsize]" value="true"<?php if (isset($base['hidden']) && in_array('ui_style.fontsize', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Layout</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[ui_style.type]" value="false"<?php if (!isset($base['hidden']) || !in_array('ui_style.type', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[ui_style.type]" value="true"<?php if (isset($base['hidden']) && in_array('ui_style.type', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Min Height</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[ui_style.min_height]" value="false"<?php if (!isset($base['hidden']) || !in_array('ui_style.min_height', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[ui_style.min_height]" value="true"<?php if (isset($base['hidden']) && in_array('ui_style.min_height', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Max Height</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[ui_style.max_height]" value="false"<?php if (!isset($base['hidden']) || !in_array('ui_style.max_height', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[ui_style.max_height]" value="true"<?php if (isset($base['hidden']) && in_array('ui_style.max_height', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Drag Handle</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[ui_style.show_drag_handle]" value="false"<?php if (!isset($base['hidden']) || !in_array('ui_style.show_drag_handle', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[ui_style.show_drag_handle]" value="true"<?php if (isset($base['hidden']) && in_array('ui_style.show_drag_handle', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Max Selection</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[max_selection]" value="false"<?php if (!isset($base['hidden']) || !in_array('max_selection', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[max_selection]" value="true"<?php if (isset($base['hidden']) && in_array('max_selection', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Placeholder</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[placeholder]" value="false"<?php if (!isset($base['hidden']) || !in_array('placeholder', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[placeholder]" value="true"<?php if (isset($base['hidden']) && in_array('placeholder', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Miscellaneous</legend>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Stimulus</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[stimulus]" value="false"<?php if (!isset($base['hidden']) || !in_array('stimulus', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[stimulus]" value="true"<?php if (isset($base['hidden']) && in_array('stimulus', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Contains LaTeX/MathML?</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[is_math]" value="false"<?php if (!isset($base['hidden']) || !in_array('is_math', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[is_math]" value="true"<?php if (isset($base['hidden']) && in_array('is_math', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Case Sensitive</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[case_sensitive]" value="false"<?php if (!isset($base['hidden']) || !in_array('case_sensitive', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[case_sensitive]" value="true"<?php if (isset($base['hidden']) && in_array('case_sensitive', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Stimulus in Review</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[stimulus_review]" value="false"<?php if (!isset($base['hidden']) || !in_array('stimulus_review', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[stimulus_review]" value="true"<?php if (isset($base['hidden']) && in_array('stimulus_review', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Shuffle Options</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[shuffle_options]" value="false"<?php if (!isset($base['hidden']) || !in_array('shuffle_options', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[shuffle_options]" value="true"<?php if (isset($base['hidden']) && in_array('shuffle_options', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Response Container (global)</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[response_containers]" value="false"<?php if (!isset($base['hidden']) || !in_array('response_containers', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[response_containers]" value="true"<?php if (isset($base['hidden']) && in_array('response_containers', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Response Container (individual)</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[response_container]" value="false"<?php if (!isset($base['hidden']) || !in_array('response_container', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[response_container]" value="true"<?php if (isset($base['hidden']) && in_array('response_container', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Response Positions</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[response_positions]" value="false"<?php if (!isset($base['hidden']) || !in_array('response_positions', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[response_positions]" value="true"<?php if (isset($base['hidden']) && in_array('response_positions', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Description (deprecated)</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[description]" value="false"<?php if (!isset($base['hidden']) || !in_array('description', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[description]" value="true"<?php if (isset($base['hidden']) && in_array('description', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Character Map</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[character_map]" value="false"<?php if (!isset($base['hidden']) || !in_array('character_map', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[character_map]" value="true"<?php if (isset($base['hidden']) && in_array('character_map', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Multiple Line</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[multiple_line]" value="false"<?php if (!isset($base['hidden']) || !in_array('multiple_line', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[multiple_line]" value="true"<?php if (isset($base['hidden']) && in_array('multiple_line', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hide_attributes" class="col-sm-6 control-label">Browser Spellcheck</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="hidden[spellcheck]" value="false"<?php if (!isset($base['hidden']) || !in_array('spellcheck', $base['hidden'])) { echo ' checked'; }; ?>> Show &nbsp;
                                            <input type="radio" name="hidden[spellcheck]" value="true"<?php if (isset($base['hidden']) && in_array('spellcheck', $base['hidden'])) { echo ' checked'; }; ?>> Hide
                                        </div>
                                    </div>
                                </fieldset>

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

<script src="<?php echo $env['www']; ?>static/vendor/html5sortable/jquery.sortable.min.js"></script>
<script>
    var $order = $('#accordion-order'),
        $sortable = $('ul.sortable'),
        item;

    function renderAccordions (labels) {
        var newOrder;
        if ($order.val() !== '') {
            newOrder = $order.val().split(',');
        } else {
            newOrder = getAccordionOrder();
        }
        for (var i = 0; i < newOrder.length; i++) {
            item = $($sortable).find("[data-reference='" + newOrder[i] + "']");
            $(item).appendTo($sortable);
        }
    }

    function getAccordionOrder () {
        return $.map($('ul.sortable li'), function (val, i) {
            return $.trim($(val).data('reference'));
        });
    }

    function updateReferenceList () {
        $order.val(getAccordionOrder());
    }

    $(function () {
        $('.sortable').sortable();

        $('.sortable').sortable().bind('sortupdate', function() {
            updateReferenceList();
        });

        $('#settings').on('show.bs.modal', function (e) {
            renderAccordions();
        })
    });
</script>
