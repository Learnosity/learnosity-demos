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
