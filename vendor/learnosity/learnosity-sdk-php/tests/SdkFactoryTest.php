<?php

namespace LearnositySdk;

use LearnositySdk\Exceptions\ValidationException;
use LearnositySdk\Request\Init;

class SdkFactoryTest extends AbstractTestCase
{
    private $sdkFactory;

    public function setUp(): void
    {
        $this->sdkFactory = new SdkFactory();
    }

    /**
     * @param array $testData
     * @return void
     * @dataProvider buildInitDataProvider
     */
    public function testBuildInit(array $testData)
    {
        if (!empty($testData['error_message'])) {
            $this->expectException(ValidationException::class);
            $this->expectExceptionMessage($testData['error_message']);
        }
        $sdkInit = $this->sdkFactory->buildInit($testData['arguments']);
        if (empty($testData['error_message'])) {
            self::assertInstanceOf(Init::class, $sdkInit);
        }
    }

    public function buildInitDataProvider(): array
    {
        return [
            'no service set' => [
                [
                    'error_message' => 'Argument service must be set',
                    'arguments' => []
                ]
            ],
            'no securityPacket set' => [
                [
                    'error_message' => 'Argument securityPacket must be set',
                    'arguments' => [
                        'service' => 'authoraide'
                    ]
                ]
            ],
            'no secret set' => [
                [
                    'error_message' => 'Argument secret must be set',
                    'arguments' => [
                        'service' => 'authoraide',
                        'securityPacket' => [
                            'consumer_key' => 'test',
                            'domain' => 'test'
                        ]
                    ]
                ]
            ],
            'all required parameters set' => [
                [
                    'arguments' => [
                        'service' => 'authoraide',
                        'securityPacket' => [
                            'consumer_key' => 'test',
                            'domain' => 'test'
                        ],
                        'secret' => 'test'
                    ]
                ]
            ],
        ];
    }
}
