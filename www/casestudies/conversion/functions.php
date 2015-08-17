<?php

function readFilesIn($folderName, $extensionFilter)
{
    $files = scandir($folderName);
    $fileList = [];
    foreach ($files as $f) {
        if (strpos($f, '.' . $extensionFilter) !== false) {
            $fileList[$f] = $folderName . DIRECTORY_SEPARATOR . $f;
        }
    }
    return $fileList;
}

function convertToQti($postdata)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/sdk/src/LearnositySdk/autoload.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/app_paths.php';

    $consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';
    $dataApi = new \LearnositySdk\Request\DataApi();
    $security = [
        'consumer_key' => 'yis0TYCu7U9V4o7M',
        'domain' => 'docs.learnosity.com'
    ];
    $request = [
        'mode' => 'to_qti',
        'items' => [json_decode($postdata, true)]
    ];

    $response = $dataApi->request($dataApiPath . 'itembank/conversion', $security, $consumer_secret, $request, 'get');
    return $response->getBody();
}

function convertToJson($postdata, $baseAssetsUrl = '')
{
    // Validate emptiness
    if (empty($postdata)) {
        print_r('There is no XML to parse');
        return;
    }

    require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/sdk/src/LearnositySdk/autoload.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/app_paths.php';

    // Data API request for conversion
    $consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';
    $dataApi = new \LearnositySdk\Request\DataApi();
    $security = [
        'consumer_key' => 'yis0TYCu7U9V4o7M',
        'domain' => 'docs.learnosity.com'
    ];
    $request = [
        'mode' => 'from_qti',
        'items' => [$postdata]
    ];
    if (!empty($baseAssetsUrl)) {
        $request['base_asset_path'] = $baseAssetsUrl;
    }
    $rawResponse = $dataApi->request($dataApiPath . 'itembank/conversion', $security, $consumer_secret, $request, 'get')->getBody();
    $response = json_decode($rawResponse, true)['data'][0];

    $consumer_key = 'yis0TYCu7U9V4o7M';
    $consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';
    $domain = $_SERVER['SERVER_NAME'];
    $timestamp = gmdate('Ymd-Hi');
    $studentid = 'demo_student';

    $item = $response['item'];
    $questions = $response['questions'];
    $exceptions = $response['manifest'];

    $originalQuestions = $questions;
    $questionsList = [];
    foreach ($questions as $index => $q) {
        $questions[$index]['data']['response_id'] = $item['questionReferences'][$index];
        $questionsList[] = $questions[$index]['data'];
    }

    $activity = [
        'consumer_key' => $consumer_key,
        'timestamp' => $timestamp,
        'signature' => hash("sha256", $consumer_key . '_' . $domain . '_' . $timestamp . '_' . $studentid . '_' . $consumer_secret),
        'user_id' => 'demo_student',
        'type' => 'local_practice',
        'state' => 'initial',
        'id' => 'demo-chart-activity',
        'name' => 'Demo Bart Chart',
        'course_id' => 'demo_' . $consumer_key,
        'questions' => $questionsList,
        'showCorrectAnswers' => true
    ];

    $result = [
        'layout'     => isset($item['content']) ? $item['content'] : '',
        'activity'   => $activity,
        'item'       => $item,
        'questions'  => $originalQuestions,
        'exceptions' => $exceptions
    ];
    return json_encode($result);
}
