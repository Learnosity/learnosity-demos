<?php

namespace LearnositySdk\Fixtures;

use LearnositySdk\Services\Signatures\HmacSignature;

// XXX: should be in a Test namespace

/**
 * Fixture providing example requests for the various APIs. It also provides some well-known signatures using various of
 * our historical schemes.
 *
 * /!\ Please do not modify those requests lightly. They are used to test backward compatibility of the signature modes,
 * and changing those requests would require changing the expected signatures, based on legacy code that we no longer
 * have in our codebase. /!\
 */
class ParamsFixture
{
    const TEST_CONSUMER_KEY = 'yis0TYCu7U9V4o7M';
    const TEST_CONSUMER_SECRET = '74c5fd430cf1242a527f6223aebd42d30464be22';
    const TEST_DOMAIN = 'localhost';

    public static function getSecurity(): array
    {
        return [
            'consumer_key' => static::TEST_CONSUMER_KEY,
            'domain'       => static::TEST_DOMAIN,
            'timestamp'    => '20140626-0528',
        ];
    }

    /**
     * @param  bool $assoc If true, associative array will be returned
     * @return array
     */
    public static function getWorkingParamsForService(string $service, bool $assoc = false): array
    {
        $camelCaseService = static::kebab2Camel($service);
        $getParams = 'getWorking' . $camelCaseService . 'ApiParams';

        return static::$getParams($assoc);
    }

    /**
     * Return the signature of the selected version for the working params for this service.
     *
     * The signature may be an empty string if the deprecation of the signature version predates the introduction of the
     * service.
     *
     * @return string $service
     * @param  string $signatureVersion, defaults to the HMAC's version (02)
     */
    public static function getSignatureForService(
        string $service,
        string $signatureVersion = HmacSignature::SIGNATURE_VERSION
    ): string {
        $camelCaseService = static::kebab2Camel($service);
        $getSig = 'get' . ucfirst($camelCaseService) . 'ApiSignatureForVersion';

        return static::$getSig($signatureVersion);
    }

    /* Convert kebab-case to camelCase
     * @param string $kebab
     * @return string CamelCase
     */
    protected static function kebab2Camel(string $kebab): string
    {
        return str_replace(
            ' ',
            '',
            ucwords(str_replace('-', ' ', $kebab))
        );
    }

    /**
     * @param  bool $assoc If true, associative array will be returned
     * @return array
     */
    public static function getWorkingAssessApiParams(bool $assoc = false): array
    {
        $service = 'assess';
        $security = static::getSecurity();
        // Needed to initialise Questions API
        $security['user_id'] = '$ANONYMIZED_USER_ID';
        $secret = static::TEST_CONSUMER_SECRET;

        $questionsParams = static::getWorkingQuestionsApiParams(true);
        $questionsApiActivity = $questionsParams['request'];
        $questionsApiActivity['user_id'] = $security['user_id'];
        $questionsApiActivity['name'] = 'Assess API - Demo';
        $questionsApiActivity['id'] = 'assessdemo';

        $request = [
            "items" => [
                [
                    "content" => '<span class="learnosity-response question-demoscience1234"></span>',
                    "response_ids" => [
                        "demoscience1234"
                    ],
                    "workflow" => "",
                    "reference" => "question-demoscience1"
                ],
                [
                    "content" => '<span class="learnosity-response question-demoscience5678"></span>',
                    "response_ids" => [
                        "demoscience5678"
                    ],
                    "workflow" => "",
                    "reference" => "question-demoscience2"
                ]
            ],
            "ui_style" => "horizontal",
            "name" => "Demo (2 questions)",
            "state" => "initial",
            "metadata" => [],
            "navigation" => [
                "show_next" => true,
                "toc" => true,
                "show_submit" => true,
                "show_save" => false,
                "show_prev" => true,
                "show_title" => true,
                "show_intro" => true,
            ],
            "time" => [
                "max_time" => 600,
                "limit_type" => "soft",
                "show_pause" => true,
                "warning_time" => 60,
                "show_time" => true
            ],
            "configuration" => [
                "onsubmit_redirect_url" => "/assessment/",
                "onsave_redirect_url" => "/assessment/",
                "idle_timeout" => true,
                "questionsApiVersion" => "v2"
            ],
            "questionsApiActivity" => $questionsApiActivity,
            "type" => "activity"
        ];
        $action = null;

        $params = [
            'service' => $service,
            'security' => $security,
            'secret' => $secret,
            'request' => $request,
            'action' => $action,
        ];

        if (!$assoc) {
            return array_values($params);
        }

        return $params;
    }

    public static function getAssessApiSignatureForVersion(string $version): string
    {
        return static::getQuestionsApiSignatureForVersion($version);
    }


    /**
     * @param  bool $assoc If true, associative array will be returned
     * @return array
     */
    public static function getWorkingAuthorApiParams(bool $assoc = false): array
    {
        $service = 'author';
        $security = static::getSecurity();
        $secret = static::TEST_CONSUMER_SECRET;
        $request = [
        "mode" => "item_list",
        "config" => [
            "item_list" => [
                "item" => [
                    "status" => true
                ]
            ]
        ],
        "user" => [
            "id" => "walterwhite",
            "firstname" => "walter",
            "lastname" => "white"
        ]
        ];
        $action = null;

        $params = [
            'service' => $service,
            'security' => $security,
            'secret' => $secret,
            'request' => $request,
            'action' => $action,
        ];

        if (!$assoc) {
            return array_values($params);
        }

        return $params;
    }

    /**
     * @param array/string $request
     * @param  bool $assoc If true, associative array will be returned
     * @return array
     */
    public static function getWorkingAuthorApiParamsWithRequest($request, bool $assoc = false): array
    {
        $service = 'author';
        $security = static::getSecurity();
        $secret = static::TEST_CONSUMER_SECRET;
        $action = null;

        $params = [
            'service' => $service,
            'security' => $security,
            'secret' => $secret,
            'request' => $request,
            'action' => $action,
        ];

        if (!$assoc) {
            return array_values($params);
        }

        return $params;
    }

    public static function getAuthorApiSignatureForVersion(string $version): string
    {
        switch ($version) {
            case '01':
                return '108b985a4db36ef03905572943a514fc02ed7cc6b700926183df7babc2cd1c96';
            case '02':
                return '$02$ca2769c4be77037cf22e0f7a2291fe48c470ac6db2f45520a259907370eff861';
            default:
                throw new \Exception(__FUNCTION__ . ' not re-implemented for signature version ' . $version);
        }
    }

    /**
     * @param  bool $assoc If true, associative array will be returned
     * @return array
     */
    public static function getWorkingAuthorAideApiParams(bool $assoc = false): array
    {
        $service = 'authoraide';
        $security = static::getSecurity();
        $secret = static::TEST_CONSUMER_SECRET;
        $request = [
            "config" => [
                "test-attribute" => "test"
            ],
            "user" => [
                "id" => "walterwhite",
                "firstname" => "walter",
                "lastname" => "white"
            ]
        ];
        $action = null;

        $params = [
            'service' => $service,
            'security' => $security,
            'secret' => $secret,
            'request' => $request,
            'action' => $action,
        ];

        if (!$assoc) {
            return array_values($params);
        }

        return $params;
    }

    /**
     * Return the signature of the selected version for the working params for this service.
     * The signature may be an empty string if the deprecation of the signature version predates the introduction of the
     * service
     * @param  string $version
     * @return string
     * @see getWorkingAuthorAideApiParams
     */
    public static function getAuthorAideApiSignatureForVersion(string $version): string
    {
        switch ($version) {
            case '01':
                return '';
            case '02':
                return '$02$f2ce1da2fdead193d53ab954b8a3660548ed9b0e3ce60599d751130deba7a138';
            default:
                throw new \Exception(__FUNCTION__ . ' not re-implemented for signature version ' . $version);
        }
    }

    /**
     * WARNING: RemoteTest is also using this params
     *
     * @param  bool $assoc If true, associative array will be returned
     * @return array
     */
    public static function getWorkingDataApiParams(bool $assoc = false): array
    {
        $service = 'data';
        $security = static::getSecurity();
        $security['timestamp'] = '20140626-0528';
        $secret = static::TEST_CONSUMER_SECRET;
        $request = [
            'limit' => 100,
        ];
        $action = 'get';

        $params = [
            'service' => $service,
            'security' => $security,
            'secret' => $secret,
            'request' => $request,
            'action' => $action,
        ];

        if (!$assoc) {
            return array_values($params);
        }

        return $params;
    }

    public static function getDataApiSignatureForVersion(string $version): string
    {
        switch ($version) {
            case '01':
                return 'e1eae0b86148df69173cb3b824275ea73c9c93967f7d17d6957fcdd299c8a4fe';
            case '02':
                return '$02$e19c8a62fba81ef6baf2731e2ab0512feaf573ca5ca5929c2ee9a77303d2e197';
            default:
                throw new \Exception(__FUNCTION__ . ' not re-implemented for signature version ' . $version);
        }
    }

    /**
     * @param  bool $assoc If true, associative array will be returned
     * @return array
     */
    public static function getWorkingEventsApiParams(bool $assoc = false): array
    {
        $service = 'events';
        $security = static::getSecurity();
        $security['user_id'] = 'events-proctor';
        $secret = static::TEST_CONSUMER_SECRET;
        $request = [
            'users' => [
                '$ANONYMIZED_USER_ID_1' => '$ANONYMIZED_USER_ID_1_NAME',
                '$ANONYMIZED_USER_ID_2' => '$ANONYMIZED_USER_ID_2_NAME',
                '$ANONYMIZED_USER_ID_3' => '$ANONYMIZED_USER_ID_3_NAME',
                '$ANONYMIZED_USER_ID_4' => '$ANONYMIZED_USER_ID_4_NAME'
            ]
        ];
        $action = null;

        $params = [
            'service' => $service,
            'security' => $security,
            'secret' => $secret,
            'request' => $request,
            'action' => $action,
        ];

        if (!$assoc) {
            return array_values($params);
        }

        return $params;
    }

    public static function getEventsApiSignatureForVersion(string $version): string
    {
        switch ($version) {
            case '01':
                return 'fd236f3bc3e14bb291a222637fe86d71c3d4393ed7c51353a2f9a14b356fd605';
            case '02':
                return '$02$e319a1c9c3e0118d1e81188a650b054a765e072a2d90e4b422ecca2ae9589449';
            default:
                throw new \Exception(__FUNCTION__ . ' not re-implemented for signature version ' . $version);
        }
    }

    /**
     * @param  bool $assoc If true, associative array will be returned
     * @return array
     */
    public static function getWorkingItemsApiParams(bool $assoc = false): array
    {
        $service = 'items';
        $security = static::getSecurity();
        $security['user_id'] = '$ANONYMIZED_USER_ID';
        $secret = static::TEST_CONSUMER_SECRET;
        $request = [
            'user_id' => '$ANONYMIZED_USER_ID',
            'rendering_type' => 'assess',
            'name' => 'Items API demo - assess activity demo',
            'state' => 'initial',
            'activity_id' => 'items_assess_demo',
            'session_id' => 'demo_session_uuid',
            'type' => 'submit_practice',
            'config' => [
                'configuration' => [
                    'responsive_regions' => true
                ],
                'navigation' => [
                    'scrolling_indicator' => true
                ],
                'regions' => 'main',
                'time' => [
                    'show_pause' => true,
                    'max_time' => 300
                ],
                'title' => 'ItemsAPI Assess Isolation Demo',
                'subtitle' => 'Testing Subtitle Text'
            ],
            'items' => [
                'Demo3'
            ]
        ];
        $action = null;

        $params = [
            'service' => $service,
            'security' => $security,
            'secret' => $secret,
            'request' => $request,
            'action' => $action,
        ];

        if (!$assoc) {
            return array_values($params);
        }

        return $params;
    }

    public static function getItemsApiSignatureForVersion(string $version): string
    {
        switch ($version) {
            case '01':
                return '82edaf80c2abb55c7a78d089f5b6f89393e621ef4a85150489ac2cfdd6a32f9a';
            case '02':
                return '$02$36c439e7d18f2347ce08ca4b8d4803a22325d54352650b19b6f4aaa521b613d9';
            default:
                throw new \Exception(__FUNCTION__ . ' not re-implemented for signature version ' . $version);
        }
    }

    /**
     * @param  bool $assoc If true, associative array will be returned
     * @return array
     */
    public static function getWorkingQuestionsApiParams(bool $assoc = false): array
    {
        $service = 'questions';
        $security = static::getSecurity();
        $security['user_id'] = '$ANONYMIZED_USER_ID';
        $secret = static::TEST_CONSUMER_SECRET;
        $request = [
            'type'      => 'local_practice',
            'state'     => 'initial',
            'questions' => [
                [
                    'response_id'        => '60005',
                    'type'               => 'association',
                    'stimulus'           => 'Match the cities to the parent nation.',
                    'stimulus_list'      => ['London', 'Dublin', 'Paris', 'Sydney'],
                    'possible_responses' => ['Australia', 'France', 'Ireland', 'England'],
                    'validation' => [
                        'valid_responses' => [
                            ['England'], ['Ireland'], ['France'], ['Australia']
                        ]
                    ]
                ]
            ]
        ];
        $action = null;

        $params = [
            'service' => $service,
            'security' => $security,
            'secret' => $secret,
            'request' => $request,
            'action' => $action,
        ];

        if (!$assoc) {
            return array_values($params);
        }

        return $params;
    }

    public static function getQuestionsApiSignatureForVersion(string $version): string
    {
        switch ($version) {
            case '01':
                return '03f4869659eeaca81077785135d5157874f4800e57752bf507891bf39c4d4a90';
            case '02':
                return '$02$8de51b7601f606a7f32665541026580d09616028dde9a929ce81cf2e88f56eb8';
            default:
                throw new \Exception(__FUNCTION__ . ' not re-implemented for signature version ' . $version);
        }
    }

    /**
     * @param  bool $assoc If true, associative array will be returned
     * @return array
     */
    public static function getWorkingReportsApiParams(bool $assoc = false): array
    {
        $service = 'reports';
        $security = static::getSecurity();
        $secret = static::TEST_CONSUMER_SECRET;
        $request = [
           "reports" => [
               [
                   "id" => "report-1",
                   "type" => "sessions-summary",
                   "user_id" => '$ANONYMIZED_USER_ID',
                   "session_ids" => [
                       "AC023456-2C73-44DC-82DA28894FCBC3BF"
                   ]
               ]
           ]
        ];
        $action = null;

        $params = [
            'service' => $service,
            'security' => $security,
            'secret' => $secret,
            'request' => $request,
            'action' => $action,
        ];

        if (!$assoc) {
            return array_values($params);
        }

        return $params;
    }

    public static function getReportsApiSignatureForVersion(string $version): string
    {
        switch ($version) {
            case '01':
                return '91085beccf57bf0df77c89df94d1055e631b36bc11941e61460b445b4ed774bc';
            case '02':
                return '$02$8e0069e7aa8058b47509f35be236c53fa1a878c64b12589fd42f48b568f6ac84';
            default:
                throw new \Exception(__FUNCTION__ . ' not re-implemented for signature version ' . $version);
        }
    }

    /**
     *
     * @return array
     */
    public static function getMetaField(): array
    {
        return [
            "test_key_string" => "test-string",
            "test_key_integer" => 12345,
            "test_key_boolean" => true,
        ];
    }
}
