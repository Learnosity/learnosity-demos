<?php

// Examine the settings modal from post and replace the default
// $request variables.
function typeConverter(&$object)
{
    foreach ($object as $key => $value) {
        if (is_array($value)) {
            $object[$key] = typeConverter($value);
        } elseif ($value === 'true') {
            $object[$key] = true;
        } elseif ($value === 'false') {
            $object[$key] = false;
        } elseif (is_numeric($value)) {
            $object[$key] = (float)$value;
        }
    }
    return $object;
}

$filter_post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($filter_post['api_type'])) {
    typeConverter($filter_post);

    switch ($filter_post['api_type']) {
        case 'activities':
            $request = array_replace_recursive($request, $filter_post);
            unset($request['api_type']);
            $requestKey = $request;
            break;
        case 'assess':
            $request = array_replace_recursive($request, $filter_post);
            $requestKey = &$request;
            break;
        case 'author':
            if (array_key_exists('config', $request)) {
                $request['config'] = array_replace_recursive($request['config'], $filter_post);
                $requestKey = &$request['config'];
            } else {
                $request = array_replace_recursive($request, $filter_post);
                $requestKey = &$request;
            }
            if (isset($requestKey['item_list']['limit'])) {
                $requestKey['item_list']['limit'] = intval($requestKey['item_list']['limit']);
            }
            if (isset($requestKey['activity_list']['limit'])) {
                $requestKey['activity_list']['limit'] = intval($requestKey['activity_list']['limit']);
            }
            break;
        case 'items':
            if (array_key_exists('config', $request)) {
                //decode regionsSetting string into json and store in $regionTemp
                $regionTemp = json_decode(html_entity_decode($filter_post['regionsSetting']));
                //unset $filter_post keys
                unset($filter_post['regionsSetting']);
                unset($filter_post['regionsPresetsSelector']);
                unset($request['config']['regions']);
                //overwrite current $request['config'] with what was sent via POST
                $request['config'] = array_replace_recursive($request['config'], $filter_post);
                //replace current $request['config']['regions'] with what was sent via POST
                $request['config']['regions'] = $regionTemp;
                $requestKey = &$request['config'];
            } else {
                $request = array_replace_recursive($request, $filter_post);
                $requestKey = &$request;
            }

            break;
        case 'questioneditor':
            $request = array_replace_recursive($request, $filter_post);
            if (isset($request['ui']['public_methods'])) {
                if (!empty($request['ui']['public_methods'])) {
                    $request['ui']['public_methods'] = [$request['ui']['public_methods']];
                } else {
                    unset($request['ui']['public_methods']);
                }
            }
            // Determine if we are to remove any accordions
            $hideAccordions = [];
            if (isset($request['hide_attribute_group_basic'])) {
                $hideAccordions[] = 'basic';
            }
            if (isset($request['hide_attribute_group_formatting'])) {
                $hideAccordions[] = 'formatting';
            }
            if (isset($request['hide_attribute_group_validation'])) {
                $hideAccordions[] = 'validation';
            }
            if (isset($request['hide_attribute_group_metadata'])) {
                $hideAccordions[] = 'metadata';
            }
            if (isset($request['hide_attribute_group_advanced'])) {
                $hideAccordions[] = 'advanced';
            }
            if (count($hideAccordions)) {
                foreach ($hideAccordions as $accLabel) {
                    foreach ($request['base_question_type']['attribute_groups'] as $a => $accordion) {
                        if ($accordion['reference'] === $accLabel) {
                            array_splice($request['base_question_type']['attribute_groups'], $a, 1);
                            continue;
                        }
                    }
                }
            }
            if (isset($request['accordion-order']) && !empty($request['accordion-order'])) {
                $accordions = [];
                $orderList = explode(',', $request['accordion-order']);
                foreach ($orderList as $reference) {
                    foreach ($request['base_question_type']['attribute_groups'] as $accordion) {
                        if ($accordion['reference'] === $reference) {
                            $accordions[] = $accordion;
                        }
                    }
                }
                $request['base_question_type']['attribute_groups'] = $accordions;
            }
            if (isset($request['hidden']) && is_array($request['hidden'])) {
                $hiddenAttributes = [];
                foreach ($request['hidden'] as $h => $val) {
                    if ($val === true) {
                        $hiddenAttributes[] = $h;
                    }
                }
                $request['base_question_type']['hidden'] = $hiddenAttributes;
                unset($request['hidden']);
            }
            if (isset($request['ui']['public_methods']) && is_array($request['ui']['public_methods'])) {
                $methods = [];
                foreach ($request['ui']['public_methods'][0] as $h => $val) {
                    if ($val === true) {
                        $methods[] = $h;
                    }
                }
                $request['ui']['public_methods'] = $methods;
            }
            $requestKey = &$request;
            break;
        case 'questioneditorV3':
            if (isset($filter_post['ui']) && isset($filter_post['ui']['layout'])) {
                $request['ui']['layout']['global_template'] = $filter_post['ui']['layout'];
            }

            if (isset($filter_post['widget_type'])) {
                $request['widget_type'] = $filter_post['widget_type'];
                if ($filter_post['widget_type'] !== 'response') {
                    unset($request['widget_json']);
                } else {
                    $request['question_type'] = $filter_post['question_type'];
                    switch ($filter_post['question_type']) {
                        case 'association':
                            $request['widget_json'] = $questionJsonAssociation;
                            break;
                        case 'choicematrix':
                            $request['widget_json'] = $questionJsonChoiceMatrix;
                            break;
                        default:
                        case 'mcq':
                            $request['widget_json'] = $questionJsonMcq;
                            break;
                    }
                }
            }
            break;
        case 'questioneditor-test-init':
            $request = $filter_post['init'];
            break;
        case 'regions':
            // unfudge the quoting in the filter_input_array because you can't use FILTER_FLAG_NO_ENCODE_QUOTES
            $json = str_replace(
                array("&#34;", "&#39;"),
                array("\"", "'"),
                $filter_post['itemsConfig'] = ($filter_post['itemsConfig'] == "") ? json_encode(['config' => ['regions' => 'main']]) : $filter_post['itemsConfig']
            );

            $itemsConfig = json_decode($json, true);
            $request = array_replace_recursive($request, $itemsConfig);

            unset($request['api_type']);
            unset($request['regionSelector']);
            $requestKey = $request;
            break;
        default:
            # do nothing
            break;
    }

    if (!isset($requestKey['configuration']['idle_timeout']['use_idle_timeout'])) {
        unset($requestKey['configuration']['idle_timeout']);
    }
    unset($requestKey['configuration']['idle_timeout']['use_idle_timeout']);

    if (!isset($requestKey['navigation']['show_calculator']['use_calculator'])) {
        unset($requestKey['navigation']['show_calculator']);
    }
    unset($requestKey['navigation']['show_calculator']['use_calculator']);

    if (!isset($requestKey['configuration']['submit_criteria']['use_submit_criteria'])) {
        unset($requestKey['configuration']['submit_criteria']);
    }
    unset($requestKey['configuration']['submit_criteria']['use_submit_criteria']);

    if (!isset($requestKey['navigation']['auto_save']['use_auto_save'])) {
        unset($requestKey['navigation']['auto_save']);
    }
    unset($requestKey['navigation']['auto_save']['use_auto_save']);

    if (!isset($requestKey['configuration']['api_type'])) {
        unset($requestKey['api_type']);
    }
}