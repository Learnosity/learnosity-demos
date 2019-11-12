<?php

$mapping = [
    /* Note: order in this array matters, as the first rule that matches will be unconditionally applied */
    '/analytics/reports/live_progress.php' => '/analytics/live-progress-reporting.php',
    '/analytics/reports/liveprogress' => '/analytics/liveprogress',
    '/assessment/items/itemsapi_itemadaptive.php' => '/assessment/adaptive.php',
];

// add redirect routes for old urls
foreach ($mapping as $oldURL => $newURL) {
    if (strpos($_SERVER['REQUEST_URI'], $oldURL) !== false) {
        $fullNewURL = str_replace($oldURL, $newURL, $_SERVER['REQUEST_URI']);
        http_response_code(302);
        header('Location: ' . $fullNewURL);
        /* In case we cannot use Location, e.g., we've been called from a 404 handler
         * which doesn't allow us to override the status) */
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
