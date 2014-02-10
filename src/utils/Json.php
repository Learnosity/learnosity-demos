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

    /**
     * Pretty JSON formatter. Used as this has to support PHP 5.3
     * See http://snipplr.com/view.php?codeview&id=60559
     */
    public static function prettyJSON($json)
    {
        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = '  ';
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;

        for ($i=0; $i<=$strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;

                // If this character is the end of an element,
                // output a new line and indent the next line.
            } else if (($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos --;
                for ($j=0; $j<$pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            $prevChar = $char;
        }

        return $result;
    }
}
