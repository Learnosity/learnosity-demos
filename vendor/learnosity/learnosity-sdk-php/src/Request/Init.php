<?php

namespace LearnositySdk\Request;

use LearnositySdk\Exceptions\ValidationException;
use LearnositySdk\Services\PreHashStringFactory;
use LearnositySdk\Services\PreHashStrings\LegacyPreHashString;
use LearnositySdk\Services\SignatureFactory;
use LearnositySdk\Services\Signatures\HashSignature;
use LearnositySdk\Services\Signatures\HmacSignature;
use LearnositySdk\Utils\Json;

/**
 *--------------------------------------------------------------------------
 * Learnosity SDK - Init
 *--------------------------------------------------------------------------
 *
 * Used to generate the necessary security and request data (in the
 * correct format) to integrate with any of the Learnosity API services.
 *
 */

class Init
{
    protected const VERSION_FILE_PATH = __DIR__ . '/../../.version';

    /**
     * The algorithm used in the hashing function to create the api-events signature
     */
    protected const ALGORITHM = 'sha256';

    /**
     * We use telemetry to enable better support and feature planning. It is however not advised to
     * disable it, and it will not interfere with any usage.
     * @var boolean
     */
    protected static $telemetryEnabled = true;

    /**
     * Which Learnosity service to generate a request packet for.
     * @var string
     * @see PreHashStringFactory::getValidServices()
     */
    private $service;

    /**
     * The consumer secret as provided by Learnosity. This is your private key
     * known only by the client (you) and Learnosity, which must not be exposed
     * either by sending it to the browser or across the network.
     * It should never be distributed publicly.
     * @var string
     */
    private $secret;

    /**
     * An associative array of security details. This typically contains:
     *  - consumer_key
     *  - domain (optional depending on which service is being intialised)
     *  - timestamp (optional)
     *  - user_id (optional depending on which service is being intialised)
     *
     * It's important that the consumer secret is NOT a part of this array.
     * @var array
     */
    private $securityPacket;

    /**
     * An optional associative array of request parameters used as part
     * of the service (API) initialisation.
     * @var array
     */
    private $requestPacket;

    private $decodedRequestPacket;

    /**
     * Tracking if the request was passed as a string. If the request is indeed passed as string,
     * there is an attempt to not alter the string in any way by decoding and encoding. This will
     * only work if telemetry is disabled. Otherwise the metadata has to be set in the request
     * meaning that decoding is required. It also does not work for assess if it has questions
     * api settings
     *
     * @var bool
     */
    private $requestPassedAsString = false;

    /**
     * An optional value used to define what type of request is being
     * made. This is only required for certain requests made to the
     * Data API (http://docs.learnosity.com/dataapi/)
     * @var string
     */
    private $action;

    /**
     * Most services add the request packet (if passed) to the signature
     * for security reasons. This flag can override that behaviour for
     * services that don't require this.
     * @var boolean
     */
    private $signRequestData = true;

    /**
     * @var SignatureFactory
     */
    private $signatureFactory;

    /**
     * @var PreHashStringFactory
     */
    private $preHashStringFactory;

    /**
     * @var PreHashStringInterface
     */
    private $preHashStringGenerator;

    /**
     * Instantiate this class with all security and request data. It
     * will be used to create a signature.
     *
     * @param string $service
     * @param string|array $securityPacket
     * @param string $secret
     * @param string|array $requestPacket
     * @param string $action
     * @param SignatureFactory|null $signatureFactory
     * @throws ValidationException
     */
    public function __construct(
        string $service,
        $securityPacket,
        string $secret,
        $requestPacket = null,
        string $action = null,
        SignatureFactory $signatureFactory = null,
        PreHashStringFactory $preHashStringFactory = null
    ) {
        $this->signatureFactory = $signatureFactory;
        if (!isset($signatureFactory)) {
            $this->signatureFactory = new SignatureFactory();
        }

        $this->preHashStringFactory = $preHashStringFactory;
        if (!isset($preHashStringFactory)) {
            $this->preHashStringFactory = new PreHashStringFactory();
        }

        $this->preHashStringGenerator = $this->preHashStringFactory->getPreHashStringGenerator($service);

        // Set instance variables based off the arguments passed
        $this->service            = $service;
        $this->securityPacket     = $securityPacket;
        $this->secret             = $secret;
        $this->requestPacket      = $requestPacket;
        $this->action             = $action;
        $this->validate();

        if (self::$telemetryEnabled) {
            $this->addMeta();
        }

        // Set any service specific options
        $this->setServiceOptions();

        // Generate the signature based on the arguments provided
        $this->securityPacket['signature'] = $this->generateSignature();
    }

    /**
     * Adds metadata to request packet to enable telemetry and tracking. Request packet will be
     * extended with following parameters:
     * {
     *   "meta": {
     *     "sdk": {
     *       "version": "v0.10.0",
     *       "lang": "php",
     *       "lang_version": "5.6.36",
     *       "platform": "Linux",
     *       "platform_version": "3.10.0-862.6.3.el7.x86_64"
     *     }
     *   }
     * }
     *
     */
    private function addMeta()
    {
        $sdkMetricsMeta = [
            'version' => $this->getSDKVersion(),
            'lang' => 'php',
            'lang_version' => phpversion(),
            'platform' => php_uname('s'),
            'platform_version' => php_uname('r')
        ];

        if (isset($this->decodedRequestPacket['meta'])) {
            $this->decodedRequestPacket['meta']['sdk'] = $sdkMetricsMeta;
        } else {
            $this->decodedRequestPacket['meta'] = [
                'sdk' => $sdkMetricsMeta
            ];
        }
        $this->requestPacket = Json::encode($this->decodedRequestPacket);
    }

    /**
     * @return string
     */
    private function getSDKVersion(): string
    {
        if (!file_exists(self::VERSION_FILE_PATH)) {
            return 'unknown';
        }

        return trim(file_get_contents(self::VERSION_FILE_PATH));
    }

    /**
     * Generate the data necessary to make a request to one of the
     * Learnosity products/services.
     *
     * @param bool $encode Encode the result as a JSON string
     * @return string|array The data to pass to a Learnosity API
     */
    public function generate(bool $encode = true)
    {
        $output = [];

        switch ($this->service) {
            case 'data':
                // Add the security packet (with signature) to the output
                $output['security'] = Json::encode($this->securityPacket);

                $output['request'] = Json::encode($this->decodedRequestPacket);

                if (!empty($this->action)) {
                    $output['action'] = $this->action;
                }

                $encode = false;
                break;
            case 'assess':
                // Stringify the request packet if necessary
                $output = $this->requestPassedAsString ?
                    $this->requestPacket :
                    $this->decodedRequestPacket;
                break;
            case 'author':
            case 'authoraide':
            case 'items':
            case 'reports':
                // Add the security packet (with signature) to the output
                $output['security'] = $this->securityPacket;

                // Stringify the request packet if necessary
                $output['request'] = $this->requestPassedAsString ?
                    $this->requestPacket :
                    $this->decodedRequestPacket;
                break;
            case 'questions':
                // Add the security packet (with signature) to the root of output
                $output = $this->securityPacket;

                // Remove the `domain` key from the security packet
                unset($output['domain']);

                if (!empty($this->decodedRequestPacket)) {
                    $output = array_merge($output, $this->decodedRequestPacket);
                }
                break;
            case 'events':
                // Add the security packet (with signature) to the output
                $output['security'] = $this->securityPacket;
                $output['config'] = $this->decodedRequestPacket;
                break;
            default:
                // no default
                break;
        }

        return $encode ? Json::encode($output) : $output;
    }

    /**
     * Generate a signature hash for the request, this includes:
     *  - the security credentials
     *  - the `request` packet (a JSON string) if passed
     *  - the `action` value if passed
     *
     * @return string A signature hash for the request authentication
     */
    public function generateSignature(): string
    {
        $preHashString = $this->preHashStringGenerator->getPreHashString(
            $this->securityPacket,
            $this->requestPacket,
            $this->action
        );

        // As we only support v2 from this point onwards
        // we do not need to check the version at this point,
        // Instead we can pass HmacSignatures version
        $signatureGenerator = $this->signatureFactory->getSignatureGenerator(
            HmacSignature::SIGNATURE_VERSION
        );

        return $signatureGenerator->sign($preHashString, $this->secret);
    }

    /**
     * Set any options for services that aren't generic
     * @throws ValidationException
     */
    private function setServiceOptions()
    {
        switch ($this->service) {
            case 'assess':
                $this->signRequestData = false;
                // The Assess API holds data for the Questions API that includes
                // security information and a signature. Retrieve the security
                // information from $this and generate a signature for the
                // Questions API
                if (array_key_exists('questionsApiActivity', $this->decodedRequestPacket)) {
                    // prepare signature parts
                    $signatureParts = [];
                    $signatureParts['consumer_key'] = $this->securityPacket['consumer_key'];
                    if (isset($this->securityPacket['domain'])) {
                        $signatureParts['domain'] = $this->securityPacket['domain'];
                    } elseif (isset($this->decodedRequestPacket['questionsApiActivity']['domain'])) {
                        $signatureParts['domain'] = $this->decodedRequestPacket['questionsApiActivity']['domain'];
                    } else {
                        $signatureParts['domain'] = 'assess.learnosity.com';
                    }
                    $signatureParts['timestamp'] = $this->securityPacket['timestamp'];
                    if (isset($this->securityPacket['expires'])) {
                        $signatureParts['expires'] = $this->securityPacket['expires'];
                    }
                    $signatureParts['user_id'] = $this->securityPacket['user_id'];
                    $signatureParts['secret'] = $this->secret;

                    // override security parameters in questionsApiActivity
                    $questionsApi = $this->decodedRequestPacket['questionsApiActivity'];
                    $questionsApi['consumer_key'] = $signatureParts['consumer_key'];
                    unset($questionsApi['domain']);
                    $questionsApi['timestamp'] = $signatureParts['timestamp'];
                    if (isset($signatureParts['expires'])) {
                        $questionsApi['expires'] = $signatureParts['expires'];
                    } else {
                        unset($questionsApi['expires']);
                    }
                    $questionsApi['user_id'] = $signatureParts['user_id'];
                    $this->securityPacket = $signatureParts;
                    $questionsApi['signature'] = $this->generateSignature();

                    $this->decodedRequestPacket['questionsApiActivity'] = $questionsApi;
                    $this->requestPacket = Json::encode($this->decodedRequestPacket);
                }
                break;
            case 'questions':
                $this->signRequestData = false;
                break;
            case 'items':
            case 'reports':
                // The Events API requires a user_id, so we make sure it's a part
                // of the security packet as we share the signature in some cases
                if (
                    array_key_exists('user_id', $this->decodedRequestPacket) &&
                    !array_key_exists('user_id', $this->securityPacket)
                ) {
                    $this->securityPacket['user_id'] = $this->decodedRequestPacket['user_id'];
                }
                break;
            case 'events':
                $this->signRequestData = false;
                $users = $this->decodedRequestPacket['users'];
                $hashedUsers = [];
                if (!$this->isAssocArray($users)) {
                    throw new ValidationException('Passing an array of user IDs is deprecated,' .
                        ' it should be an associative array with user IDs as keys.');
                } else {
                    $users = array_keys($users);
                }
                foreach ($users as $user) {
                    $hashedUsers[$user] = hash(
                        self::ALGORITHM,
                        $user . $this->secret
                    );
                }
                if (count($hashedUsers)) {
                    $this->decodedRequestPacket['users'] = $hashedUsers;
                    $this->requestPacket = Json::encode($this->decodedRequestPacket);
                }
                break;
            default:
                // do nothing
                break;
        }
    }

    /**
     * Validate the arguments passed to the constructor
     *
     * @return array
     * @throws ValidationException
     */
    public function validate()
    {
        $this->validateAndSetRequestPacket();
        // In case the user gave us a JSON securityPacket, convert to an array
        if (is_string($this->securityPacket)) {
            $this->securityPacket = json_decode($this->securityPacket, true);
        }

        if (empty($this->securityPacket) || !is_array($this->securityPacket)) {
            throw new ValidationException('The security packet must be an array or a valid JSON string');
        }

        if (empty($this->secret)) {
            throw new ValidationException('The `secret` argument must be a valid string');
        }

        $this->securityPacket = $this->preHashStringGenerator->validate($this->securityPacket);
    }

    private function validateAndSetRequestPacket()
    {
        $this->requestPassedAsString = $this->isRequestNonEmptyString();
        if ($this->requestPassedAsString) {
            $this->decodedRequestPacket = json_decode($this->requestPacket, true);
            if (!is_array($this->decodedRequestPacket)) {
                throw new ValidationException('The request packet must be an array or a valid JSON string');
            }
            return;
        }

        if (!empty($this->requestPacket) && !is_array($this->requestPacket)) {
            throw new ValidationException('The request packet must be an array or a valid JSON string');
        }
        if (empty($this->requestPacket)) {
            $this->requestPacket = [];
        }
        $this->decodedRequestPacket = $this->requestPacket;
        $this->requestPacket = Json::encode($this->decodedRequestPacket);
    }

    private function isRequestNonEmptyString(): bool
    {
        return is_string($this->requestPacket) && !empty($this->requestPacket);
    }

    /**
     * @param array $array
     * @return bool
     */
    private static function isAssocArray(array $array): bool
    {
        $array = array_keys($array);
        return ($array !== array_keys($array));
    }

    /**
     * Disables telemetry.
     *
     * We use telemetry to enable better support and feature planning. It is therefore not advised to
     * disable it, because it will not interfere with any usage.
     */
    public static function disableTelemetry()
    {
        self::$telemetryEnabled = false;
    }

    /**
     * Enables telemetry.
     *
     * Telemetry is enabled by default. We use it to enable better support and feature planning.
     * It is however not advised to disable it, and it will not interfere with any usage.
     */
    public static function enableTelemetry()
    {
        self::$telemetryEnabled = true;
    }
}
