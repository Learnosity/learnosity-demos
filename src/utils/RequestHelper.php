<?php

/*
|--------------------------------------------------------------------------
| RequestHelper.php
|--------------------------------------------------------------------------
|
| Used to generate the necessary security and request data (in the
| correct format) to integrate with any of the Learnosity API Services.
|
| Version v1.0
|
*/

class RequestHelper
{
    /**
     * An associative array of security details. This typically contains:
     *  - consumer_key
     *  - domain
     *  - timestamp
     *  - user_id (optional depending on which service is being intialised)
     *
     * It's important that the secret is NOT a part of this array.
     * @var array
     */
    private $securityPacket;

    /**
     * The consumer secret as provided by Learnosity. This is your private
     * known only by the client and Learnosity, which must not be
     * exposed either by sending it to the browser or across the network.
     * It should never be distributed publicly.
     * @var string
     */
    private $secret;

    /**
     * An optional associative array of request parameters used as part
     * of the service initialisation.
     * @var array
     */
    private $requestPacket;

    /**
     * If `requestPacket` is used, `requestString` will the the string
     * (JSON) representation of that. It's used to create the signature
     * and returned as part of the service initialisation data.
     * @var string
     */
    private $requestString;

    /**
     * An optional value used to define what type of request is being
     * made. This is typically only required for certain requests made
     * to the Data API (http://docs.learnosity.com/dataapi/)
     * @var string
     */
    private $action;

    /**
     * Which Learnosity service you are trying to integrate with.
     * Values include:
     *  - assess
     *  - author
     *  - data
     *  - items
     *  - questions
     *  - reports
     * @var string
     */
    private $service;

    /**
     * Most services add the request packet (if passed) to
     * the signature for security reasons. This flag overrides
     * that behaviour for services that don't require this.
     * @var boolean
     */
    private $doSignRequestData = true;

    /**
     * Keynames that are valid in the securityPacket, they are also in
     * the correct order for signature generation.
     * @var array
     */
    private $validSecurityKeys = ['consumer_key', 'domain', 'timestamp', 'user_id'];

    /**
     * Service names that are valid for `service`
     * @var array
     */
    private $validServices = ['assess', 'author', 'data', 'items', 'questions', 'reports'];

    /**
     * The algorithm used in the hashing function to create the signature
     */
    private $algorithm = 'sha256';

    /**
     * Instantiate this class with all security and request data. It
     * will be used to create a signature, and return a JSON object
     * you can used to initialise a Learnosity service.
     *
     * @param string $service
     * @param array  $securityPacket
     * @param string $secret
     * @param array  $requestPacket
     * @param string $action
     */
    public function __construct($service, $securityPacket, $secret, $requestPacket = null, $action = null)
    {
        try {
            // First validate the arguments passed
            $this->validate($service, $securityPacket, $secret, $requestPacket, $action);

            // Set instance variables based off the arguments passed
            $this->service        = $service;
            $this->securityPacket = $securityPacket;
            $this->secret         = $secret;
            $this->requestPacket  = $requestPacket;
            $this->requestString  = $this->generateRequestString();
            $this->action         = $action;

            // Set any service specific options
            $this->setServiceOptions($service);

            // Generate the signature based on the arguments provided
            $this->securityPacket['signature'] = $this->generateSignature();
        } catch (Exception $e) {
            // A validation or unknown error, this has purposefully been left
            // simple, you may enhance as needed
            die($e->getMessage());
        }
    }

    /**
     * Generate the data necessary to make a request to one of the
     * Learnosity products/services.
     * @return string A JSON string
     */
    public function generateRequest()
    {
        $output = [];

        switch ($this->service) {
            case 'assess':
            case 'author':
            case 'data':
            case 'items':
                // Add the security packet (with signature) to the output
                $output['security'] = $this->securityPacket;

                // Stringify the request packet if necessary
                if (!empty($this->requestPacket)) {
                    $output['request'] = $this->requestPacket;
                }

                // Add the action if necessary
                if (!empty($this->action)) {
                    $output['action'] = $this->action;
                }
                break;
            case 'questions':
                // Add the security packet (with signature) to the root of output
                $output = $this->securityPacket;

                // Remove the `domain` key from the security packet
                unset($output['domain']);

                // Stringify the request packet if necessary
                if (!empty($this->requestPacket)) {
                    $output = array_merge_recursive($output, $this->requestPacket);
                }
                break;
            case 'reports':
                // Add the security packet (with signature) to the root of output
                $output = $this->securityPacket;

                // Remove the `domain` key from the security packet
                unset($output['domain']);

                // Stringify the request packet if necessary
                if (!empty($this->requestPacket)) {
                    $output['reports'] = $this->requestPacket;
                }

                // Add the action if necessary
                if (!empty($this->action)) {
                    $output['action'] = $this->action;
                }
                break;
            default:
                // no default
                break;
        }

        if ($this->service === 'data') {
            return 'security=' . json_encode($output['security']) . '&request=' . json_encode($output['request']);
        } elseif ($this->service === 'assess') {
            return $output;
        }

        return json_encode($output);
    }

    /**
     * Generate a JSON string from the requestPacket (array) or null
     * if no requestPacket is required for this request
     * @return mixed
     */
    private function generateRequestString()
    {
        if (empty($this->requestPacket)) {
            return null;
        }
        $requestString = json_encode($this->requestPacket);
        if (false === $requestString) {
            throw new \Exception('Invalid request JSON, please check your requestPacket');
        }
        return $requestString;
    }

    /**
     * Generate a signature hash for the request, this includes:
     *  - the security credentials
     *  - the `request` packet (a JSON string) if passed
     *  - the `action` value if passed
     * @return string A signature hash for the request authentication
     */
    public function generateSignature()
    {
        $signatureArray = [];

        // Create a pre-hash string based on the security credentials
        // The order is important
        foreach ($this->validSecurityKeys as $key) {
            if (array_key_exists($key, $this->securityPacket)) {
                array_push($signatureArray, $this->securityPacket[$key]);
            }
        }

        // Add the secret
        array_push($signatureArray, $this->secret);

        // Add the requestPacket if necessary
        if ($this->doSignRequestData && !empty($this->requestString)) {
            array_push($signatureArray, $this->requestString);
        }

        // Add the action if necessary
        if (!empty($this->action)) {
            array_push($signatureArray, $this->action);
        }

        return hash($this->algorithm, implode('_', $signatureArray));
    }

    /**
     * Set any options for services that aren't generic
     * @param string $service
     */
    private function setServiceOptions($service)
    {
        switch ($service) {
            case 'assess':
            case 'author':
            case 'questions':
            case 'reports':
                $this->doSignRequestData = false;
                break;
            default:
                // do nothing
                break;
        }
    }

    /**
     * Returns the signature that was generated on class instantiation
     * @return string
     */
    public function getSignature()
    {
        return $this->securityPacket['signature'];
    }

    /**
     * Validate the arguments passed to the constructor
     * @param  string $service
     * @param  array $securityPacket
     * @param  string $secret
     * @param  array $requestPacket
     * @param  string $action
     */
    private function validate($service, $securityPacket, $secret, $requestPacket, $action)
    {
        if (empty($service)) {
            throw new \Exception('The `service` argument wasn\'t found or was empty');
        } elseif (!in_array(strtolower($service), $this->validServices)) {
            throw new \Exception("The service provided ($service) is not valid");
        }

        if (!is_array($securityPacket)) {
            throw new \Exception('The securityPacket must be an array');
        } else {
            foreach (array_keys($securityPacket) as $key) {
                if (!in_array($key, $this->validSecurityKeys)) {
                    throw new \Exception('Invalid security key found: ' . $key);
                }
            }
        }

        if (empty($secret) || !is_string($secret) || !strlen(trim($secret))) {
            throw new \Exception('The `secret` argument must be a valid string');
        }

        if (!empty($requestPacket) && (!is_array($requestPacket))) {
            throw new \Exception('requestPacket must be an array');
        }

        if (!empty($action) && (!is_string($action) || !strlen(trim($action)))) {
            throw new \Exception('action must be a string');
        }
    }
}
