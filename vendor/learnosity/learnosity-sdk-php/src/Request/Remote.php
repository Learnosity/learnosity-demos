<?php

namespace LearnositySdk\Request;

use LearnositySdk\Utils\Conversion;

/**
 *--------------------------------------------------------------------------
 * Learnosity SDK - Remote
 *--------------------------------------------------------------------------
 *
 * Used to execute a request to a public endpoint. Useful as a cross
 * domain proxy.
 *
 */

class Remote implements RemoteInterface
{
    private $result = null;

    /**
     * @var array
     */
    private $remoteOptions;

    /**
     * Remote constructor.
     *
     * @param array $remoteOptions Optional options to pass to cURL
     */
    public function __construct(array $remoteOptions = [])
    {
        $this->remoteOptions = $remoteOptions;
    }

    /**
     * Execute a resource request (GET) to an endpoint.
     *
     * @param  string $url      Full URL of where to GET the request
     * @param  array  $data     Payload of request
     * @return $this            The instance of this class
     */
    public function get(string $url, array $data = []): RemoteInterface
    {
        $query = http_build_query($data);
        if (!empty($query)) {
            $url = (strpos($url, '?')) ? $url . '&' . $query : $url . '?' . $query;
        }

        $this->request($url);

        return $this;
    }

    /**
     * Execute a resource request (POST) to an endpoint.
     *
     * @param  string $url      Full URL of where to POST the request
     * @param  array  $data  Payload of request
     * @return $this            The instance of this class
     */
    public function post(string $url, array $data = []): RemoteInterface
    {
        $this->request($url, $data);

        return $this;
    }

    /**
     * Determine whether a header is an 'Expect' header.
     * @param string $header
     * @return bool
     */
    private function isExpectHeader(string $header): bool
    {
        return (stripos($header, 'expect:') === 0);
    }

    /**
     * Normalize the headers to be used for a request.
     *
     * @param array $headers - the array of headers. Each element is a string.
     *
     * @return array
     */
    private function normalizeRequestHeaders(array $headers): array
    {
        // Explicitly set an empty Expect header, so that the server will not
        // respond with a "100 Continue" status code for large uploads.
        $emptyExpectHeader = 'Expect: ';
        $haveExpectHeader = false;

        for ($i = 0; $i < count($headers); $i++) {
            if ($this->isExpectHeader($headers[$i])) {
                // There is already an expect header - let's set it to empty
                $headers[$i] = $emptyExpectHeader;
                $haveExpectHeader = true;
                break;
            }
        }

        if (!$haveExpectHeader) {
            // There is no expect header - let's add one
            $headers[] = $emptyExpectHeader;
        }

        return $headers;
    }

    /**
     * Makes a cURL request to an endpoint with an optional request
     * payload and cURL options.
     *
     * @param  string $url      Full URL of where to POST the request
     * @param  array  $post     Payload of request
     * @return void
     */
    public function request(string $url, array $post = [])
    {
        $defaults = [
            'connect_timeout'   => 10,
            'timeout'           => 40,
            'headers'           => [],
            'encoding'          => 'utf-8',
            'ssl_verify'        => true,
        ];

        $options = array_merge($defaults, $this->remoteOptions);

        // normalize the headers
        $options['headers'] = $this->normalizeRequestHeaders($options['headers']);

        $ch = curl_init();

        $params = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => $options['encoding'],
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => $options['connect_timeout'],
            CURLOPT_TIMEOUT        => $options['timeout'],
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_SSL_VERIFYPEER => $options['ssl_verify'],
        ];

        if (!empty($options['headers'])) {
            $params[CURLOPT_HTTPHEADER] = $options['headers'];
        }

        if (!empty($post)) {
            $params[CURLOPT_POST] = true;
            $params[CURLOPT_POSTFIELDS] = $post;
        }

        curl_setopt_array($ch, $params);

        $body          = curl_exec($ch);
        $error_code    = curl_errno($ch);
        $error_message = curl_error($ch);
        $response      = curl_getinfo($ch);

        curl_close($ch);

        $response['error_code']    = $error_code;
        $response['error_message'] = $error_message;
        $response['body']          = $body;

        $this->result = $response;
    }

    /**
     * Returns the body of the response payload as returned by the
     * URL endpoint
     *
     * @return string|bool Typically a JSON object
     */
    public function getBody()
    {
        return $this->result['body'];
    }

    /**
     * Returns an associative array detailing any errors that may
     * have been throwing during an endpoint request
     *
     * @return array
     */
    public function getError(): array
    {
        return [
            'code'    => $this->result['error_code'],
            'message' => $this->result['error_message'],
        ];
    }

    /**
     * Returns part of the response headers
     *
     * @param  string      $type Which key in the headers packet to return
     * @return string|null       Header from the response packet
     */
    public function getHeader(string $type = 'content_type')
    {
        return (array_key_exists($type, $this->result)) ? $this->result[$type] : null;
    }

    /**
     * Returns the size in bytes of the request body
     *
     * @param bool $format
     * @return mixed Formatted string or raw float (bytes)
     */
    public function getSize(bool $format = true)
    {
        if ($format) {
            return Conversion::formatSizeUnits((float)$this->result['size_download']);
        }
        return (float)$this->result['size_download'];
    }

    /**
     * The HTTP status code of the request response
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return (int)$this->result['http_code'];
    }

    /**
     * Total transaction time in seconds for last transfer
     *
     * @return float
     */
    public function getTimeTaken(): float
    {
        return (float)$this->result['total_time'];
    }

    /**
     * Returns a decoded JSON array
     *
     * @param  boolean $assoc   Whether to return an associative array or object
     * @return mixed            Either a PHP associative array or object
     */
    public function json(bool $assoc = true)
    {
        return json_decode($this->getBody(), $assoc);
    }
}
