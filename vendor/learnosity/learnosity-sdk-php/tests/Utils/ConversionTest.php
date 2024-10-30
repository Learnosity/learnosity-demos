<?php

namespace tests\LearnositySdk\Utils;

use LearnositySdk\AbstractTestCase;
use LearnositySdk\Utils\Conversion;

class ConversionTest extends AbstractTestCase
{
    public function dataProviderFormatSizeUnits()
    {
        $base = 1024;
        $pow2 = pow($base, 2);
        $pow3 = pow($base, 3);

        return [
            [0, '0 bytes'],
            [1, '1 byte'],
            [$base - 1, '1023 bytes'],
            [$base, '1.00 KB'],
            [$pow2 - 1, '1,024.00 KB'],
            [$pow2, '1.00 MB'],
            [$pow3 - 1, '1,024.00 MB'],
            [$pow3, '1.00 GB'],
            [213123123, '203.25 MB'],
            [21312312390, '19.85 GB']
        ];
    }

    /**
     * @dataProvider dataProviderFormatSizeUnits
     */
    public function testFormatSizeUnits($bytes, $expectedResult)
    {
        $result = Conversion::formatSizeUnits($bytes);
        $this->assertEquals($expectedResult, $result);
    }
}
