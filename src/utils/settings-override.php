<?php

// Examine the settings modal form post and replace the default
// $request variables.
if (isset($_POST['ui_style'])) {
    foreach ($_POST as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $subkey => $subvalue) {
                if ($subvalue === 'true') {
                    $_POST[$key][$subkey] = true;
                } elseif ($subvalue === 'false') {
                    $_POST[$key][$subkey] = false;
                }
            }
        } else {
            if ($value === 'true') {
                $_POST[$key] = (bool)$value;
            } elseif ($value === 'false') {
                $_POST[$key] = false;
            }
        }
    }

    if ($_POST['api_type'] === 'items') {
        $request['config'] = array_replace_recursive($request['config'], $_POST);
        $requestKey = $request['config'];
    } elseif ($_POST['api_type'] === 'assess') {
        $request = array_replace_recursive($request, $_POST);
        $requestKey = $request;
    }

    // remove idle_timout settings if the should not be used
    if ($_POST['configuration']['idle_timeout']['use_idle_timeout'] === 'false') {
        unset($requestKey['configuration']['idle_timeout']);
    }
    unset($requestKey['configuration']['idle_timeout']['use_idle_timeout']);
}
