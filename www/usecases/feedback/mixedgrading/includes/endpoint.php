<?php

/*
|--------------------------------------------------------------------------
| endpoint.php
|--------------------------------------------------------------------------
|
| Server-side proxy for the Data API grading endpoint.
| Accepts a form POST with:
|   - action  : 'get' or 'update'
|   - request : JSON-encoded request body
|
| For 'get': calls /sessions/responses/scores/grading + /sessions/responses/scores
|            and merges results (manual grading scores + auto-scores).
| For 'update': calls /sessions/responses/scores/grading to persist scores.
|
*/

header("Content-type: application/json");

include_once '../../../../env_config.php';
include_once '../../../../lrn_config.php';

use LearnositySdk\Request\DataApi;

$consumer_key    = $consumer_key_postgres;
$consumer_secret = $consumer_secret_postgres;

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => 'get']]);

$request_data = json_decode(
    html_entity_decode(
        filter_input(INPUT_POST, 'request', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => '{}']])
    ),
    true
) ?? [];

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
];

$dataapi = new DataApi(['ssl_verify' => $curl_ssl_verify]);

if ($action === 'get') {
    // 1. Call the grading endpoint for manual scores
    $endpoint_grading = $url_data . '/sessions/responses/scores/grading';
    $grading_response = $dataapi->request($endpoint_grading, $security, $consumer_secret, $request_data, $action);
    $grading_data = null;

    if (strlen($grading_response->getBody())) {
        $grading_body = json_decode($grading_response->getBody(), true);
        if (isset($grading_body['meta']['status']) && $grading_body['meta']['status'] === true) {
            $grading_data = $grading_body['data'] ?? [];
        }
    }

    // 2. Also call /sessions/responses/scores for auto-scored data (score + max_score)
    $scores_request = $request_data;
    if (isset($scores_request['session_id']) && is_string($scores_request['session_id'])) {
        $scores_request['session_id'] = [$scores_request['session_id']];
    }
    $endpoint_scores = $url_data . '/sessions/responses/scores';
    $scores_response = $dataapi->request($endpoint_scores, $security, $consumer_secret, $scores_request, $action);
    $auto_scores = []; // Map response_id -> {score, max_score}

    if (strlen($scores_response->getBody())) {
        $scores_body = json_decode($scores_response->getBody(), true);
        if (isset($scores_body['meta']['status']) && $scores_body['meta']['status'] === true && !empty($scores_body['data'])) {
            $session = $scores_body['data'][0];
            if (isset($session['responses'])) {
                foreach ($session['responses'] as $resp) {
                    $auto_scores[$resp['response_id']] = [
                        'score' => $resp['score'] ?? null,
                        'max_score' => $resp['max_score'] ?? null,
                        'item_reference' => $resp['item_reference'] ?? null,
                    ];
                }
            }
        }
    }

    // 3. Merge: use grading data as base, enrich with auto-scores
    if ($grading_data !== null) {
        // Grading endpoint returned data — merge auto-scores into it
        foreach ($grading_data as &$session) {
            if (!isset($session['items'])) continue;
            foreach ($session['items'] as &$item) {
                if (!isset($item['responses'])) continue;
                foreach ($item['responses'] as &$resp) {
                    $rid = $resp['response_id'] ?? '';
                    // If this response has no graders but has auto-score data, add it
                    if (empty($resp['graders']) && isset($auto_scores[$rid])) {
                        $resp['auto_score'] = $auto_scores[$rid]['score'];
                        $resp['auto_max_score'] = $auto_scores[$rid]['max_score'];
                    }
                    // Always enrich with max_score from auto-scores if not present in graders
                    if (isset($auto_scores[$rid]['max_score'])) {
                        $resp['max_score'] = $auto_scores[$rid]['max_score'];
                    }
                    if (isset($auto_scores[$rid]['score']) && empty($resp['graders'])) {
                        $resp['score'] = $auto_scores[$rid]['score'];
                    }
                }
            }
        }
        unset($session, $item, $resp);

        echo json_encode(['meta' => ['status' => true], 'data' => $grading_data]);
    } else {
        // Grading endpoint failed — build response from auto-scores only
        $items_result = [];
        foreach ($auto_scores as $rid => $score_data) {
            $item_ref = $score_data['item_reference'] ?? $rid;
            $items_result[] = [
                'item_reference' => $item_ref,
                'responses' => [[
                    'response_id' => $rid,
                    'graders' => [],
                    'score' => $score_data['score'],
                    'max_score' => $score_data['max_score'],
                ]]
            ];
        }
        $session_id = $request_data['session_id'] ?? '';
        echo json_encode([
            'meta' => ['status' => true],
            'data' => [['session_id' => $session_id, 'items' => $items_result]]
        ]);
    }
} else {
    // For 'update' action - use the grading endpoint
    $endpoint = $url_data . '/sessions/responses/scores/grading';
    $response = $dataapi->request($endpoint, $security, $consumer_secret, $request_data, $action);

    if (strlen($response->getBody())) {
        echo $response->getBody();
    } else {
        $err = $response->getError();
        http_response_code(500);
        echo json_encode(['error' => $err]);
    }
}
