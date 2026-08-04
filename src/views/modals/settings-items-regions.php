<!--
********************************************************************
*
* Setup the Items API Settings modal for Regions
*
********************************************************************
-->
<div class="modal fade" id="settings" tabindex="-1" aria-labelledby="settings-title">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="settings-title">Items API – Custom Settings</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Learnosity Assess API regions allow you to create a personalized, fluid and extensible assessment UI. All UI
                elements such as buttons, time, pager, etc. are modularized in such a way that they can be placed in different
                regions of the Assess API container.</p>
                <form id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="regions">
                    <input type="hidden" name="itemsConfig" id="itemsConfig" value="">

                    <div class="card">
                        <div class="card-header">Region Settings</div>
                        <div class="card-body">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="regionSelector" class="col-sm-6 col-form-label">Regions</label>
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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('frmSettings').submit();">Initialize Items API &raquo;</button>
            </div>
        </div>
    </div>
</div>

<script>
    var currentRegion,
        regions;

    regions = {
        "minimal": {
            "form": {
                "label": "Minimal",
                "value": "minimal",
                "optgroup": "customRegions"
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
                "value": "vertical-toolbar",
                "optgroup": "customRegions"
            },
            "data": {
                "config": {
                    "regions": {
                        "right": [
                           {
                              "type": "flagitem_button"
                           },
                           {
                              "type": "masking_button"
                           },
                           {
                              "type": "reviewscreen_button"
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
        },
        "vertical-element": {
            "form": {
                "label": "Vertical Element",
                "value": "vertical-element",
                "optgroup": "customRegions"
            },
            "data": {
                "config": {
                  "regions": {
                      "items": [
                          {
                             "type": "vertical_element"
                          }
                      ],
                      "bottom": [
                          {
                              "type": "submit_button",
                              "position": "right"
                          }
                      ]
                  }
                }
            }
        },
        "main": {
            "form": {
                "label": "Main",
                "value": "main",
                "optgroup": "defaultRegions"
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
                "value": "horizontal",
                "optgroup": "defaultRegions"
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
                "value": "horizontal-fixed",
                "optgroup": "defaultRegions"
            },
            "data": {
                "config": {
                    "regions": "horizontal-fixed"
                }
            }
        }
    };

    currentRegion = <?php echo json_encode($request['config']['regions']); ?>;

    function loadRegions (currentRegion) {
        Object.values(regions).forEach((region) => {
            const option = document.createElement('option');
            option.value = region.form.value;
            option.textContent = region.form.label;
            option.selected = JSON.stringify(currentRegion) === JSON.stringify(region.data.config.regions);
            document.getElementById(region.form.optgroup).appendChild(option);
        });
    }

    function setRegionValue () {
        document.getElementById('itemsConfig').value = JSON.stringify(regions[this.value].data);
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadRegions(currentRegion);
        document.getElementById('regionSelector').addEventListener('change', setRegionValue);
    });
</script>
