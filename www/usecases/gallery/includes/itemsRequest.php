<?php

use LearnositySdk\Request\Init;
use LearnositySdk\Request\DataApi;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

/*
 * The only reason we're using the Data API here is to
 * retrieve the item references necessary to create a
 * DOM node (to load an item into).
 * This call would ideally be cached by the host page.
 */
$dataApi = new DataApi();
$response = $dataApi->request(
    $url_data . '/itembank/activities',
    $security,
    $consumer_secret,
    ['references' => [$activityRef]]
);

if (!$response->getError()['code']) {
    $activity = json_decode($response->getBody(), true)['data'];
    $items = $activity[0]['data']['items'];
}

// Setup your request object as usual
$request = array(
    'user_id'              => 'demo_student',
    'name'                 => 'Items API demo - Inline Activity.',
    'activity_id'          => 'itemsinlinedemo',
    'session_id'           => Uuid::generate(),
    'type'                 => 'submit_practice',
    'rendering_type'       => 'inline',
    'activity_template_id' => $activityRef,
    'config'               => [
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
    ]
);

$init = new Init('items', $security, $consumer_secret, $request);
$itemsRequest = $init->generate();
