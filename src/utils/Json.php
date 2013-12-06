<?php

class Json
{
    public static function encode($array)
    {
        $result = false;
        if (version_compare(PHP_VERSION, '5.4', '>=')) {
            $result = json_encode($array, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        } else {
            $result = json_encode($array);

            // Unicode fix: http://stackoverflow.com/a/2934602
            $result = preg_replace_callback(
                '/\\\\u([0-9a-f]{4})/i',
                function ($match) {
                    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
                },
                $result
            );
            // Escaped slashes fix
            $result = str_replace('\/', '/', $result);
        }

        return $result;
    }
}
