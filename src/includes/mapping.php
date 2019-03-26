<?php

$mapping = [
    /* Note: order in this array matters, as the first rule that matches will be unconditionally applied */
    '/analytics/reports/live_progress.php' =>'/analytics/live-progress-reporting.php',
    '/analytics/reports/liveprogress' =>'/analytics/liveprogress',
];

// add redirect routes for old urls
foreach ($mapping as $oldURL => $newURL) {
    if (strpos($_SERVER['REQUEST_URI'], $oldURL) !== false) {
        $fullNewURL = str_replace($oldURL, $newURL, $_SERVER['REQUEST_URI']);
        /* XXX: We cannot use Location as we could have been called from a 404 handler,
         * and I didn't find a way to rewrite the status code to a 30x*/
        print(
            "<!doctype html>" . PHP_EOL
            . "<html>" . PHP_EOL
            . "  <head>" . PHP_EOL
            . "    <meta http-equiv=\"refresh\" content=\"0; url={$fullNewURL}\">" . PHP_EOL
            . "  </head>" . PHP_EOL
            . "  <body>" . PHP_EOL
            . "    This page has moved <a href=\"{$fullNewURL}\">here</a>." . PHP_EOL
            . "  </body>" . PHP_EOL
            . "</html>"
        );
        exit();
    }
}
