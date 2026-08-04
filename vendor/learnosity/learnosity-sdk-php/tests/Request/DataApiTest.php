<?php

namespace LearnositySdk\Request;

use LearnositySdk\AbstractTestCase;
use LearnositySdk\Fixtures\ParamsFixture;

class DataApiTest extends AbstractTestCase
{
    const ITEMBANK_ITEMS_URI = 'https://data.learnosity.com/v1/itembank/items';
    const ITEMBANK_QUESTIONS_URI = 'https://data.learnosity.com/v1/itembank/questions';

    public function testRequest()
    {
        $securityPacket = [
            'consumer_key' => ParamsFixture::TEST_CONSUMER_KEY,
            'domain' => ParamsFixture::TEST_DOMAIN,
        ];

        $dataRequest = [
            'limit' => 1,
        ];

        $dataApi = new DataApi();

        $requestsMade = 0;

        for ($requestNumber = 0; $requestNumber < 5; $requestNumber++) {
            $result = $dataApi->request(
                self::ITEMBANK_ITEMS_URI,
                $securityPacket,
                ParamsFixture::TEST_CONSUMER_SECRET,
                $dataRequest,
                'get'
            );

            $this->assertInstanceOf(Remote::class, $result);

            $this->assertEquals(200, $result->getStatusCode());
            $this->assertEquals('application/json; charset=utf-8', $result->getHeader());
            $this->assertGreaterThan(0, $result->getSize(false));
            $this->assertNotEquals('0 bytes', $result->getSize());

            $response = $result->json();

            $this->assertNotEmpty($response['meta']['status']);
            $this->assertNotEmpty($response['meta']['timestamp']);
            $this->assertTrue($response['meta']['status']);
            $this->assertArrayHasKey('records', $response['meta']);
            $this->assertCount($response['meta']['records'], $response['data']);

            if (
                isset($response['meta']['next'])
                && isset($response['meta']['records'])
                && $response['meta']['records'] > 0
            ) {
                $dataRequest['next'] = $response['meta']['next'];
            }

            $requestsMade++;
        }

        $this->assertEquals(5, $requestsMade);
    }

    public function testRequestRecursive()
    {
        $securityPacket = [
            'consumer_key' => ParamsFixture::TEST_CONSUMER_KEY,
            'domain' => ParamsFixture::TEST_DOMAIN,
        ];

        $dataRequest = [
            'limit' => 1,
        ];

        $dataApi = new DataApi();

        $result = $dataApi->requestRecursive(
            self::ITEMBANK_ITEMS_URI,
            $securityPacket,
            ParamsFixture::TEST_CONSUMER_SECRET,
            $dataRequest,
            'get',
            null,
            5
        );

        $this->wrapIsArray($result);

        $this->assertCount(5, $result);
    }

    public function testRequestRecursiveCallback()
    {
        $securityPacket = [
            'consumer_key' => ParamsFixture::TEST_CONSUMER_KEY,
            'domain' => ParamsFixture::TEST_DOMAIN,
        ];

        $dataRequest = [
            'limit' => 1,
        ];

        $dataApi = new DataApi();

        $requestCount = 0;

        $results = [];

        $dataApi->requestRecursive(
            self::ITEMBANK_ITEMS_URI,
            $securityPacket,
            ParamsFixture::TEST_CONSUMER_SECRET,
            $dataRequest,
            'get',
            function (array $data) use (&$requestCount, &$results) {
                $requestCount++;

                $results = array_merge($results, $data['data']);
            },
            5
        );

        $this->wrapIsArray($results);

        $this->assertEquals(5, $requestCount);
    }

    /**
     * Test that DataApi passes endpoint information to Init for metadata generation
     */
    public function testDataApiPassesEndpointForMetadata()
    {
        // Create a mock Remote to capture the request data
        $mockRemote = new class implements RemoteInterface {
            public $capturedUrl = '';
            public $capturedData = [];

            public function get(string $url, array $data = []): RemoteInterface
            {
                return $this;
            }

            public function post(string $url, array $data = []): RemoteInterface
            {
                $this->capturedUrl = $url;
                $this->capturedData = $data;
                return $this;
            }

            public function request(string $url, array $post = [])
            {
                // Suppress unused parameter warnings - required by interface
                unset($url, $post);
                // Not used in this test
            }

            public function getBody()
            {
                return '{"meta":{"status":true},"data":[]}';
            }

            public function getError(): array
            {
                return ['code' => 0, 'message' => ''];
            }

            public function getHeader(string $type = 'content_type')
            {
                // Suppress unused parameter warning - required by interface
                unset($type);
                return 'application/json';
            }

            public function getSize(bool $format = true)
            {
                // Suppress unused parameter warning - required by interface
                unset($format);
                return 100;
            }

            public function getStatusCode(): int
            {
                return 200;
            }

            public function getTimeTaken(): float
            {
                return 0.1;
            }

            public function json(bool $assoc = true)
            {
                return json_decode($this->getBody(), $assoc);
            }
        };

        $securityPacket = [
            'consumer_key' => 'test_consumer_key',
            'domain' => 'localhost'
        ];

        $requestPacket = ['limit' => 20];
        $endpoint = 'https://data.learnosity.com/v2023.1.lts/itembank/items';

        $dataApi = new DataApi([], $mockRemote);
        $dataApi->request($endpoint, $securityPacket, 'test_secret', $requestPacket, 'get');

        // Verify the request data contains metadata
        $this->assertEquals($endpoint, $mockRemote->capturedUrl);
        $this->assertArrayHasKey('request', $mockRemote->capturedData);

        $decodedRequest = json_decode($mockRemote->capturedData['request'], true);
        $this->assertArrayHasKey('meta', $decodedRequest);
        $this->assertArrayHasKey('consumer', $decodedRequest['meta']);
        $this->assertArrayHasKey('action', $decodedRequest['meta']);
        $this->assertEquals('test_consumer_key', $decodedRequest['meta']['consumer']);
        $this->assertEquals('get_/itembank/items', $decodedRequest['meta']['action']);
    }

    public function testRequestRecursiveArrayMerge()
    {
        $expectedResult = <<<JSON
{
   "2d480565-6044-420f-9f07-52ec6618086e": [
      {
         "type": "mcq",
         "widget_type": "response",
         "reference": "30f87ca6-5ccc-48d8-a427-23b56bfa6024",
         "data": {
            "options": [
               {
                  "label": "[Choice A]",
                  "value": "0"
               },
               {
                  "label": "[Choice B]",
                  "value": "1"
               },
               {
                  "label": "[Choice C]",
                  "value": "2"
               },
               {
                  "label": "[Choice D]",
                  "value": "3"
               }
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "type": "mcq",
            "ui_style": {
               "choice_label": "upper-alpha",
               "type": "block"
            },
            "validation": {
               "scoring_type": "exactMatch",
               "valid_response": {
                  "score": 1,
                  "value": []
               }
            }
         },
         "metadata": {
            "name": "Multiple choice – block layout",
            "template_reference": "33d53a22-1a59-4a03-9671-7f5104edd62e"
         }
      },
      {
         "type": "mcq",
         "widget_type": "response",
         "reference": "617a111b-d2c8-4b2d-8775-89b3190fc64e",
         "data": {
            "options": [
               {
                  "label": "True",
                  "value": "0"
               },
               {
                  "label": "False",
                  "value": "1"
               }
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "type": "mcq",
            "ui_style": {
               "type": "horizontal"
            },
            "validation": {
               "scoring_type": "exactMatch",
               "valid_response": {
                  "score": 1,
                  "value": []
               }
            }
         },
         "metadata": {
            "name": "True or false",
            "template_reference": "3egs0b24-5gs8-49fc-fds9-4a450sdg31ca"
         }
      },
      {
         "type": "mcq",
         "widget_type": "response",
         "reference": "f0e03d6e-82e2-4f94-acba-4c192fcd06a2",
         "data": {
            "multiple_responses": true,
            "options": [
               {
                  "label": "[Choice A]",
                  "value": "0"
               },
               {
                  "label": "[Choice B]",
                  "value": "1"
               },
               {
                  "label": "[Choice C]",
                  "value": "2"
               },
               {
                  "label": "[Choice D]",
                  "value": "3"
               }
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "type": "mcq",
            "validation": {
               "scoring_type": "exactMatch",
               "valid_response": {
                  "score": 1,
                  "value": []
               }
            },
            "ui_style": {
               "type": "horizontal"
            }
         },
         "metadata": {
            "name": "Multiple choice – multiple response",
            "template_reference": "908de244-5c71-4c09-b094-7fb49554f2f9"
         }
      },
      {
         "type": "mcq",
         "widget_type": "response",
         "reference": "b3c13586-b4fa-41af-8ebc-1eeec808c271",
         "data": {
            "options": [
               {
                  "label": "[Choice A]",
                  "value": "0"
               },
               {
                  "label": "[Choice B]",
                  "value": "1"
               },
               {
                  "label": "[Choice C]",
                  "value": "2"
               },
               {
                  "label": "[Choice D]",
                  "value": "3"
               }
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "type": "mcq",
            "validation": {
               "scoring_type": "exactMatch",
               "valid_response": {
                  "score": 1,
                  "value": []
               }
            },
            "ui_style": {
               "type": "horizontal"
            }
         },
         "metadata": {
            "name": "Multiple choice – standard",
            "template_reference": "9e8149bd-e4d8-4dd6-a751-1a113a4b9163"
         }
      }
   ],
   "ee31f2da-cf93-4673-a6b2-a07056de456f": [
      {
         "type": "choicematrix",
         "widget_type": "response",
         "reference": "6050227b-9757-40d3-915a-31bb56f0204e",
         "data": {
            "options": [
               "True",
               "False"
            ],
            "stems": [
               "[Stem 1]",
               "[Stem 2]",
               "[Stem 3]",
               "[Stem 4]"
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "type": "choicematrix",
            "ui_style": {
               "stem_numeration": "upper-alpha",
               "type": "table",
               "horizontal_lines": false
            },
            "validation": {
               "scoring_type": "exactMatch",
               "valid_response": {
                  "score": 1,
                  "value": [
                     null,
                     null,
                     null,
                     null
                  ]
               }
            }
         },
         "metadata": {
            "name": "Choice matrix – labels",
            "template_reference": "9de82e14-802c-4bea-a635-bf9ad0b622fb"
         }
      },
      {
         "type": "mcq",
         "widget_type": "response",
         "reference": "c079c7c8-4ae3-4d20-b279-9603edbb1922",
         "data": {
            "multiple_responses": true,
            "options": [
               {
                  "label": "[Choice A]",
                  "value": "0"
               },
               {
                  "label": "[Choice B]",
                  "value": "1"
               },
               {
                  "label": "[Choice C]",
                  "value": "2"
               },
               {
                  "label": "[Choice D]",
                  "value": "3"
               }
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "type": "mcq",
            "validation": {
               "scoring_type": "exactMatch",
               "valid_response": {
                  "score": 1,
                  "value": []
               }
            },
            "ui_style": {
               "type": "horizontal"
            }
         },
         "metadata": {
            "name": "Multiple choice – multiple response",
            "template_reference": "908de244-5c71-4c09-b094-7fb49554f2f9"
         }
      },
      {
         "type": "mcq",
         "widget_type": "response",
         "reference": "eda8ca96-2d2e-4105-a418-f0503c4716d5",
         "data": {
            "options": [
               {
                  "label": "[Choice A]",
                  "value": "0"
               },
               {
                  "label": "[Choice B]",
                  "value": "1"
               },
               {
                  "label": "[Choice C]",
                  "value": "2"
               },
               {
                  "label": "[Choice D]",
                  "value": "3"
               }
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "type": "mcq",
            "validation": {
               "scoring_type": "exactMatch",
               "valid_response": {
                  "score": 1,
                  "value": []
               }
            },
            "ui_style": {
               "type": "horizontal"
            }
         },
         "metadata": {
            "name": "Multiple choice – standard",
            "template_reference": "9e8149bd-e4d8-4dd6-a751-1a113a4b9163"
         }
      },
      {
         "type": "mcq",
         "widget_type": "response",
         "reference": "94e8088a-05eb-4121-950c-ba24dd38b982",
         "data": {
            "options": [
               {
                  "label": "[Choice A]",
                  "value": "0"
               },
               {
                  "label": "[Choice B]",
                  "value": "1"
               },
               {
                  "label": "[Choice C]",
                  "value": "2"
               },
               {
                  "label": "[Choice D]",
                  "value": "3"
               }
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "type": "mcq",
            "validation": {
               "scoring_type": "exactMatch",
               "valid_response": {
                  "score": 1,
                  "value": []
               }
            },
            "ui_style": {
               "type": "horizontal"
            }
         },
         "metadata": {
            "name": "Multiple choice – standard",
            "template_reference": "9e8149bd-e4d8-4dd6-a751-1a113a4b9163"
         }
      }
   ]
}
JSON;

        $expectedResult = json_decode($expectedResult, true);

        $securityPacket = [
            'consumer_key' => ParamsFixture::TEST_CONSUMER_KEY,
            'domain' => ParamsFixture::TEST_DOMAIN,
        ];

        $dataRequest = [
            'item_references' => [
                'ee31f2da-cf93-4673-a6b2-a07056de456f',
                '2d480565-6044-420f-9f07-52ec6618086e',
            ],
        ];

        $dataApi = new DataApi();

        $results = $dataApi->requestRecursive(
            self::ITEMBANK_QUESTIONS_URI,
            $securityPacket,
            ParamsFixture::TEST_CONSUMER_SECRET,
            $dataRequest,
            'get'
        );

        $this->wrapIsArray($results);

        $this->assertEquals($expectedResult, $results);
    }

    /**
     * @param mixed $result
     */
    protected function wrapIsArray($result)
    {
        if (method_exists($this, 'assertIsArray')) {  // PHPUnit 6 doesn't have this
            $this->assertIsArray($result);
        } else {
            if (!is_array($result)) {
                $this->assertTrue(false, 'value is not an array - ' . print_r($result, true));
            }
        }
    }
}
