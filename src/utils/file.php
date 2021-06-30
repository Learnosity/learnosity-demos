<?php

/**
 * Check to see whether a URL exists (returns a 200 OK)
 */
function urlExists($path)
{
    $headers = @get_headers($path);
    $exists = false;

    if (strpos($headers[0], '404') === false) {
        $exists = true;
    }

    return $exists;
}
