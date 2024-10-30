<?php

namespace LearnositySdk\Request;

use LearnositySdk\AbstractTestCase; // XXX: should be in a Test namespace
use LearnositySdk\Exceptions\ValidationException;
use LearnositySdk\Fixtures\ParamsFixture; // XXX: should be in a Test namespace
use LearnositySdk\Services\SignatureFactory;
use LearnositySdk\Services\Signatures\HmacSignature;

class InitTest extends AbstractTestCase
{
    const SDK_SIGNATURE_VERSION = HmacSignature::SIGNATURE_VERSION;
    /**
     * @var \LearnositySdk\Services\SignatureFactory
     */
    private $signatureFactory;

    /*
     * Tests
     */

    /**
     * @dataProvider constructorProvider
     */
    public function testConstructor(
        $service,
        $securityPacket,
        $secret,
        $requestPacket = null,
        $action = null,
        $expectedResult = null,
        $expectedException = null,
        $expectedExceptionMessage = null
    ) {
        if (!empty($expectedException)) {
            $this->expectException($expectedException);
            $this->expectExceptionMessage($expectedExceptionMessage);
        }
        // We disable telemetry to be able to reliably test signature generation. Added telemetry
        // will differ on each platform tests would be run, and therefore fail.
        Init::disableTelemetry();


        $init = new Init($service, $securityPacket, $secret, $requestPacket, $action);

        $this->assertEquals($expectedResult, $init);
    }

    /**
     * @dataProvider generateWithMetaProvider
     */
    public function testGenerateWithMeta(
        string $pathToMeta,
        string $service,
        array $security,
        string $secret,
        /* array|string */ $request,
        ?string $action
    ) {
        // This test verifies the correctness of the added telemetry data
        Init::enableTelemetry();
        $initObject = new Init($service, $security, $secret, $request, $action);
        $generated = $initObject->generate();

        $pathParts = explode('.', $pathToMeta);
        // in case of Author API, Assess API, Events API, Items API, Questions API and Reports API
        // generated value is a string, and therefore needs to be decoded
        $temp = is_string($generated) ? json_decode($generated, true) : $generated;

        for ($i = 0; $i < count($pathParts) && isset($temp[$pathParts[$i]]); $i++) {
            // in case of Data API, request is a string, and therefore needs to be decoded
            $temp = is_string($temp[$pathParts[$i]]) ? json_decode($temp[$pathParts[$i]], true) : $temp[$pathParts[$i]];
        }

        $this->assertEquals($i, count($pathParts));
        $this->assertNotEmpty($temp);
    }

    /**
     * @dataProvider generateSignatureProvider
     */
    public function testGenerateSignature(
        string $expectedSignature,
        string $service,
        array $security,
        string $secret,
        /* array|string */ $request,
        ?string $action
    ) {
        // We disable telemetry to be able to reliably test signature generation. Added telemetry
        // will differ on each platform tests would be run, and therefore fail.
        Init::disableTelemetry();
        $initObject = new Init($service, $security, $secret, $request, $action);

        $this->assertEquals($expectedSignature, $initObject->generateSignature());
    }

    /**
     * @dataProvider generateProvider
     */
    public function testGenerate(
        /* array|string */ $expectedInitOptions,
        string $service,
        array $security,
        string $secret,
        /* array|string */ $request,
        ?string $action
    ) {
        // We disable telemetry to be able to reliably test signature generation. Added telemetry
        // will differ on each platform tests would be run, and therefore fail.
        Init::disableTelemetry();

        $initObject = new Init($service, $security, $secret, $request, $action);
        $generated = $initObject->generate();

        if (is_array($expectedInitOptions)) {
            ksort($expectedInitOptions);
        }

        if (is_array($generated)) {
            ksort($generated);
        }

        $this->assertEquals($expectedInitOptions, $generated);
    }

    public function testNullRequestPacketGeneratesValidInit()
    {
        list($service, $security, $secret) = ParamsFixture::getWorkingDataApiParams();
        $initObject = new Init($service, $security, $secret, null, null);
        $this->assertInstanceOf(Init::class, $initObject);
    }

    public function testEmptyArrayRequestPacketGeneratesValidInit()
    {
        list($service, $security, $secret) = ParamsFixture::getWorkingDataApiParams();
        $initObject = new Init($service, $security, $secret, [], null);
        $this->assertInstanceOf(Init::class, $initObject);
    }

    public function testEmptyStringGeneratesValidInit()
    {
        list($service, $security, $secret) = ParamsFixture::getWorkingDataApiParams();
        $initObject = new Init($service, $security, $secret, "", null);
        $this->assertInstanceOf(Init::class, $initObject);
    }

    public function testNullRequestPacketAndActionGeneratesValidInit()
    {
        list($service, $security, $secret) = ParamsFixture::getWorkingDataApiParams();
        $initObject = new Init($service, $security, $secret, null, null);
        $this->assertInstanceOf(Init::class, $initObject);
    }

    /**
     * @requires PHPUnit >= 9.6
     */
    public function testMetaWithTelemetryOnlyAddsSdkProp()
    {
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingQuestionsApiParams();

        // This test verifies the correctness of the added telemetry data
        Init::enableTelemetry();

        $initObject = new Init($service, $security, $secret, json_encode($request), $action);
        $generatedObject = json_decode($initObject->generate());

        // when telemetry is enabled, if the $request has no meta field,
        // then the meta of the generated object has the sdk field only
        $this->assertObjectHasProperty('meta', $generatedObject);
        $this->assertObjectHasProperty('sdk', $generatedObject->meta);
        $this->assertEquals(1, count((array) $generatedObject->meta));
    }

    /**
     * @requires PHPUnit >= 9.6
     */
    public function testRequestWithTelemetryPreservesOtherMetaProps()
    {
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingQuestionsApiParams();

        // add meta field to the $request
        $request['meta'] = ParamsFixture::getMetaField();

        // generate a new $initObject using the updated $request
        $initObject = new Init($service, $security, $secret, json_encode($request), $action);
        $generatedObject = json_decode($initObject->generate());

        // when telemetry is enabled, if the request has a meta field,
        // then the generated object's meta property should be present
        $this->assertObjectHasProperty('meta', $generatedObject);

        // each key of the meta array should be present in the generated object's meta field as a property
        foreach (array_keys($request['meta']) as $propName) {
            $this->assertObjectHasProperty($propName, $generatedObject->meta);
        }

        // the generated object should have sdk property, too
        $this->assertEquals(count($request['meta']) + 1, count((array) $generatedObject->meta));
        $this->assertObjectHasProperty('sdk', $generatedObject->meta);
    }

    /**
     * @requires PHPUnit >= 9.6
     */
    public function testRequestWithoutTelemetryPreservesEmptyMeta()
    {
        // We disable telemetry to be able to reliably test signature generation. Added telemetry
        // will differ on each platform tests would be run, and therefore fail.
        Init::disableTelemetry();
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingQuestionsApiParams();

        $initObject = new Init($service, $security, $secret, json_encode($request), $action);
        $generatedObject = json_decode($initObject->generate());

        // when telemetry is disabled, if the meta field of the $request is empty,
        // then the meta of the generated object should also be empty
        $this->assertObjectNotHasProperty('meta', $generatedObject);
    }

    /**
     * @requires PHPUnit >= 9.6
     */
    public function testRequestWithoutTelemetryPreservesFilledMeta()
    {
        // We disable telemetry to be able to reliably test signature generation. Added telemetry
        // will differ on each platform tests would be run, and therefore fail.
        Init::disableTelemetry();
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingQuestionsApiParams();

        // add meta field to the $request
        $request['meta'] = ParamsFixture::getMetaField();

        $initObject = new Init($service, $security, $secret, json_encode($request), $action);
        $generatedObject = json_decode($initObject->generate());

        // when telemetry is disabled, if the meta field of the $request has properties,
        // then the meta of the generated object will also contain these properties, and nothing else
        $this->assertObjectHasProperty('meta', $generatedObject);

        foreach (array_keys($request['meta']) as $propName) {
            $this->assertObjectHasProperty($propName, $generatedObject->meta);
        }

        $this->assertEquals(count($request['meta']), count((array) $generatedObject->meta));
        $this->assertObjectNotHasProperty('sdk', $generatedObject->meta);

        Init::enableTelemetry();
    }

    /*
     * Data providers
     */

    public function constructorProvider(): array
    {
        // We disable telemetry to be able to reliably test signature generation. Added telemetry
        // will differ on each platform tests would be run, and therefore fail.
        Init::disableTelemetry();

        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingDataApiParams();

        $wrongSecurity = $security;
        $wrongSecurity['wrongParam'] = '';

        return [
            'valid-api-data' => [
                $service,
                $security,
                $secret,
                $request,
                $action,
                new Init($service, $security, $secret, $request, $action)
            ],
            'empty-service' => [
                '',
                $security,
                $secret,
                $request,
                $action,
                null,
                ValidationException::class,
                'The `service` argument wasn\'t found or was empty'
            ],
            'invalid-service' => [
                'wrongService',
                $security,
                $secret,
                $request,
                $action,
                null,
                ValidationException::class,
                'The service provided (wrongservice) is not valid'
            ],
            'empty-security' => [
                $service,
                '',
                $secret,
                $request,
                $action,
                null,
                ValidationException::class,
                'The security packet must be an array or a valid JSON string'
            ],
            'empty-security' => [
                $service,
                '',
                $secret,
                $request,
                $action,
                null,
                ValidationException::class,
                'The security packet must be an array or a valid JSON string'
            ],
            'null-security' => [
                $service,
                null,
                $secret,
                $request,
                $action,
                null,
                ValidationException::class,
                'The security packet must be an array or a valid JSON string'
            ],
            'empty-secret' => [
                $service,
                $security,
                '',
                $request,
                $action,
                null,
                ValidationException::class,
                'The `secret` argument must be a valid string'
            ],
            'incorrect-security' => [
                $service,
                $wrongSecurity,
                $secret,
                $request,
                $action,
                null,
                ValidationException::class,
                'Invalid key found in the security packet: wrongParam'
            ],
            'missing-questions_user_id' => [
                'questions',
                $security,
                $secret,
                $request,
                $action,
                null,
                ValidationException::class,
                'Questions API requires a `user_id` in the security packet'
            ],
            'invalid-request' => [
                $service,
                $security,
                $secret,
                25,
                $action,
                null,
                ValidationException::class,
                'The request packet must be an array or a valid JSON string'
            ],
        ];
    }

    /** @return array:
     *  - string $expectedSignedInitOptions
     *  - string $service
     *  - array $security
     *  - string $secret
     *  - array|string $request
     *  - ?string $action
     */
    public function generateProvider(): array
    {
        $testCases = [];

        /* Author */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAuthorApiParams();
        $authorApiSig = ParamsFixture::getAuthorApiSignatureForVersion(static::SDK_SIGNATURE_VERSION);
        $authorApi = [
            '{"security":{"consumer_key":"yis0TYCu7U9V4o7M","domain":"localhost","timestamp":"20140626-0528","signature":"'
                . $authorApiSig . '"},"request":{"mode":"item_list","config":{"item_list":{"item":{"status":true}}},"user":{"id":"walterwhite","firstname":"walter","lastname":"white"}}}',
            $service, $security, $secret, $request, $action,
        ];
        $testCases['api-author'] = $authorApi;

        $authorApiAsString = [
            '{"security":{"consumer_key":"yis0TYCu7U9V4o7M","domain":"localhost","timestamp":"20140626-0528","signature":"'
                . $authorApiSig . '"},"request":"{\"mode\":\"item_list\",\"config\":{\"item_list\":{\"item\":{\"status\":true}}},\"user\":{\"id\":\"walterwhite\",\"firstname\":\"walter\",\"lastname\":\"white\"}}"}',
            $service, $security, $secret, json_encode($request), $action,
        ];
        $testCases['api-author_string'] = $authorApiAsString;

        /* Author Aide */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAuthorAideApiParams();
        $authorAideApiSig = ParamsFixture::getAuthorAideApiSignatureForVersion(static::SDK_SIGNATURE_VERSION);
        $authorAideApi = [
            '{"security":{"consumer_key":"yis0TYCu7U9V4o7M","domain":"localhost","timestamp":"20140626-0528","signature":"'
                . $authorAideApiSig . '"},"request":{"config":{"test-attribute":"test"},"user":{"id":"walterwhite","firstname":"walter","lastname":"white"}}}',
            $service, $security, $secret, $request, $action,
        ];
        $testCases['api-authoraide'] = $authorAideApi;

        $authorAideApiAsString = [
            '{"security":{"consumer_key":"yis0TYCu7U9V4o7M","domain":"localhost","timestamp":"20140626-0528","signature":"'
                . $authorAideApiSig . '"},"request":"{\"config\":{\"test-attribute\":\"test\"},\"user\":{\"id\":\"walterwhite\",\"firstname\":\"walter\",\"lastname\":\"white\"}}"}',
            $service, $security, $secret, json_encode($request), $action,
        ];
        $testCases['api-authoraide_string'] = $authorAideApiAsString;

        /* Assess */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAssessApiParams();
        $assessApiSig = ParamsFixture::getAssessApiSignatureForVersion(static::SDK_SIGNATURE_VERSION);
        $assessApi = [
            '{"items":[{"content":"<span class=\"learnosity-response question-demoscience1234\"></span>","response_ids":["demoscience1234"],"workflow":"","reference":"question-demoscience1"},{"content":"<span class=\"learnosity-response question-demoscience5678\"></span>","response_ids":["demoscience5678"],"workflow":"","reference":"question-demoscience2"}],"ui_style":"horizontal","name":"Demo (2 questions)","state":"initial","metadata":[],"navigation":{"show_next":true,"toc":true,"show_submit":true,"show_save":false,"show_prev":true,"show_title":true,"show_intro":true},"time":{"max_time":600,"limit_type":"soft","show_pause":true,"warning_time":60,"show_time":true},"configuration":{"onsubmit_redirect_url":"/assessment/","onsave_redirect_url":"/assessment/","idle_timeout":true,"questionsApiVersion":"v2"},"questionsApiActivity":{"type":"local_practice","state":"initial","questions":[{"response_id":"60005","type":"association","stimulus":"Match the cities to the parent nation.","stimulus_list":["London","Dublin","Paris","Sydney"],"possible_responses":["Australia","France","Ireland","England"],"validation":{"valid_responses":[["England"],["Ireland"],["France"],["Australia"]]}}],"user_id":"$ANONYMIZED_USER_ID","name":"Assess API - Demo","id":"assessdemo","consumer_key":"yis0TYCu7U9V4o7M","timestamp":"20140626-0528","signature":"'
                . $assessApiSig . '"},"type":"activity"}',
            $service, $security, $secret, $request, $action,
        ];
        $testCases['api-assess'] = $assessApi;

        /* Data */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingDataApiParams();
        $dataApiSig = ParamsFixture::getDataApiSignatureForVersion(static::SDK_SIGNATURE_VERSION);
        $dataApiGet = [
            [
                'security' =>
                    '{"consumer_key":"yis0TYCu7U9V4o7M","domain":"localhost","timestamp":"20140626-0528","signature":"'
                    . $dataApiSig . '"}',
                'request'  => '{"limit":100}',
                'action'   => 'get'
            ],
            $service, $security, $secret, $request, $action,
        ];
        $testCases['api-data_get'] = $dataApiGet;

        $dataApiSet = [
            [
                'security' =>
                    '{"consumer_key":"yis0TYCu7U9V4o7M","domain":"localhost","timestamp":"20140626-0528","signature":"'
                    . '$02$d9d0406c92100fff171233a3846d3e2d4ee9b27319a2db5f854909996328437a"}',
                'request'  => '{"limit":100}',
                'action'   => 'set',
            ],
            $service, $security, $secret, $request, 'set',
        ];
        $testCases['api-data_set'] = $dataApiSet;

        /* Events */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingEventsApiParams();
        $eventsApiSig = ParamsFixture::getEventsApiSignatureForVersion(static::SDK_SIGNATURE_VERSION);
        $eventsApiExpected = '{"security":{"consumer_key":"yis0TYCu7U9V4o7M","domain":"localhost","timestamp":"20140626-0528","user_id":"events-proctor","signature":"'
            . $eventsApiSig . '"},"config":{"users":{"$ANONYMIZED_USER_ID_1":"64ccf06154cf4133624372459ebcccb8b2f8bd7458a73df681acef4e742e175c","$ANONYMIZED_USER_ID_2":"7fa4d6ef8926add8b6411123fce916367250a6a99f50ab8ec39c99d768377adb","$ANONYMIZED_USER_ID_3":"3d5b26843da9192319036b67f8c5cc26e1e1763811270ba164665d0027296952","$ANONYMIZED_USER_ID_4":"3b6ac78f60f3e3eb7a85cec8b48bdca0f590f959e0a87a9c4222898678bd50c8"}}}';
        $eventsApi = [
            $eventsApiExpected,
            $service, $security, $secret, $request, $action,
        ];
        $testCases['api-events'] = $eventsApi;

        /* Items */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingItemsApiParams();
        $itemsApiSig = ParamsFixture::getItemsApiSignatureForVersion(static::SDK_SIGNATURE_VERSION);
        $itemsApi = [
            '{"security":{"consumer_key":"yis0TYCu7U9V4o7M","domain":"localhost","timestamp":"20140626-0528","user_id":"$ANONYMIZED_USER_ID","signature":"'
                . $itemsApiSig . '"},"request":{"user_id":"$ANONYMIZED_USER_ID","rendering_type":"assess","name":"Items API demo - assess activity demo","state":"initial","activity_id":"items_assess_demo","session_id":"demo_session_uuid","type":"submit_practice","config":{"configuration":{"responsive_regions":true},"navigation":{"scrolling_indicator":true},"regions":"main","time":{"show_pause":true,"max_time":300},"title":"ItemsAPI Assess Isolation Demo","subtitle":"Testing Subtitle Text"},"items":["Demo3"]}}',
            $service, $security, $secret, $request, $action,
        ];
        $testCases['api-items'] = $itemsApi;

        $itemsApiAsString = [
            '{"security":{"consumer_key":"yis0TYCu7U9V4o7M","domain":"localhost","timestamp":"20140626-0528","user_id":"$ANONYMIZED_USER_ID","signature":"'
                . $itemsApiSig . '"},"request":"{\"user_id\":\"$ANONYMIZED_USER_ID\",\"rendering_type\":\"assess\",\"name\":\"Items API demo - assess activity demo\",\"state\":\"initial\",\"activity_id\":\"items_assess_demo\",\"session_id\":\"demo_session_uuid\",\"type\":\"submit_practice\",\"config\":{\"configuration\":{\"responsive_regions\":true},\"navigation\":{\"scrolling_indicator\":true},\"regions\":\"main\",\"time\":{\"show_pause\":true,\"max_time\":300},\"title\":\"ItemsAPI Assess Isolation Demo\",\"subtitle\":\"Testing Subtitle Text\"},\"items\":[\"Demo3\"]}"}',
            $service, $security, $secret, json_encode($request), $action,
        ];
        $testCases['api-items_string'] = $itemsApiAsString;

        /* Questions */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingQuestionsApiParams();
        $questionsApiSig = ParamsFixture::getAssessApiSignatureForVersion(static::SDK_SIGNATURE_VERSION);
        $questionsApi = [
            '{"consumer_key":"yis0TYCu7U9V4o7M","timestamp":"20140626-0528","user_id":"$ANONYMIZED_USER_ID","signature":"'
                . $questionsApiSig . '","type":"local_practice","state":"initial","questions":[{"response_id":"60005","type":"association","stimulus":"Match the cities to the parent nation.","stimulus_list":["London","Dublin","Paris","Sydney"],"possible_responses":["Australia","France","Ireland","England"],"validation":{"valid_responses":[["England"],["Ireland"],["France"],["Australia"]]}}]}',
            $service, $security, $secret, $request, $action,
        ];
        $testCases['api-questions'] = $questionsApi;

        /* Reports */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingReportsApiParams();
        $reportsApiSig = ParamsFixture::getReportsApiSignatureForVersion(static::SDK_SIGNATURE_VERSION);
        $reportsApi = [
            '{"security":{"consumer_key":"yis0TYCu7U9V4o7M","domain":"localhost","timestamp":"20140626-0528","signature":"'
                . $reportsApiSig . '"},"request":{"reports":[{"id":"report-1","type":"sessions-summary","user_id":"$ANONYMIZED_USER_ID","session_ids":["AC023456-2C73-44DC-82DA28894FCBC3BF"]}]}}',
            $service, $security, $secret, $request, $action,
        ];
        $testCases['api-reports'] = $reportsApi;

        Init::enableTelemetry();

        return $testCases;
    }

        /** @return array:
        *  - string $expectedSignature
        *  - string $service
        *  - array $security
        *  - string $secret
        *  - array|string $request
        *  - ?string $action
        */
    public function generateSignatureProvider(): array
    {
        $testCases = [];

        /* Author */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAuthorApiParams();
        $authorApi = [
        ParamsFixture::getAuthorApiSignatureForVersion(static::SDK_SIGNATURE_VERSION),
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-author'] = $authorApi;

        /* Assess */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAssessApiParams();
        $assessApi = [
        ParamsFixture::getAssessApiSignatureForVersion(static::SDK_SIGNATURE_VERSION),
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-assess'] = $assessApi;

        /* Data */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingDataApiParams();

        $dataApi = [
        ParamsFixture::getDataApiSignatureForVersion(static::SDK_SIGNATURE_VERSION),
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-data'] = $dataApi;

        /* Events */
        $dataApiSet = [
            '$02$d9d0406c92100fff171233a3846d3e2d4ee9b27319a2db5f854909996328437a',
            $service, $security, $secret, $request, 'set',
        ];
        $testCases['api-data_set'] = $dataApiSet;

        $securityExpires = $security;
        $securityExpires['expires'] = '20160621-1716';
        $dataApiExpire = [
        '$02$579bbf967c9fa886865fc85313bf0f70bdf3636a78732439ea19d6c2b908f49c',
        $service, $securityExpires, $secret, $request, $action,
        ];
        $testCases['api-data_expire'] = $dataApiExpire;

        /* Events */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingEventsApiParams();
        $eventsApi = [
        ParamsFixture::getEventsApiSignatureForVersion(static::SDK_SIGNATURE_VERSION),
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-events'] = $eventsApi;

        /* Items */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingItemsApiParams();
        $itemsApi = [
        ParamsFixture::getItemsApiSignatureForVersion(static::SDK_SIGNATURE_VERSION),
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-items'] = $itemsApi;

        /* Questions */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingQuestionsApiParams();
        $questionsApi = [
        ParamsFixture::getQuestionsApiSignatureForVersion(static::SDK_SIGNATURE_VERSION),
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-questions'] = $questionsApi;

        /* Reports */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingReportsApiParams();
        $reportsApi = [
        ParamsFixture::getReportsApiSignatureForVersion(static::SDK_SIGNATURE_VERSION),
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-reports'] = $reportsApi;

        /* Author with empty request array */
        $requestAsEmptyArray = [];
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAuthorApiParamsWithRequest($requestAsEmptyArray);
        $authorApi = [
            '$02$a863357d50c59921e8263cf49383ac2b02bf48ec4402dab183bf5d7160d721c9',
            $service, $security, $secret, $request, $action,
        ];

        $testCases['api-author-empty-array'] = $authorApi;

        /* Author with empty request object */
        $requestAsEmptyJsonString = '{}';
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAuthorApiParamsWithRequest($requestAsEmptyJsonString);
        $authorApi = [
            '$02$7aaad82e101617545a04bdd2513f425b5bf82bc77f9d86c2f7e8972a18e8d6b5',
            $service, $security, $secret, $request, $action,
        ];

        $testCases['api-author-empty-json'] = $authorApi;

        /* Author with line breaks in request object */
        $requestWithLineBreaks = '{
            "mode":"item_list",
            "config":{"item_list":{"item":{}}},"user":{"id":"briammoser"}
        }';
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAuthorApiParamsWithRequest($requestWithLineBreaks);
        $authorApi = [
            '$02$9f5541fe7ef9e74d9dd17f9df3c8d5d17534695f576ddb573635d9bb510d1ac0',
            $service, $security, $secret, $request, $action,
        ];

        $testCases['api-author-with-line-breaks'] = $authorApi;

        return $testCases;
    }

        /** @return array:
        *  - string $pathToMeta
        *  - string $service
        *  - array $security
        *  - string $secret
        *  - array|string $request
        *  - ?string $action
        */
    public function generateWithMetaProvider(): array
    {
        $testCases = [];

        /* Author */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAuthorApiParams();
        $authorApi = [
        'request.meta',
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-author'] = $authorApi;

        /* Author Aide */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAuthorAideApiParams();
        $authorAideApi = [
        'request.meta',
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-authoraide'] = $authorAideApi;

        /* Assess */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingAssessApiParams();
        $assessApi = [
        'meta',
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-assess'] = $assessApi;

        /* Data */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingDataApiParams();
        $dataApi = [
        'request.meta',
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-data'] = $dataApi;

        /* Events */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingEventsApiParams();
        $eventsApi = [
        'config.meta',
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-events'] = $eventsApi;

        /* Items */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingItemsApiParams();
        $itemsApi = [
        'request.meta',
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-items'] = $itemsApi;

        /* Questions */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingQuestionsApiParams();
        $questionsApi = [
        'meta',
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-questions'] = $questionsApi;

        /* Reports */
        list($service, $security, $secret, $request, $action) = ParamsFixture::getWorkingReportsApiParams();
        $reportsApi = [
        'request.meta',
        $service, $security, $secret, $request, $action,
        ];
        $testCases['api-reports'] = $reportsApi;

        return $testCases;
    }
}
