<?php

namespace tests\LearnositySdk\Utils;

use LearnositySdk\AbstractTestCase;
use LearnositySdk\Utils\Uuid;

class UuidTest extends AbstractTestCase
{
    public function dataProviderGenerate(): array
    {
        return [
            ['/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i'],
            ['/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', null, 'v4'],
            ['/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', null, 'uuidv4'],
            [null, false, 'v3', 'namespace'],
            [null, false, 'v3', 'namespace', 'name'],
            ['/^[0-9A-F]{8}-[0-9A-F]{4}-3[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', null, 'v3', 'f47ac10b-58cc-4372-a567-0e02b2c3d479'],
            ['/^[0-9A-F]{8}-[0-9A-F]{4}-3[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', null, 'v3', 'f47ac10b-58cc-4372-a567-0e02b2c3d479', 'name'],
            [null, false, 'v5', 'namespace'],
            [null, false, 'v5', 'namespace', 'name'],
            ['/^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/i', null, 'v5', 'f47ac10b-58cc-4372-a567-0e02b2c3d479'],
            ['/^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/i', null, 'v5', 'f47ac10b-58cc-4372-a567-0e02b2c3d479', 'name'],
        ];
    }

    /**
     * @dataProvider dataProviderGenerate
     */
    public function testGenerate($expectedFormat, $expectedResult = null, $type = 'v4', $namespace = null, $name = null)
    {
        $result = Uuid::generate($type, $namespace, $name);
        if (!is_null($expectedResult)) {
            $this->assertEquals($expectedResult, $result);
        } else {
            $this->assertTrue(preg_match($expectedFormat, $result) === 1);
        }
    }

    public function dataProviderIsValid(): array
    {
        return [
            ['random string', false],
            ['f47ac10b-58cc-4372-a567-0e02b23d479', false],
            ['f47ac10b58cc-4372-a567-0e02b2c3d479', true], // no hyphens is ok, RFC doesn't say that they're required
            ['f47ac10b58cc4372a5670e02b2c3d479', true], // no hyphens is ok, RFC doesn't say that they're required
            ['f47ac10b-58cc-4372-a567-0e02b2c3d479', true],
            ['c299bec4-27f8-3f63-b5d3-18bec6b11f6f', true],
            ['da9dea4e-1a1e-4862-9174-21c5237480d1', true],
            ['c319b58e-9b20-4b42-9af6-c4cd901cd2fb', true],
            ['3e8adf14-a408-5e29-80cf-57728fc5d294', true]
        ];
    }

    /**
     * @dataProvider dataProviderIsValid
     */
    public function testIsValid(string $uuid, bool $expectedResult)
    {
        $result = Uuid::isValid($uuid);
        $this->assertEquals($expectedResult, $result);
    }
}
