<?php

namespace LearnositySdk\Utils;

class Json
{
    /**
     * Returns the last error, if relevant, from calls to json_encode()
     *
     * @return string Message detailing the last json_encode error
     */
    public static function checkError()
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $msg = null;
                break;
            case JSON_ERROR_DEPTH:
                $msg = 'Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $msg = 'Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $msg = 'Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $msg = 'Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $msg = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $msg = 'Unknown error';
                break;
        }
        return $msg;
    }

    /**
     * Encodes a PHP array into a JSON string. Has settings
     * to unescape both slashes and unicode characters.
     *
     * @param  array|null  $array Value to convert to JSON
     *
     * @return string JSON encoded string
     */
    public static function encode($array, array $options = [])
    {
        if (is_null($array)) {
            return null;
        }

        $highPrecisionFloatMap = static::getHighPrecisionFloatMap($array);

        $jsonOptions = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
        if (!empty($options)) {
            foreach ($options as $o) {
                $jsonOptions += $o;
            }
        }

        $result = json_encode($array, (int)$jsonOptions);

        foreach ($highPrecisionFloatMap as $scientificValueString => $floatValueString) {
            // Replace all scientific values by equivalent floatValues
            $result = str_ireplace($scientificValueString, $floatValueString, $result);
        }

        return $result;
    }

    /**
     * Returns whether the string value is valid JSON
     *
     * @param string $val A string value to test
     *
     * @return boolean
     */
    public static function isJson(string $val): bool
    {
        return !is_null(json_decode($val, true));
    }

    /**
     * This function builds up a map of float values in scientific notation and the equivalent float
     * notations. json_encode encodes float values in scientific notation, but we want to make sure
     * they are in float notation
     *
     * @param array|float $value the $json to be encoded
     * @return array mapping scientific values to float values
     */
    private static function getHighPrecisionFloatMap($value): array
    {
        if (!is_array($value)) {
            if (!is_float($value)) {
                return [];
            } else {
                return static::getFloatMap($value);
            }
        }

        $floatMap = [];
        foreach ($value as $entry) {
            $floatMap = array_merge(static::getHighPrecisionFloatMap($entry), $floatMap);
        }
        return $floatMap;
    }

    /**
     * Helper function to build up the float map
     *
     * @param float $value
     * @return array
     */
    private static function getFloatMap(float $value): array
    {
        $stringValue = json_encode($value);

        // If the string value is in scientific notation it should have a negative exponent. Split it there.
        $explodedValue = explode('E-', strtoupper($stringValue));
        if (count($explodedValue) === 2) {
            // The second entry tells us how many decimal places are created via the exponent
            $decimalsFromExponent = (int)$explodedValue[1];

            // The base hase the form x.xxxxx where x is any digit. We need to get the number of decimals after
            // the dot
            $decimalsFromBase = 0;
            $explodedBase = explode('.', $explodedValue[0]);
            if (count($explodedBase) === 2) {
                $decimalsFromBase = strlen($explodedBase[1]);
            }
            $totalDecimals = $decimalsFromBase + $decimalsFromExponent;
            $stringValueAsFloat = number_format($value, $totalDecimals);
            return [
                $stringValue => $stringValueAsFloat
            ];
        }
        return [];
    }
}
