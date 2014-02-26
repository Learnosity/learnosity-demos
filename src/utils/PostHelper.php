<?php

/*
|--------------------------------------------------------------------------
| PostHelper.php
|--------------------------------------------------------------------------
|
| Used to proxy cross-domain XHR requests, specific to Learnosity's
| API convention.
|
*/

class PostHelper
{
    /*
    |--------------------------------------------------------------------------
    | Set debug mode
    |--------------------------------------------------------------------------
    |
    | If debugging is enabled, the script will output the parameters sent
    | to the endpoint and the headers returned
    |
    */
    protected $debug = false;

    /**
     * Execute a resource request (POST) to an endpoint
     * @param  array $security  Security consumer credentials including secret
     * @param  string $resource Full URL of where to POST the request
     * @param  array  $data     Payload of request
     * @param  string $action   Can be used for the Data API (get|set|update)
     * @param  bool   $debug    Whether to output more information about the request
     * @return string           The response string
     */
    public function execute($security, $resource, $data = [], $action = 'get', $debug = null)
    {
        if (!empty($debug) && is_bool($debug)) {
            $this->debug = $debug;
        }

        $data = json_encode($data);
        $security['signature'] = $this->generateSignature($security, $data, $action);

        $request = [
            'request'  => $data,
            'security' => json_encode($security),
            'action'   => $action
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $resource);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        if ($this->debug) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }
        $curl_response = curl_exec($ch);
        curl_close($ch);

        if (($curl_response)) {
            if ($this->debug) {
                $response = list($headers, $content) = explode("\r\n\r\n", $curl_response, 2);
                if ($this->debug) {
                    echo 'Parameters sent to: ' . $resource;
                    echo '<pre>';
                    echo $request;
                    echo '</pre>';

                    echo 'Response Headers: <br>';
                    print_r($response[0]);
                    echo '<br><br>';
                    echo 'Response Headers + Body: ';
                    var_dump($curl_response);

                    echo '<h3>Response:</h3>';
                }
                return $response[1];
            } else {
                return $curl_response;
            }
        } else {
            return 'Nothing returned';
        }
    }

    /**
     * Setup a digital signature to sign each API request with
     */
    private function generateSignature($security, $data, $action = 'get')
    {
        return hash(
            'sha256',
            $security['consumer_key'] . '_' .
            $security['domain'] . '_' .
            $security['timestamp'] . '_' .
            $security['consumer_secret'] . '_' .
            $data . '_' .
            $action
        );
    }
}
