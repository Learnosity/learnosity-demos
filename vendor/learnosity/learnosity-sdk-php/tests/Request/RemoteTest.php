<?php

namespace LearnositySdk\Request;

use LearnositySdk\AbstractTestCase;
use LearnositySdk\Fixtures\ParamsFixture;

class RemoteTest extends AbstractTestCase
{
    public function testPost()
    {
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingDataApiParams();
        unset($security['timestamp']);
        $init = new Init($service, $security, $secret, $request, $action);

        $url = $this->buildBaseDataUrl() . '/sessions/statuses';

        $remote = new Remote();
        $ret = $remote->post($url, $init->generate());

        $this->assertInstanceOf(Remote::class, $ret);

        $this->assertEquals(200, $remote->getStatusCode());
        $this->assertEquals('application/json; charset=utf-8', $remote->getHeader());
        $this->assertGreaterThan(0, $remote->getSize(false));
        $this->assertNotEquals('0 bytes', $remote->getSize());

        $arr = $remote->json();

        $this->assertNotEmpty($arr['meta']['status']);
        $this->assertNotEmpty($arr['meta']['timestamp']);
        $this->assertTrue($arr['meta']['status']);
        $this->assertArrayHasKey('records', $arr['meta']);
        $this->assertCount($arr['meta']['records'], $arr['data']);
    }

    /**
     * Test that metadata headers are added to Data API requests
     */
    public function testMetadataHeadersAddedToDataApiRequests()
    {
        // Test the addMetadataHeaders method directly using reflection
        $remote = new Remote();
        $reflection = new \ReflectionClass($remote);
        $method = $reflection->getMethod('addMetadataHeaders');
        $method->setAccessible(true);

        // Create Data API request data with metadata
        $requestData = [
            'security' => '{"consumer_key":"test_consumer","domain":"localhost"}',
            'request' => '{"meta":{"sdk":{"version":"v1.1.0","lang":"php"},"consumer":"test_consumer","action":"get_/itembank/items"},"limit":100}',
            'action' => 'get'
        ];

        $headers = [];
        $result = $method->invoke($remote, $headers, $requestData);

        // Verify that metadata headers were added
        $consumerHeaderFound = false;
        $actionHeaderFound = false;
        $sdkHeaderFound = false;

        foreach ($result as $header) {
            if (strpos($header, 'X-Learnosity-Consumer: test_consumer') === 0) {
                $consumerHeaderFound = true;
            }
            if (strpos($header, 'X-Learnosity-Action: get_/itembank/items') === 0) {
                $actionHeaderFound = true;
            }
            if (strpos($header, 'X-Learnosity-SDK: PHP:1.1.0') === 0) {
                $sdkHeaderFound = true;
            }
        }

        $this->assertTrue($consumerHeaderFound, 'Consumer header should be added');
        $this->assertTrue($actionHeaderFound, 'Action header should be added');
        $this->assertTrue($sdkHeaderFound, 'SDK header should be added');
    }

    /**
     * Test that metadata headers are not added to non-Data API requests
     */
    public function testMetadataHeadersNotAddedToNonDataApiRequests()
    {
        // Test the addMetadataHeaders method directly using reflection
        $remote = new Remote();
        $reflection = new \ReflectionClass($remote);
        $method = $reflection->getMethod('addMetadataHeaders');
        $method->setAccessible(true);

        // Create non-Data API request data (missing 'request' and 'security' keys)
        $requestData = ['some' => 'data'];

        $headers = [];
        $result = $method->invoke($remote, $headers, $requestData);

        // Verify that no metadata headers were added
        $hasMetadataHeaders = false;
        foreach ($result as $header) {
            if (strpos($header, 'X-Learnosity-Consumer:') !== false
                || strpos($header, 'X-Learnosity-Action:') !== false
                || strpos($header, 'X-Learnosity-SDK:') !== false) {
                $hasMetadataHeaders = true;
                break;
            }
        }
        $this->assertFalse($hasMetadataHeaders, 'No metadata headers should be added to non-Data API requests');
    }

    public function testGet()
    {
        $remote = new Remote();
        $ret = $remote->get($this->buildBaseSchemasUrl() . '/questions/templates');
        $arr = $remote->json();

        $this->assertInstanceOf(Remote::class, $ret);

        $this->assertEquals(200, $remote->getStatusCode());
        $this->assertEquals('application/json; charset=utf-8', $remote->getHeader());
        $this->assertGreaterThan(0, $remote->getSize(false));
        $this->assertNotEquals('0 bytes', $remote->getSize());

        $this->assertNotEmpty($arr['meta']['status']);
        $this->assertNotEmpty($arr['meta']['timestamp']);
        $this->assertTrue($arr['meta']['status']);
        $this->assertArrayHasKey('data', $arr);
    }

    private function buildBaseDataUrl(): string
    {
        $versionPath = 'v1';
        if (isset($_SERVER['ENV']) && $_SERVER['ENV'] != 'prod') {
            $versionPath = 'latest';
        } elseif (isset($_SERVER['VER'])) {
            $versionPath = $_SERVER['VER'];
        }

        return 'https://data' . $this->buildBaseDomain() . '/' . $versionPath;
    }

    private function buildBaseSchemasUrl(): string
    {
        return 'https://schemas' . $this->buildBaseDomain() . '/latest';
    }

    private function buildBaseDomain(): string
    {
        $envDomain = '';
        $regionDomain = '.learnosity.com';
        if (isset($_SERVER['ENV']) && $_SERVER['ENV'] != 'prod') {
            $envDomain = '.' . $_SERVER['ENV'];
        } elseif (isset($_SERVER['REGION'])) {
            $regionDomain = $_SERVER['REGION'];
        }
        return $envDomain . $regionDomain;
    }
}
