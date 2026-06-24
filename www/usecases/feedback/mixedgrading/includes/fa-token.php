<?php
/**
 * Feedback Aide token endpoint.
 * Generates an OAuth2 token for Feedback Aide API sessions.
 *
 * Accepts a JSON POST body with:
 *   - session_uuid : The FA session UUID
 *   - permission   : 'RW' or 'R' (default: 'RW')
 *   - state        : 'grade' or 'review' (default: 'grade')
 */

header('Content-Type: application/json');

include_once '../../../../env_config.php';
include_once '../../../../lrn_config.php';

// Determine environment for the FA token URL
function getFeedbackAideTokenUrl() {
    $host = explode('.', $_SERVER['HTTP_HOST']);
    $env = '';
    if (in_array('dev', $host)) {
        $env = '.dev';
    } else if (in_array('staging', $host)) {
        $env = '.staging';
    } else if (in_array('ldc', $host)) {
        $env = '.ldc';
    }
    return "https://feedbackaide{$env}.learnosity.com/api/token";
}

// Load FA credentials from config
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/utils/File/Config.php';
use Utils\File\Config;

function getAppConfig() {
    $configPath = $_SERVER['DOCUMENT_ROOT'] . '/../config/';
    $config = new Config();

    try {
        $config->loadIni($configPath . 'config.ini');
        if (file_exists($configPath . 'system-config.ini')) {
            $config->loadIni($configPath . 'system-config.ini');
        } else {
            $service = $config->get('app', 'serviceName') ?: '';
            $config->loadIniFromEnvironment($configPath, $service);
        }
    } catch (Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        die(json_encode(['error' => $e->getMessage()]));
    }

    return $config;
}

// Read request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$sessionUUID = $data['session_uuid'] ?? null;
$permission  = $data['permission'] ?? 'RW';
$state       = $data['state'] ?? 'grade';

if (!$sessionUUID) {
    http_response_code(400);
    echo json_encode(['error' => 'session_uuid is required']);
    exit;
}

$scope = "api:feedbackaide feedback_session_uuid:{$sessionUUID}:{$permission} state:{$state}";

$postData = [
    'grant_type' => 'client_credentials',
    'scope'      => $scope,
];

$config = getAppConfig();
$oauthKey    = $config->get('feedback_aide', 'oauth_key');
$oauthSecret = $config->get('feedback_aide', 'oauth_secret');

if (!$oauthKey || !$oauthSecret) {
    http_response_code(500);
    echo json_encode(['error' => 'Feedback Aide credentials not configured']);
    exit;
}

// Request token from FA API
$url = getFeedbackAideTokenUrl();
$ch  = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_USERPWD, $oauthKey . ':' . $oauthSecret);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(['error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);
echo $response;
