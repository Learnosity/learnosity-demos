<!--
********************************************************************
*
* Setup the Author API Settings modal
*
********************************************************************
-->
<?php
function getConfigFromRequest($config, $key)
{
    $emptyObject = new stdclass();
    if (!empty($config[$key])) {
        return $config[$key];
    }
    return (array)$emptyObject;
}

    // Shortcuts for convenience
    $con                 = $request['config'];
    $mode                = $request['mode'];
    $list                = getConfigFromRequest($con, 'item_list');
    $activity_list       = getConfigFromRequest($con, 'activity_list');
    $item_edit           = getConfigFromRequest($con, 'item_edit');
    $activity_edit       = getConfigFromRequest($con, 'activity_edit');
    $widget_templates    = getConfigFromRequest($con, 'widget_templates');
    $question_editor_api = getConfigFromRequest($con, 'dependencies')['question_editor_api'];

    $service         = 'Author API';
    $serviceShortcut = 'author';
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

                    <?php if ($mode === 'activity_list') { ?>
                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Activity List</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Show activity status</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="activity_list[status]" value="true"<?php if (isset($activity_list['status']) && $activity_list['status'] === true) {
                                            echo ' checked';
                                                                                                     }; ?>> Enable &nbsp;
                                        <input type="radio" name="activity_list[status]" value="false"<?php if (isset($activity_list['status']) && $activity_list['status'] === false) {
                                            echo ' checked';
                                                                                                      }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show <em>CREATE</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="activity_list[toolbar][add]" value="true"<?php if (isset($activity_list['toolbar']['add']) && $activity_list['toolbar']['add'] === true) {
                                            echo ' checked';
                                                                                                           }; ?>> Enable &nbsp;
                                        <input type="radio" name="activity_list[toolbar][add]" value="false"<?php if (isset($activity_list['toolbar']['add']) && $activity_list['toolbar']['add'] === false) {
                                            echo ' checked';
                                                                                                            }; ?>> Disable
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show <em>SEARCH</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="activity_list[toolbar][search]" value="true"<?php if (isset($activity_list['toolbar']['add']) && $activity_list['toolbar']['add'] === true) {
                                            echo ' checked';
                                                                                                              }; ?>> Enable &nbsp;
                                        <input type="radio" name="activity_list[toolbar][search]" value="false"<?php if (isset($activity_list['toolbar']['add']) && $activity_list['toolbar']['add'] === false) {
                                            echo ' checked';
                                                                                                               }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Number of activities per page (max 50)</label>
                                    <div class="col-sm-6">
                                        <input type="number" name="activity_list[limit]" value="<?php if (isset($activity_list['limit'])) {
                                            echo $activity_list['limit'];
                                                                                                }; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Activity Edit</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <?php if ($mode === 'activity_list') { ?>
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Show <em>Back</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="activity_edit[back]" value="true"<?php if (isset($activity_edit['back']) && $activity_edit['back'] === true) {
                                            echo ' checked';
                                                                                                   }; ?>> Enable &nbsp;
                                        <input type="radio" name="activity_edit[back]" value="false"<?php if (isset($activity_edit['back']) && $activity_edit['back'] === false) {
                                            echo ' checked';
                                                                                                    }; ?>> Disable
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show <em>Save</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="activity_edit[save][show]" value="true"<?php if (isset($activity_edit['save']['show']) && $activity_edit['save']['show'] === true) {
                                            echo ' checked';
                                                                                                         }; ?>> Enable &nbsp;
                                        <input type="radio" name="activity_edit[save][show]" value="false"<?php if (isset($activity_edit['save']['show']) && $activity_edit['save']['show'] === false) {
                                            echo ' checked';
                                                                                                          }; ?>> Disable
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show <em>Source</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="activity_edit[source]" value="true"<?php if (isset($activity_edit['source']) && $activity_edit['source'] === true) {
                                            echo ' checked';
                                                                                                     }; ?>> Enable &nbsp;
                                        <input type="radio" name="activity_edit[source]" value="false"<?php if (isset($activity_edit['source']) && $activity_edit['source'] === false) {
                                            echo ' checked';
                                                                                                      }; ?>> Disable
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show activity reference</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="activity_edit[reference][show]" value="true"<?php if (isset($activity_edit['reference']['show']) && $activity_edit['reference']['show'] === true) {
                                            echo ' checked';
                                                                                                              }; ?>> Enable &nbsp;
                                        <input type="radio" name="activity_edit[reference][show]" value="false"<?php if (isset($activity_edit['reference']['show']) && $activity_edit['reference']['show'] === false) {
                                            echo ' checked';
                                                                                                               }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Edit activity reference</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="activity_edit[reference][edit]" value="true"<?php if (isset($activity_edit['reference']['edit']) && $activity_edit['reference']['edit'] === true) {
                                            echo ' checked';
                                                                                                              }; ?>> Enable &nbsp;
                                        <input type="radio" name="activity_edit[reference][edit]" value="false"<?php if (isset($activity_edit['reference']['edit']) && $activity_edit['reference']['edit'] === false) {
                                            echo ' checked';
                                                                                                               }; ?>> Disable
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Default activity mode</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="activity_edit[mode][default]" value="edit"<?php if (isset($activity_edit['mode']['default']) && $activity_edit['mode']['default'] == 'edit') {
                                            echo ' checked';
                                                                                                            }; ?>> Edit &nbsp;
                                        <input type="radio" name="activity_edit[mode][default]" value="preview"<?php if (isset($activity_edit['mode']['default']) && $activity_edit['mode']['default'] == 'preview') {
                                            echo ' checked';
                                                                                                               }; ?>> Preview
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show toggle activity mode</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="activity_edit[mode][show]" value="true"<?php if (isset($activity_edit['mode']['show']) && $activity_edit['mode']['show'] === true) {
                                            echo ' checked';
                                                                                                         }; ?>> Enable &nbsp;
                                        <input type="radio" name="activity_edit[mode][show]" value="false"<?php if (isset($activity_edit['mode']['show']) && $activity_edit['mode']['show'] === false) {
                                            echo ' checked';
                                                                                                          }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($mode === 'item_list') { ?>
                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Item List</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Show item status</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_list[item][status]" value="true"<?php if (isset($list['item']['status']) && $list['item']['status'] === true) {
                                            echo ' checked';
                                                                                                       }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_list[item][status]" value="false"<?php if (isset($list['item']['status']) && $list['item']['status'] === false) {
                                            echo ' checked';
                                                                                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show <em>New Item</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_list[toolbar][add]" value="true"<?php if (isset($list['toolbar']['add']) && $list['toolbar']['add'] === true) {
                                            echo ' checked';
                                                                                                       }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_list[toolbar][add]" value="false"<?php if (isset($list['toolbar']['add']) && $list['toolbar']['add'] === false) {
                                            echo ' checked';
                                                                                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Filter items to current user</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_list[filter][restricted][current_user]" value="true"<?php if (isset($list['filter']['restricted']['current_user']) && $list['filter']['restricted']['current_user'] === true) {
                                            echo ' checked';
                                                                                                                           }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_list[filter][restricted][current_user]" value="false"<?php if (isset($list['filter']['restricted']['current_user']) && $list['filter']['restricted']['current_user'] === false) {
                                            echo ' checked';
                                                                                                                            }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="item_edit[item][dynamic_content]" class="col-sm-6 control-label">Show <em>Dynamic Content</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][dynamic_content]" value="true"<?php if (isset($item_edit['item']['dynamic_content']) && $item_edit['item']['dynamic_content'] === true) {
                                            echo ' checked';
                                                                                                                }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][dynamic_content]" value="false"<?php if (isset($item_edit['item']['dynamic_content']) && $item_edit['item']['dynamic_content'] === false) {
                                            echo ' checked';
                                                                                                                 }; ?>> Disable
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="item_edit[item][duplicate]" class="col-sm-6 control-label">Show <em>Duplicate</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][duplicate]" value="true"<?php if (isset($item_edit['item']['duplicate']) && $item_edit['item']['duplicate'] === true) {
                                            echo ' checked';
                                                                                                          }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][duplicate]" value="false"<?php if (isset($item_edit['item']['duplicate']) && $item_edit['item']['duplicate'] === false) {
                                            echo ' checked';
                                                                                                           }; ?>> Disable
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="item_edit[item][shared_passage]" class="col-sm-6 control-label">Show <em>Find existing passage</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][shared_passage]" value="true"<?php if (isset($item_edit['item']['shared_passage']) && $item_edit['item']['shared_passage'] === true) {
                                            echo ' checked';
                                                                                                               }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][shared_passage]" value="false"<?php if (isset($item_edit['item']['shared_passage']) && $item_edit['item']['shared_passage'] === false) {
                                            echo ' checked';
                                                                                                                }; ?>> Disable
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Number of items per page (max 50)</label>
                                    <div class="col-sm-6">
                                        <input type="number" name="item_list[limit]" value="<?php if (isset($list['limit'])) {
                                            echo $list['limit'];
                                                                                            }; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Item Edit</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <?php if ($mode === 'item_list') { ?>
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Show <em>Back</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][back]" value="true"<?php if (isset($item_edit['item']['back']) && $item_edit['item']['back'] === true) {
                                            echo ' checked';
                                                                                                     }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][back]" value="false"<?php if (isset($item_edit['item']['back']) && $item_edit['item']['back'] === false) {
                                            echo ' checked';
                                                                                                      }; ?>> Disable
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="item_edit[item][columns]" class="col-sm-6 control-label">Show <em>Columns</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][columns]" value="true"<?php if (isset($item_edit['item']['columns']) && $item_edit['item']['columns'] === true) {
                                            echo ' checked';
                                                                                                        }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][columns]" value="false"<?php if (isset($item_edit['item']['columns']) && $item_edit['item']['columns'] === false) {
                                            echo ' checked';
                                                                                                         }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="item_edit[item][tabs]" class="col-sm-6 control-label">Show <em>Tabs</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][tabs]" value="true"<?php if (isset($item_edit['item']['tabs']) && $item_edit['item']['tabs'] === true) {
                                            echo ' checked';
                                                                                                     }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][tabs]" value="false"<?php if (isset($item_edit['item']['tabs']) && $item_edit['item']['tabs'] === false) {
                                            echo ' checked';
                                                                                                      }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show <em>Save</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][save]" value="true"<?php if (isset($item_edit['item']['save']) && $item_edit['item']['save'] === true) {
                                            echo ' checked';
                                                                                                     }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][save]" value="false"<?php if (isset($item_edit['item']['save']) && $item_edit['item']['save'] === false) {
                                            echo ' checked';
                                                                                                      }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Default item mode</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][mode][default]" value="edit"<?php if (isset($item_edit['item']['mode']['default']) && $item_edit['item']['mode']['default'] == 'edit') {
                                            echo ' checked';
                                                                                                              }; ?>> Edit &nbsp;
                                        <input type="radio" name="item_edit[item][mode][default]" value="preview"<?php if (isset($item_edit['item']['mode']['default']) && $item_edit['item']['mode']['default'] == 'preview') {
                                            echo ' checked';
                                                                                                                 }; ?>> Preview
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show toggle item mode</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][mode][show]" value="true"<?php if (isset($item_edit['item']['mode']['show']) && $item_edit['item']['mode']['show'] === true) {
                                            echo ' checked';
                                                                                                           }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][mode][show]" value="false"<?php if (isset($item_edit['item']['mode']['show']) && $item_edit['item']['mode']['show'] === false) {
                                            echo ' checked';
                                                                                                            }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show item reference</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][reference][show]" value="true"<?php if (isset($item_edit['item']['reference']['show']) && $item_edit['item']['reference']['show'] === true) {
                                            echo ' checked';
                                                                                                                }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][reference][show]" value="false"<?php if (isset($item_edit['item']['reference']['show']) && $item_edit['item']['reference']['show'] === false) {
                                            echo ' checked';
                                                                                                                 }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Edit item reference</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][reference][edit]" value="true"<?php if (isset($item_edit['item']['reference']['edit']) && $item_edit['item']['reference']['edit'] === true) {
                                            echo ' checked';
                                                                                                                }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][reference][edit]" value="false"<?php if (isset($item_edit['item']['reference']['edit']) && $item_edit['item']['reference']['edit'] === false) {
                                            echo ' checked';
                                                                                                                 }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show item status</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][status]" value="true"<?php if (isset($item_edit['item']['status']) && $item_edit['item']['status'] === true) {
                                            echo ' checked';
                                                                                                       }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][status]" value="false"<?php if (isset($item_edit['item']['status']) && $item_edit['item']['status'] === false) {
                                            echo ' checked';
                                                                                                        }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Enable widget edit</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[widget][edit]" value="true"<?php if (isset($item_edit['widget']['edit']) && $item_edit['widget']['edit'] === true) {
                                            echo ' checked';
                                                                                                       }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[widget][edit]" value="false"<?php if (isset($item_edit['widget']['edit']) && $item_edit['widget']['edit'] === false) {
                                            echo ' checked';
                                                                                                        }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Enable widget delete</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[widget][delete]" value="true"<?php if (isset($item_edit['widget']['delete']) && $item_edit['widget']['delete'] === true) {
                                            echo ' checked';
                                                                                                         }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[widget][delete]" value="false"<?php if (isset($item_edit['widget']['delete']) && $item_edit['widget']['delete'] === false) {
                                            echo ' checked';
                                                                                                          }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Widget Edit</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Show Back button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="widget_templates[back]" value="true"<?php if (isset($widget_templates['back']) && $widget_templates['back'] === true) {
                                            echo ' checked';
                                                                                                      }; ?>> Enable &nbsp;
                                        <input type="radio" name="widget_templates[back]" value="false"<?php if (isset($widget_templates['back']) && $widget_templates['back'] === false) {
                                            echo ' checked';
                                                                                                       }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show Save button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="widget_templates[save]" value="true"<?php if (isset($widget_templates['save']) && $widget_templates['save'] === true) {
                                            echo ' checked';
                                                                                                      }; ?>> Enable &nbsp;
                                        <input type="radio" name="widget_templates[save]" value="false"<?php if (isset($widget_templates['save']) && $widget_templates['save'] === false) {
                                            echo ' checked';
                                                                                                       }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Default widget type</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="widget_templates[widget_types][default]" value="questions"<?php if (isset($widget_templates['widget_types']['default']) && $widget_templates['widget_types']['default'] === 'questions') {
                                            echo ' checked';
                                                                                                                            }; ?>> Questions &nbsp;
                                        <input type="radio" name="widget_templates[widget_types][default]" value="features"<?php if (isset($widget_templates['widget_types']['default']) && $widget_templates['widget_types']['default'] === 'features') {
                                            echo ' checked';
                                                                                                                           }; ?>> Features
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show widget types</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="widget_templates[widget_types][show]" value="true"<?php if (isset($widget_templates['widget_types']['show']) && $widget_templates['widget_types']['show'] === true) {
                                            echo ' checked';
                                                                                                                    }; ?>> Enable &nbsp;
                                        <input type="radio" name="widget_templates[widget_types][show]" value="false"<?php if (isset($widget_templates['widget_types']['show']) && $widget_templates['widget_types']['show'] === false) {
                                            echo ' checked';
                                                                                                                     }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Question Editor</h3></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="show_intro" class="col-sm-6 control-label">Version</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="dependencies[question_editor_api][version]" value="v2"<?php if (isset($question_editor_api['version']) && $question_editor_api['version'] === 'v2') {
                                                echo ' checked';
                                                                                                                            }; ?>> v2 &nbsp;<br>
                                            <input type="radio" name="dependencies[question_editor_api][version]" value="v3"<?php if (isset($question_editor_api['version']) && $question_editor_api['version'] === 'v3') {
                                                echo ' checked';
                                                                                                                            }; ?>> v3
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 style="border-bottom: 1px solid #ebf0f0; padding-bottom: 15px; margin-bottom: 20px;">Version 3 settings only</h4>
                                    <div class="form-group">
                                        <label for="show_intro" class="col-sm-6 control-label">Global Layout</label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="dependencies[question_editor_api][init_options][ui][layout][global_template]" value="edit"<?php if (isset($question_editor_api['init_options']['ui']['layout']['global_template']) && $question_editor_api['init_options']['ui']['layout']['global_template'] === 'edit') {
                                                echo ' checked';
                                                                                                                                                                }; ?>> Edit only &nbsp;<br>
                                            <input type="radio" name="dependencies[question_editor_api][init_options][ui][layout][global_template]" value="edit_preview"<?php if (isset($question_editor_api['init_options']['ui']['layout']['global_template']) && $question_editor_api['init_options']['ui']['layout']['global_template'] === 'edit_preview') {
                                                echo ' checked';
                                                                                                                                                                        }; ?>> Edit and Preview &nbsp;
                                        </div>
                                    </div>
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
