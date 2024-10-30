<?php

namespace LearnositySdk\Services\PreHashStrings;

use LearnositySdk\Exceptions\ValidationException;
use LearnositySdk\Utils\Json;

class LegacyPreHashString implements PreHashStringInterface
{
    protected const SERVICE_ASSESS_API = 'assess';
    protected const SERVICE_ANNOTATIONS_API = 'annotations';
    protected const SERVICE_AUTHOR_API = 'author';
    protected const SERVICE_AUTHOR_AIDE_API = 'authoraide';
    protected const SERVICE_DATA_API = 'data';
    protected const SERVICE_EVENTS_API = 'events';
    protected const SERVICE_ITEMS_API = 'items';
    protected const SERVICE_QUESTIONS_API = 'questions';
    protected const SERVICE_REPORTS_API = 'reports';

    /**
     * Service names that are valid for `$service`
     * @var array
     */
    protected const SUPPORTED_SERVICES = [
        self::SERVICE_ASSESS_API,
        self::SERVICE_AUTHOR_API,
        self::SERVICE_AUTHOR_AIDE_API,
        self::SERVICE_DATA_API,
        self::SERVICE_EVENTS_API,
        self::SERVICE_ITEMS_API,
        self::SERVICE_QUESTIONS_API,
        self::SERVICE_REPORTS_API,
    ];

    /**
     * Services that don't use `user_id` as part
     * of the security/signature
     *
     * @var array
     */
    protected const SERVICES_NOT_REQUIRING_USER_ID = [
        self::SERVICE_ANNOTATIONS_API,
        self::SERVICE_AUTHOR_API,
        self::SERVICE_AUTHOR_AIDE_API,
        self::SERVICE_ITEMS_API,
        self::SERVICE_DATA_API,
        self::SERVICE_REPORTS_API,
    ];

    /**
     * Services that require the action attribute to be part
     * of the signature
     *
     * @var array
     */
    protected const SERVICES_REQUIRING_SIGNED_REQUEST = [
        self::SERVICE_AUTHOR_API,
        self::SERVICE_AUTHOR_AIDE_API,
        self::SERVICE_ITEMS_API,
        self::SERVICE_DATA_API,
        self::SERVICE_REPORTS_API,
    ];

    /**
     * Services that require the action attribute to be part
     * of the signature
     *
     * @var array
     */
    protected const SERVICES_REQUIRING_SIGNED_ACTION = [
        self::SERVICE_DATA_API,
    ];

    /**
     * Keynames that are valid in the securityPacket, they are also in
     * the correct order for signature generation.
     * @var array
     * TODO: make this protected when the legacy signing code is gone
     */
    protected const VALID_SECURITY_KEYS = [
        'consumer_key',
        'domain',
        'timestamp',
        'expires',
        'user_id',
    ];

    /**
     * Keynames that are mandatory in the securityPacket.
     * @var array
     * TODO: make this protected when the legacy signing code is gone
     */
    public const MANDATORY_SECURITY_KEYS = [
        'consumer_key',
        'domain',
    ];

    /** Service name to generate a pre-hash string for
     * @var string
     */
    protected /* string */ $service;

    /** V1-compat strings need the secret to be part of the pre-hash string
     * @var bool
     */
    protected /* bool */ $v1Compat;

    public function __construct(string $service, bool $v1Compat = false)
    {
        $this->service = $service;
        $this->v1Compat = $v1Compat;
    }

    public function getPreHashString(
        array $security,
        $request,
        ?string $action = 'get',
        ?string $secret = null
    ): string {
        $signatureArray = [
            $security['consumer_key'],
            $security['domain'],
            $security['timestamp'],
        ];

        if (isset($security['expires'])) {
            $signatureArray[] = $security['expires'];
        }

        if (!in_array($this->service, static::SERVICES_NOT_REQUIRING_USER_ID) || isset($security['user_id'])) {
            if (!isset($security['user_id'])) {
                throw new ValidationException('User ID is required for this service');
            }
            $signatureArray[] = $security['user_id'];
        }

        if ($this->v1Compat) {
            if (empty($secret)) {
                throw new ValidationException('Pre-hash strings require a secret in v1-compat mode');
            }
            $signatureArray[] = $secret;
        } elseif (!empty($secret)) {
            throw new ValidationException('Pre-hash strings do not need a secret');
        }

        if (in_array($this->service, static::SERVICES_REQUIRING_SIGNED_REQUEST)) {
            $signatureArray[] = is_array($request) ? Json::encode($request) : $request;
        }

        // Add the action if necessary
        if (!empty($action)) {
            $signatureArray[] = $action;
        }

        return implode('_', $signatureArray);
    }

    public static function getSupportedServices(): array
    {
        return static::SUPPORTED_SERVICES;
    }

    public static function supportsService(string $service): bool
    {
        return in_array($service, static::SUPPORTED_SERVICES);
    }

    /**
     * Validate and normalise the security and request packets.  Currently
     * nothing is done with the request packet, but future pre-hash schemes
     * may require it.
     */
    public function validate(array $security): array
    {
        foreach (array_keys($security) as $key) {
            if (!in_array($key, static::VALID_SECURITY_KEYS)) {
                throw new ValidationException('Invalid key found in the security packet: ' . $key);
            }
        }
        foreach (static::MANDATORY_SECURITY_KEYS as $key) {
            if (!key_exists($key, $security)) {
                throw new ValidationException('Missing key from the security packet: ' . $key);
            }
        }

        /* Add timestamp if not present */
        if (!array_key_exists('timestamp', $security)) {
            $security['timestamp'] = gmdate('Ymd-Hi');
        }

        /* XXXX move to question prehash string */
        if ($this->service === "questions" && !array_key_exists('user_id', $security)) {
            throw new ValidationException('Questions API requires a `user_id` in the security packet');
        }
        /* end XXX */

        return $security;
    }
}
