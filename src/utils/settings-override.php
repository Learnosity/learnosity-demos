<?php

// Examine the settings modal form post and replace the default
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

    if ($_POST['api_type'] === 'items') {
        if (array_key_exists('config', $request)) {
            $request['config'] = array_replace_recursive($request['config'], $_POST);
            $requestKey = $request['config'];
        } else {
            $request = array_replace_recursive($request, $_POST);
            $requestKey = $request;
        }
    } elseif ($_POST['api_type'] === 'assess') {
        $request = array_replace_recursive($request, $_POST);
        $requestKey = $request;
    }

    // remove idle_timout settings if the should not be used
    if ($_POST['configuration']['idle_timeout']['use_idle_timeout'] === false) {
        unset($requestKey['configuration']['idle_timeout']);
    }
    unset($requestKey['configuration']['idle_timeout']['use_idle_timeout']);
}
