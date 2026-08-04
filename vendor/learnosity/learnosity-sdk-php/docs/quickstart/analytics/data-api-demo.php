<?php

/**
 * Copyright (c) 2025 Learnosity, MIT License
 *
 * Data API Demo - Metadata Headers
 * This example demonstrates the metadata headers that are automatically
 * included in every Data API request by the SDK.
 */

// - - - - - - Section 1: server-side configuration - - - - - - //

// Setup to load the necessary classes from the example directory
require_once __DIR__ . '/../../../bootstrap.php';
$config = require_once __DIR__ . '/../config.php'; // Load security keys from config.php

use LearnositySdk\Request\DataApi;
use LearnositySdk\Request\Init;

// Data API endpoint configuration
$endpoint = 'https://data.learnosity.com/latest/itembank/items';
$action = 'get';

// Public & private security keys required to access Learnosity APIs and data
$consumerKey = $config['consumerKey'];
$consumerSecret = $config['consumerSecret'];

// Security packet
$securityPacket = [
    'consumer_key' => $consumerKey,
    'domain'       => 'localhost'
];

// Request packet
$requestPacket = [
    'limit' => 3
];

// Make the Data API request
$dataApi = new DataApi();
$response = $dataApi->request(
    $endpoint,
    $securityPacket,
    $consumerSecret,
    $requestPacket,
    $action
);

// Get response data
$statusCode = $response->getStatusCode();
$responseBody = $response->getBody();

// Extract metadata from the request packet to show what headers were sent
// The SDK automatically adds metadata to the request packet
$init = new Init('data', $securityPacket, $consumerSecret, $requestPacket, $action, null, null, $endpoint);
$generatedRequest = $init->generate();
$decodedRequest = json_decode($generatedRequest['request'], true);
$metadata = $decodedRequest['meta'] ?? [];

// Extract the metadata values that are sent as headers
$consumerHeader = $metadata['consumer'] ?? 'N/A';
$actionHeader = $metadata['action'] ?? 'N/A';
$sdkVersion = $metadata['sdk']['version'] ?? 'unknown';
$sdkLang = $metadata['sdk']['lang'] ?? 'unknown';
$sdkHeader = isset($metadata['sdk']['lang']) && isset($metadata['sdk']['version'])
    ? strtoupper($metadata['sdk']['lang']) . ':' . ltrim($metadata['sdk']['version'], 'v')
    : 'N/A';

// Format response body for display
$formattedResponse = json_encode(json_decode($responseBody), JSON_PRETTY_PRINT);

?>

<!-- Section 2: Web page content -->
<!DOCTYPE html>
<html>
<head>
    <title>Data API Demo - Metadata Headers</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            border-radius: 8px 8px 0 0;
            font-weight: bold;
        }
        .card-header.bg-primary {
            background-color: #007bff;
            color: white;
        }
        .card-header.bg-success {
            background-color: #28a745;
            color: white;
        }
        .card-header.bg-info {
            background-color: #17a2b8;
            color: white;
        }
        .card-body {
            padding: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
        }
        .badge.bg-success {
            background-color: #28a745;
            color: white;
        }
        .badge.bg-danger {
            background-color: #dc3545;
            color: white;
        }
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .alert-info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }
        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }
        pre {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            max-height: 400px;
            overflow-y: auto;
        }
        code {
            background-color: #f8f9fa;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        pre code {
            background-color: transparent;
            padding: 0;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        h3 {
            margin: 0;
        }
        h4 {
            margin-top: 0;
        }
        ul {
            line-height: 1.8;
        }
        .text-muted {
            color: #6c757d;
        }
        strong {
            color: #007bff;
        }
    </style>
</head>
<body>
    <h1>Data API Demo - Metadata Headers</h1>
    <p>This page demonstrates the metadata headers that are automatically included in every Data API request.</p>

    <!-- Request Information Card -->
    <div class="card">
        <div class="card-header bg-primary">
            <h3>Request Information</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <th style="width: 30%;">Endpoint</th>
                        <td><code><?php echo htmlspecialchars($endpoint); ?></code></td>
                    </tr>
                    <tr>
                        <th>Action</th>
                        <td><code><?php echo htmlspecialchars($action); ?></code></td>
                    </tr>
                    <tr>
                        <th>Status Code</th>
                        <td>
                            <span class="badge <?php echo $statusCode == 200 ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo htmlspecialchars($statusCode); ?>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Metadata Headers Card -->
    <div class="card">
        <div class="card-header bg-success">
            <h3>Metadata Headers (Sent Automatically)</h3>
        </div>
        <div class="card-body">
            <p class="text-muted">These headers are added automatically by the SDK and are invisible to customers:</p>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Header Name</th>
                        <th>Header Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>X-Learnosity-Consumer</code></td>
                        <td><strong><?php echo htmlspecialchars($consumerHeader); ?></strong></td>
                    </tr>
                    <tr>
                        <td><code>X-Learnosity-Action</code></td>
                        <td><strong><?php echo htmlspecialchars($actionHeader); ?></strong></td>
                    </tr>
                    <tr>
                        <td><code>X-Learnosity-SDK</code></td>
                        <td><strong><?php echo htmlspecialchars($sdkHeader); ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <div class="alert alert-info">
                <strong>Metadata Format:</strong>
                <ul style="margin-bottom: 0;">
                    <li><strong>Consumer:</strong> The consumer key from the security packet</li>
                    <li><strong>Action:</strong> Format is <code>{method}_{endpoint}</code> (e.g., <code><?php echo htmlspecialchars($actionHeader); ?></code>)</li>
                    <li><strong>SDK:</strong> Format is <code>{language}:{version}</code> (e.g., <code><?php echo htmlspecialchars($sdkHeader); ?></code>)</li>
                </ul>
            </div>
            <div class="alert alert-info">
                <strong>SDK Metadata (in request packet):</strong>
                <ul style="margin-bottom: 0;">
                    <li><strong>Version:</strong> <code><?php echo htmlspecialchars($sdkVersion); ?></code></li>
                    <li><strong>Language:</strong> <code><?php echo htmlspecialchars($sdkLang); ?></code></li>
                    <li><strong>Language Version:</strong> <code><?php echo htmlspecialchars($metadata['sdk']['lang_version'] ?? 'N/A'); ?></code></li>
                    <li><strong>Platform:</strong> <code><?php echo htmlspecialchars($metadata['sdk']['platform'] ?? 'N/A'); ?></code></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Response Body Card -->
    <div class="card">
        <div class="card-header bg-info">
            <h3>Response Body</h3>
        </div>
        <div class="card-body">
            <pre><code><?php echo htmlspecialchars($formattedResponse); ?></code></pre>
        </div>
    </div>

    <!-- How It Works Card -->
    <div class="alert alert-warning">
        <h4>How It Works</h4>
        <ul>
            <li>The SDK automatically extracts the consumer key from the security packet</li>
            <li>The SDK builds the action metadata by combining the HTTP method with the endpoint path</li>
            <li>The SDK includes version information from the SDK version file</li>
            <li>These values are added as HTTP headers (<code>X-Learnosity-Consumer</code> and <code>X-Learnosity-Action</code>)</li>
            <li>The headers are available at the ALB layer for routing decisions</li>
            <li>No changes are required to customer code - it's completely transparent!</li>
        </ul>
    </div>
</body>
</html>

