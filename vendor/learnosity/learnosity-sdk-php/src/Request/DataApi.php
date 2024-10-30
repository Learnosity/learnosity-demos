<?php

namespace LearnositySdk\Request;

use Exception;
use LearnositySdk\Utils\Json;
use LearnositySdk\Exceptions\ValidationException;

/**
 *--------------------------------------------------------------------------
 * Learnosity SDK - DataApi
 *--------------------------------------------------------------------------
 *
 * Used to make requests to the Learnosity Data API - including
 * generating the security packet
 *
 */

class DataApi
{
    /**
     * @var RemoteInterface
     */
    private $remote;

    /**
     * @param array $remoteOptions Overrides options array for a cURL request
     * @param RemoteInterface|null $remote Overrides default remote class with optional user supplied one
     */
    public function __construct(array $remoteOptions = [], RemoteInterface $remote = null)
    {
        $this->remote = is_null($remote) ? new Remote($remoteOptions) : $remote;
    }

    /**
     * Makes a single request to the data api
     *
     * @param string $endpoint URL to send the request
     * @param array|string $securityPacket Security details
     * @param string $secret Private key
     * @param array $requestPacket Request packet
     * @param string|null $action Action for the request
     * @return RemoteInterface         Instance of the Remote class,
     *                                 the response can be obtained with the getBody() method
     * @throws ValidationException
     */
    public function request(
        string $endpoint,
        $securityPacket,
        string $secret,
        array $requestPacket = [],
        string $action = null
    ): RemoteInterface {
        $init = new Init('data', $securityPacket, $secret, $requestPacket, $action);
        $params = $init->generate();
        return $this->remote->post($endpoint, $params);
    }

    /**
     * Makes a recursive request to the data api, dependant on
     * whether 'next' is returned in the meta object
     *
     * @param string $endpoint URL to send the request
     * @param array|string $securityPacket Security details
     * @param string $secret Private key
     * @param array $requestPacket Request packet
     * @param string|null $action Action for the request
     * @param callable|null $callback Optional callback to execute instead of returning data
     * @param int|null $limit Optional limit on the number of times the request should recur
     * @return array                   Array of all data requests or [] or using a callback
     * @throws ValidationException
     * @throws Exception
     */
    public function requestRecursive(
        string $endpoint,
        $securityPacket,
        string $secret,
        array $requestPacket = [],
        string $action = null,
        callable $callback = null,
        int $limit = null
    ): array {
        $response = [];

        $requests = 0;

        do {
            $request = $this->request($endpoint, $securityPacket, $secret, $requestPacket, $action);
            $data = Json::isJson($request->getBody()) ? json_decode($request->getBody(), true) : $request->getBody();
            if ($data['meta']['status'] === true) {
                if (!empty($callback) && is_callable($callback)) {
                    call_user_func($callback, $data);
                } else {
                    $response = array_merge_recursive($response, $data['data']);
                }
            } else {
                throw new Exception(Json::encode($data));
            }
            if (array_key_exists('next', $data['meta']) && !empty($data['data'])) {
                $requestPacket['next'] = $data['meta']['next'];
            } else {
                unset($requestPacket['next']);
            }

            $requests++;

            if (!is_null($limit) && $requests == $limit) {
                break;
            }
        } while (array_key_exists('next', $requestPacket));

        return $response;
    }
}
