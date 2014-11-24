<?php

// Examine the settings modal from post and replace the default
// $request variables.
function trueFalseConverter (&$object)
{
    foreach ($object as $key => $value) {
        if (is_array($value)) {
            $object[$key] = trueFalseConverter($value);
        } elseif ($value === 'true') {
            $object[$key] = true;
        } elseif ($value === 'false') {
            $object[$key] = false;
        }
    }
    return $object;
}

if (isset($_POST['api_type'])) {
    trueFalseConverter($_POST);

    switch ($_POST['api_type']) {
        case 'activities':
            $request = array_replace_recursive($request, $_POST);
            unset($request['api_type']);
            $requestKey = $request;
            break;
        case 'assess':
            $request = array_replace_recursive($request, $_POST);
            $requestKey = &$request;
            break;
        case 'items':
            if (array_key_exists('config', $request)) {
                $request['config'] = array_replace_recursive($request['config'], $_POST);
                $requestKey = &$request['config'];
            } else {
                $request = array_replace_recursive($request, $_POST);
                $requestKey = &$request;
            }
            unset($request['api_type']);
            break;
        case 'questioneditor':
            $request = array_replace_recursive($request, $_POST);
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
            $requestKey = &$request;
            break;
        case 'questioneditor-test-init':
            $request = $_POST['init'];
            break;
        default:
            # do nothing
            break;
    }

    if (!$requestKey['configuration']['idle_timeout']['use_idle_timeout']) {
        unset($requestKey['configuration']['idle_timeout']);
    }
    unset($requestKey['configuration']['idle_timeout']['use_idle_timeout']);

    if (!$requestKey['navigation']['show_calculator']['use_calculator']) {
        unset($requestKey['navigation']['show_calculator']);
    }
    unset($requestKey['navigation']['show_calculator']['use_calculator']);

    if (!$requestKey['configuration']['submit_criteria']['use_submit_criteria']) {
        unset($requestKey['configuration']['submit_criteria']);
    }
    unset($requestKey['configuration']['submit_criteria']['use_submit_criteria']);

    if (!$requestKey['navigation']['auto_save']['use_auto_save']) {
        unset($requestKey['navigation']['auto_save']);
    }
    unset($requestKey['navigation']['auto_save']['use_auto_save']);
}
