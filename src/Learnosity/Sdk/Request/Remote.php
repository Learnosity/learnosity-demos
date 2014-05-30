<?php

/**
 *--------------------------------------------------------------------------
 * Learnosity SDK - Remote
 *--------------------------------------------------------------------------
 *
 * Used to execute a request to a public endpoint. Useful as a cross
 * domain proxy.
 *
 * @version v0.1.0
 * @link https://github.com/Learnosity/sdk-learnosity-php
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * Usage - https://github.com/Learnosity/sdk-learnosity-php
 *
 * Requires `Learnosity` to be in the include or autoload path, eg:
 *   set_include_path('/path/to/Learnosity/parent/' . PATH_SEPARATOR . get_include_path());
 *
 */

class Remote
{
    /**
     * Execute a resource request (GET) to an endpoint. Useful as a
     * cross-domain proxy.
     *
     * @param  string $url      Full URL of where to POST the request
     * @param  array  $request  Payload of request
     * @param  bool   $format   Whether to format the response
     * @param  bool   $options  Optional Curl options
     *
     * @return string           The response string
     */
    public function get($url, $data = array(), $format = false, $options = array(), $contentOnly = true)
    {
        $query = http_build_query($data);
        if (!empty($query)) {
            $url = (strpos($url, '?')) ? $url . '&' . $query : $url . '?' . $query;
        }

        $response = $this->request($url, false, $options);

        if ($response['error'] !== 0) {
            return $response;
        } else {
            if (empty($format)) {
                return ($contentOnly) ? $response['content'] : $response;
            } else {
                return $this->format($response['content'], $format);
            }
        }
    }

    /**
     * Execute a resource request (POST) to an endpoint. Useful as a
     * cross-domain proxy.
     *
     * @param  string $url      Full URL of where to POST the request
     * @param  array  $request  Payload of request
     * @param  bool   $format   Whether to format the response
     * @param  bool   $options  Optional Curl options
     *
     * @return string           The response string
     */
    public function post($url, $data = array(), $format = false, $options = array(), $contentOnly = true)
    {
        $response =  $this->request($url, $data, $options);

        if ($response['error'] !== 0) {
            return $response;
        } else {
            if (empty($format)) {
                return ($contentOnly) ? $response['content'] : $response;
            } else {
                return $this->format($response['content'], $format);
            }
        }
    }

    private function request($url, $post = false, $options = array())
    {
        $defaults = array(
            'timeout'  => 10,
            'headers'  => array(),
            'encoding' => 'utf-8'
        );

        $options = array_merge($defaults, $options);
        $ch = curl_init();

        $params = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => $options['encoding'],
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => $options['timeout'],
            CURLOPT_TIMEOUT        => $options['timeout'],
            CURLOPT_MAXREDIRS      => 10
        );

        if (!empty($options['headers'])) {
            $params[CURLOPT_HTTPHEADER] = $options['headers'];
        }

        if (!empty($post)) {
            $params[CURLOPT_POST] = true;
            $params[CURLOPT_POSTFIELDS] = $post;
        }

        curl_setopt_array($ch, $params);

        $content  = curl_exec($ch);
        $error    = curl_errno($ch);
        $message  = curl_error($ch);
        $response = curl_getinfo($ch);

        curl_close($ch);

        $response['error']   = $error;
        $response['message'] = $message;
        $response['content'] = $content;

        return $response;
    }

    private function format($data, $format)
    {
        switch ($format) {
            case 'array':
                return json_decode($data, true);
                break;
            default:
                # no default
                break;
        }
    }
}
