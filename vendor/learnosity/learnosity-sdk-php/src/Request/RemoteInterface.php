<?php

namespace LearnositySdk\Request;

interface RemoteInterface
{
    /**
     * Execute a resource request (GET) to an endpoint.
     *
     * @param  string $url      Full URL of where to GET the request
     * @param  array  $data     Payload of request
     * @return $this            The instance of this class
     */
    public function get(string $url, array $data = []): RemoteInterface;

    /**
     * Execute a resource request (POST) to an endpoint.
     *
     * @param  string $url      Full URL of where to POST the request
     * @param  array  $data  Payload of request
     * @return $this            The instance of this class
     */
    public function post(string $url, array $data = []): RemoteInterface;

    /**
     * Makes a cURL request to an endpoint with an optional request
     * payload and cURL options.
     *
     * @param  string $url      Full URL of where to POST the request
     * @param  array  $post     Payload of request
     * @return void
     */
    public function request(string $url, array $post = []);

    /**
     * Returns the body of the response payload as returned by the
     * URL endpoint
     *
     * @return string|bool Typically a JSON object
     */
    public function getBody();

    /**
     * Returns an associative array detailing any errors that may
     * have been throwing during an endpoint request
     *
     * @return array
     */
    public function getError(): array;

    /**
     * Returns part of the response headers
     *
     * @param  string      $type Which key in the headers packet to return
     * @return string|null       Header from the response packet
     */
    public function getHeader(string $type = 'content_type');

    /**
     * Returns the size in bytes of the request body
     *
     * @param bool $format
     * @return mixed Formatted string or raw float (bytes)
     */
    public function getSize(bool $format = true);

    /**
     * The HTTP status code of the request response
     *
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Total transaction time in seconds for last transfer
     *
     * @return float
     */
    public function getTimeTaken(): float;

    /**
     * Returns a decoded JSON array
     *
     * @param  boolean $assoc   Whether to return an associative array or object
     * @return mixed            Either a PHP associative array or object
     */
    public function json(bool $assoc = true);
}
