<?php

namespace tests\LearnositySdk\Utils;

use LearnositySdk\AbstractTestCase;
use LearnositySdk\Utils\Json;

class JsonTest extends AbstractTestCase
{
    public function testCheckError()
    {
        $result = Json::checkError();
        $this->assertTrue(is_null($result) || is_string($result));
    }

    public function dataProviderEncode(): array
    {
        return [
            [null, null],
            [0.00000012, '0.00000012'],
            [
                [
                    'value0' => 0.0000000032,
                    'test' => [
                        'value' => 0.0000000032,
                        'test2' => [
                            'value1' => 0.0000000032,
                            'value2' => 23.32,
                            'value3' => 1.000000021,
                            'value4' => -0.00000032,
                            'value5' => 1.2E-6
                        ]
                    ]
                ],
                '{"value0":0.0000000032,"test":{"value":0.0000000032,"test2":{"value1":0.0000000032,"value2":23.32,"value3":1.000000021,"value4":-0.00000032,"value5":0.0000012}}}'
            ],
            [1, '1'],
            [true, 'true'],
            ['a', '"a"'],
            [
                [
                    ['a' => 'a'],
                    ['b' => 1],
                    ['c' => true]
                ],
                '[{"a":"a"},{"b":1},{"c":true}]'
            ]
        ];
    }

    /**
     * @dataProvider dataProviderEncode
     */
    public function testEncode($val, $expectedResult)
    {
        $result = Json::encode($val);
        $this->assertEquals($expectedResult, $result);
    }

    public function testEncodeWithPrettyPrint()
    {
        $val = [
            'test' => 'hello-world',
        ];

        $expectedResult =
        <<<JSON
{
    "test": "hello-world"
}
JSON;

        $result = Json::encode($val, [
            JSON_PRETTY_PRINT,
        ]);
        $this->assertEquals($expectedResult, $result);
    }

    public function dataProviderIsJson(): array
    {
        return [
            ['12', true],
            ['false', true],
            ['"string"', true],
            ['[a]', false],
            ['["a"]', true],
            ['{a:a}', false],
            ['{"a":"a"}', true],
            ['a', false],
            ['{"a":"a"]', false],
            ['["a"}', false],
            ['[{"a":"a"}, {"b":1}, {"c":true}]', true],
            ['{"meta":{"status":true,"timestamp":1404091707,"request_version":"","schema_version":"develop","records":1}}', true]
        ];
    }

    /**
     * @dataProvider dataProviderIsJson
     */
    public function testIsJson(string $val, bool $expectedResult)
    {
        $result = Json::isJson($val);
        $this->assertEquals($expectedResult, $result);
    }
}
