<?php

/**
 * Signature Utils to make generating the signature simpler
 */

class SignatureUtils
{
    // v1 - Questions API Signature
    // v2 - SSO signature
    // v3 - Items signature - keys encapsulated in security block

    /**
    * Sign a Learnosity API request
    */
    public static function signRequest($request, $consumer_secret, $version)
    {
        $signedRequest = $request;
        $signature = "";
        switch($version) {
            case "sso":
                $signature = SignatureUtils::generateSSOSignature($request,$consumer_secret);
                $signedRequest['signature'] = $signature;
                break;
            case "items":
                $signature = SignatureUtils::generateItemsSignature($request,$consumer_secret);
                $signedRequest['security']['signature'] = $signature;
                break;
            case "v1":
                $signature = SignatureUtils::generateV1Signature($request,$consumer_secret);
                $signedRequest['security']['signature'] = $signature;
                break;
            case "questions":
                //TODO: Implement this.
                break;
        }
        return $signedRequest;
    }

    private static function generateItemsSignature($objectToSign, $consumer_secret)
    {
        $concatenatedString = SignatureUtils::generatItemsPreHashString($objectToSign, $consumer_secret);
        return hash('sha256', $concatenatedString);
    }

    private static function generatItemsPreHashString($objectToSign, $consumer_secret)
    {
        //Check we have a security block & consumer secret
        if(! isset($objectToSign['security']) || !count($objectToSign['security'])) throw new InvalidArgumentException("Security block does not exist");
        if(! isset($consumer_secret) || !strlen($consumer_secret)) throw new InvalidArgumentException("consumer_secret was not passed in or was empty");

        //Loop through required keys in signature block
        $signatureKeys = array('consumer_key', 'timestamp','user_id','domain');

        foreach ($signatureKeys as $key) {
            //Check key exists
            if(! isset($objectToSign['security'][$key]) || !strlen($objectToSign['security'][$key])) throw new InvalidArgumentException("Signature block does not contain required key or key was empty:".$key);

            //Set key to local variable
            ${$key} = $objectToSign['security'][$key];

            // Remove above attributes from JSON before hashing
            unset($objectToSign['security'][$key]);
        }

        // Create String to Hash
        $preHashString = $consumer_key . '_' . $domain . '_' . $timestamp . '_' . $user_id . '_' . $consumer_secret;

        // Append hashing of all other attributes in JSON using auxiliary function
        $preHashString .= "_" . SignatureUtils::arrayToStringForSignature($objectToSign);

        // Return Concatenated String
        return $preHashString;
    }

    private static function generateSsoSignature($jsonArray, $consumer_secret)
    {
        $concatenatedString = SignatureUtils::generateSsoPreHashString($jsonArray, $consumer_secret);
        return hash('sha256', $concatenatedString);
    }

    private static function generateSsoPreHashString($jsonArray, $consumer_secret)
    {
        // Concatenate String
        // Retrieve required parameters from JSON
        $consumer_key = $jsonArray['consumer_key'];
        $timestamp = $jsonArray['timestamp'];
        $user_id = $jsonArray['user_id'];
        $domain = $jsonArray['domain'];

        // Create String to Hash
        $preHashString = $consumer_key . '_' . $domain . '_' . $timestamp . '_' . $user_id . '_' . $consumer_secret;

        // Remove above attributes from JSON before hashing
        unset($jsonArray['consumer_key']);
        unset($jsonArray['timestamp']);
        unset($jsonArray['user_id']);
        unset($jsonArray['domain']);

        // Append hashing of all other attributes in JSON using auxiliary function
        $preHashString .= "_" . SignatureUtils::arrayToStringForSignature($jsonArray);

        // Return Concatenated String
        return $preHashString;
    }


    private static function generateV1Signature($objectToSign, $consumer_secret)
    {
        $concatenatedString = SignatureUtils::generatV1PreHashString($objectToSign, $consumer_secret);
        return hash('sha256', $concatenatedString);
    }

    private static function generatV1PreHashString($objectToSign, $consumer_secret)
    {
        //Check we have a security block & consumer secret
        if(! isset($objectToSign['security']) || !count($objectToSign['security'])) throw new InvalidArgumentException("Security block does not exist");
        if(! isset($consumer_secret) || !strlen($consumer_secret)) throw new InvalidArgumentException("consumer_secret was not passed in or was empty");

        //Loop through required keys in signature block
        $signatureKeys = array('consumer_key', 'timestamp','user_id','domain');

        foreach ($signatureKeys as $key) {
            //Check key exists
            if(! isset($objectToSign['security'][$key]) || !strlen($objectToSign['security'][$key])) throw new InvalidArgumentException("Signature block does not contain required key or key was empty:".$key);

            //Set key to local variable
            ${$key} = $objectToSign['security'][$key];

            // Remove above attributes from JSON before hashing
            unset($objectToSign['security'][$key]);
        }

        // Create String to Hash
        $preHashString = $consumer_key . '_' . $domain . '_' . $timestamp . '_' . $user_id . '_' . $consumer_secret;

        // Return Concatenated String
        return $preHashString;
    }


    private static function arrayToStringForSignature($array)
    {
        $toReturn = "";
        ksort($array,SORT_STRING);
        foreach ($array as $key => $value) {
            if (strlen($toReturn) > 0) {
                $toReturn .= "_";
            }
            if (is_array($value)) {
                $toReturn .= $key . "_" . SignatureUtils::arrayToStringForSignature($value);
            } else {
                $toReturn .= $key . "_" . $value;
            }
        }
        return $toReturn;
    }
}
