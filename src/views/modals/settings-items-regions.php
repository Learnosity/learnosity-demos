<!--
********************************************************************
*
* Setup the Items API Settings modal for Regions
*
********************************************************************
-->
<div class="modal fade" id="settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Items API – Custom Settings</h4>
            </div>
            <div class="modal-body">
                <p>Learnosity Assess API regions allow you to create a personalized, fluid and extensible assessment UI. All UI
                elements such as buttons, time, pager, etc. are modularized in such a way that they can be placed in different
                regions of the Assess API container.</p>
                <form class="form-horizontal" role="form" id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="regions">
                    <input type="hidden" name="itemsConfig" id="itemsConfig" value="">

                    <div class="panel panel-info">
                        <div class="panel-heading">Region Settings</div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="regionSelector" class="col-sm-6 control-label">Regions</label>
                                    <div class="col-sm-6">
                                        <select id="regionSelector" name="regionSelector">
                                            <optgroup label="Learnosity Defaults" id="defaultRegions"></optgroup>
                                            <optgroup label="Sample Customisations" id="customRegions"></optgroup>
                                        </select>
                                    </div>
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

<script>
    var customRegions,
        defaultRegions,
        currentRegion;

    /************************************************
     *
     * I'm truly sorry for the code below, it was late
     * and I was tired. I really have no excuse :(
     *
     ************************************************/

    customRegions = {
        "minimal": {
            "form": {
                "label": "Minimal",
                "value": "minimal"
            },
            "data": {
                "config": {
                    "regions": {
                        "top-right": [
                            {
                                "type": "pause_button"
                            },
                            {
                                "type": "timer_element"
                            }
                        ],
                        "bottom": [
                            {
                                "type": "previous_button",
                                "position": "left"
                            },
                            {
                                "type": "next_button",
                                "position": "right"
                            },
                            {
                                "type": "save_button",
                                "position": "right"
                            }
                        ]
                    },
                    "ui_style": "horizontal"
                }
            }
        },
        "vertical-toolbar": {
            "form": {
                "label": "Vertical Toolbar",
                "value": "vertical-toolbar"
            },
            "data": {
                "config": {
                    "regions": {
                        "right": [
                           {
                              "type": "flagitem_button"
                           },
                           {
                              "type": "reviewscreen_button"
                           },
                           {
                              "type": "masking_button"
                           },
                           {
                              "type": "separator_element"
                           },
                           {
                              "type": "save_button"
                           },
                           {
                              "type": "separator_element"
                           },
                           {
                              "type": "previous_button"
                           },
                           {
                              "type": "next_button"
                           }
                        ]
                    }
                }
            }
        }
    };

    defaultRegions = {
        "main": {
            "form": {
                "label": "Main",
                "value": "main"
            },
            "data": {
                "config": {
                    "regions":"main"
                }
            }
        },
        "horizontal": {
            "form": {
                "label": "Horizontal",
                "value": "horizontal"
            },
            "data": {
                "config": {
                    "regions": "horizontal"
                }
            }
        },
        "horizontal-fixed": {
            "form": {
                "label": "Horizontal Fixed",
                "value": "horizontal-fixed"
            },
            "data": {
                "config": {
                    "regions": "horizontal-fixed"
                }
            }
        }
    };

    currentRegion = <?php echo json_encode($request['config']['regions']); ?>;

    function setRegionValue (el) {
        var selectedRegion = $('option:selected', this).val(),
            optGroup = $('option:selected', this).parent().attr('id');

        if (optGroup === 'defaultRegions') {
            $('#itemsConfig').val(JSON.stringify(defaultRegions[selectedRegion]['data']));
        }

        if (optGroup === 'customRegions') {
            $('#itemsConfig').val(JSON.stringify(customRegions[selectedRegion]['data']));
        }
    }

    function setupRegionSelects (currentRegion) {
        $.each(defaultRegions, function (i, val) {
            var selected = (currentRegion === val['form']['value']) ? ' selected': '';
            $('#defaultRegions').append('<option value="' + val['form']['value'] + '" ' + selected + '>' + val['form']['label'] + '</option>');
            selected = '';
        });
        $.each(customRegions, function (i, val) {
            var selected = (JSON.stringify(currentRegion) === JSON.stringify(val['data'].config.regions)) ? ' selected': '';
            $('#customRegions').append('<option value="' + val['form']['value'] + '" ' + selected + '>' + val['form']['label'] + '</option>');
            selected = '';
        });
    }

    $(function() {
        setupRegionSelects(currentRegion);
        $('#regionSelector').on('change', setRegionValue);
    });
</script>
