<?php

namespace LearnositySdk\Services\PreHashStrings;

use LearnositySdk\AbstractTestCase;
use LearnositySdk\Exceptions\ValidationException;
use LearnositySdk\Fixtures\ParamsFixture;

class LegacyPreHashStringTest extends AbstractTestCase
{
    /** @dataProvider preHashStringProvider */
    public function testPreHashString(
        string $service,
        array $security,
        string $secret,
        ?array $request,
        ?string $action,
        bool $v1Compat,
        string $expected
    ) {
        $preHashString = new LegacyPreHashString($service, $v1Compat);
        $result = $preHashString->getPreHashString($security, $request, $action, $v1Compat ? $secret : null);
        $this->assertEquals($expected, $result);
    }

    /** @returns array<string, array<
     *   string $service
     *   array $security
     *   string $secret
     *   array $request
     *   ?string $action
     *   bool $v1Compat
     *   string $expected
     * >> */
    public function preHashStringProvider()
    {
        $testCases = [];

        /* Hardcoded prehash strings generated with the last version of the legacy code,
         * based on queries from the ParamsFixture, depending on v1Compat mode */
        $preHashStrings = [
            false => [
                'assess' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_$ANONYMIZED_USER_ID',
                'author' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_{"mode":"item_list","config":{"item_list":{"item":{"status":true}}},"user":{"id":"walterwhite","firstname":"walter","lastname":"white"}}',
                'authoraide' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_{"config":{"test-attribute":"test"},"user":{"id":"walterwhite","firstname":"walter","lastname":"white"}}',
                'data' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_{"limit":100}_get',
                'events' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_events-proctor',
                'items' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_$ANONYMIZED_USER_ID_{"user_id":"$ANONYMIZED_USER_ID","rendering_type":"assess","name":"Items API demo - assess activity demo","state":"initial","activity_id":"items_assess_demo","session_id":"demo_session_uuid","type":"submit_practice","config":{"configuration":{"responsive_regions":true},"navigation":{"scrolling_indicator":true},"regions":"main","time":{"show_pause":true,"max_time":300},"title":"ItemsAPI Assess Isolation Demo","subtitle":"Testing Subtitle Text"},"items":["Demo3"]}',
                'questions' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_$ANONYMIZED_USER_ID',
                'reports' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_{"reports":[{"id":"report-1","type":"sessions-summary","user_id":"$ANONYMIZED_USER_ID","session_ids":["AC023456-2C73-44DC-82DA28894FCBC3BF"]}]}',
            ],
            true => [
                /* Generated from a the ParamsFixture knowing that a v1 signature was generated correctly */
                'assess' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_$ANONYMIZED_USER_ID_74c5fd430cf1242a527f6223aebd42d30464be22',
                'author' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_74c5fd430cf1242a527f6223aebd42d30464be22_{"mode":"item_list","config":{"item_list":{"item":{"status":true}}},"user":{"id":"walterwhite","firstname":"walter","lastname":"white"}}',
                'authoraide' => null, /* no need for v1 compat, let's make this explicit */
                'data' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_74c5fd430cf1242a527f6223aebd42d30464be22_{"limit":100}_get',
                'events' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_events-proctor_74c5fd430cf1242a527f6223aebd42d30464be22',
                'items' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_$ANONYMIZED_USER_ID_74c5fd430cf1242a527f6223aebd42d30464be22_{"user_id":"$ANONYMIZED_USER_ID","rendering_type":"assess","name":"Items API demo - assess activity demo","state":"initial","activity_id":"items_assess_demo","session_id":"demo_session_uuid","type":"submit_practice","config":{"configuration":{"responsive_regions":true},"navigation":{"scrolling_indicator":true},"regions":"main","time":{"show_pause":true,"max_time":300},"title":"ItemsAPI Assess Isolation Demo","subtitle":"Testing Subtitle Text"},"items":["Demo3"]}',
                'questions' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_$ANONYMIZED_USER_ID_74c5fd430cf1242a527f6223aebd42d30464be22',
                'reports' => 'yis0TYCu7U9V4o7M_localhost_20140626-0528_74c5fd430cf1242a527f6223aebd42d30464be22_{"reports":[{"id":"report-1","type":"sessions-summary","user_id":"$ANONYMIZED_USER_ID","session_ids":["AC023456-2C73-44DC-82DA28894FCBC3BF"]}]}',
            ],
        ];

        foreach ([true, false] as $v1Compat) {
            foreach (LegacyPreHashString::getSupportedServices() as $service) {
                $case = array_merge(
                    ParamsFixture::getWorkingParamsForService($service, true),
                    [
                        'v1Compat' => $v1Compat,
                    ]
                );

                $case['expected'] = $preHashStrings[$v1Compat][$service];

                if (is_null($case['expected'])) {
                    /* New APIs don't need v1Compat support */
                    continue;
                }

                $testCases["api-{$service}" . ($v1Compat ? '-v1Compat' : '')] = $case;
            }
        }

        return array_merge($testCases, $this->additionalTests());
    }

    /**
     * Additional test cases that detect bugs found or anticipated.
     * @returns array <string $name, array <
     *  string $service
     *  array $security
     *  string $secret
     *  array $request
     *  ?string $action
     *  bool $v1Compat
     *  string $expected
     * >>
     */
    public function additionalTests(): array
    {
        return [
            'api-items-json_encode-bug' => $this->jsonEncodeBugParams(),
            'api-items-json_encode-url' => $this->jsonEncodeUrlParams(),
            'api-data-optional-user_id' => $this->unnecessaryUserId(),
        ];
    }

    /**
     * Test case for a bug found when the request contains escapable characters.
     * @returns array <
     *  string $service
     *  array $security
     *  string $secret
     *  array $request
     *  ?string $action
     *  bool $v1Compat
     *  string $expected
     * >
     */
    public function jsonEncodeBugParams(): array
    {
        $params = ParamsFixture::getWorkingItemsApiParams(true);
        $params['request']['name'] = str_replace('-', '<&\'>', $params['request']['name']);
        $params['v1Compat'] = false;
        $params['expected'] = 'yis0TYCu7U9V4o7M_localhost_20140626-0528_$ANONYMIZED_USER_ID_{"user_id":"$ANONYMIZED_USER_ID","rendering_type":"assess","name":"' . $params['request']['name'] . '","state":"initial","activity_id":"items_assess_demo","session_id":"demo_session_uuid","type":"submit_practice","config":{"configuration":{"responsive_regions":true},"navigation":{"scrolling_indicator":true},"regions":"main","time":{"show_pause":true,"max_time":300},"title":"ItemsAPI Assess Isolation Demo","subtitle":"Testing Subtitle Text"},"items":["Demo3"]}';
        return $params;
    }

    /**
     * Test case for correct JSON encoding of URLs.
     * @returns array <
     *  string $service
     *  array $security
     *  string $secret
     *  array $request
     *  ?string $action
     *  bool $v1Compat
     *  string $expected
     * >
     */
    public function jsonEncodeUrlParams(): array
    {
        $params = ParamsFixture::getWorkingItemsApiParams(true);
        $params['request']['config']['configuration']['onsave_redirect_url'] = '/learning/assessments/';
        $params['v1Compat'] = false;
        $params['expected'] = 'yis0TYCu7U9V4o7M_localhost_20140626-0528_$ANONYMIZED_USER_ID_{"user_id":"$ANONYMIZED_USER_ID","rendering_type":"assess","name":"Items API demo - assess activity demo","state":"initial","activity_id":"items_assess_demo","session_id":"demo_session_uuid","type":"submit_practice","config":{"configuration":{"responsive_regions":true,"onsave_redirect_url":"/learning/assessments/"},"navigation":{"scrolling_indicator":true},"regions":"main","time":{"show_pause":true,"max_time":300},"title":"ItemsAPI Assess Isolation Demo","subtitle":"Testing Subtitle Text"},"items":["Demo3"]}';
        return $params;
    }

    /**
     * Test case for optional presence of the user_id in the security packet.
     * @returns array <
     * string $service
     * array $security
     * string $secret
     * array $request
     * ?string $action
     * bool $v1Compat
     * string $expected
     * >
     */
    public function unnecessaryUserId(): array
    {
        $params = ParamsFixture::getWorkingDataApiParams(true);
        $params['security']['user_id'] = 'a-user-id';
        $params['v1Compat'] = false;
        $params['expected'] = 'yis0TYCu7U9V4o7M_localhost_20140626-0528_a-user-id_{"limit":100}_get';
        return $params;
    }
}
