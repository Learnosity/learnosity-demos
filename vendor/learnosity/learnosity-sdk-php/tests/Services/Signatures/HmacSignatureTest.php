<?php

namespace LearnositySdk\Services\Signatures;

use LearnositySdk\AbstractTestCase;
use LearnositySdk\Exceptions\ValidationException;

class HmacSignatureTest extends AbstractTestCase
{
    /**
     * @var \LearnositySdk\Services\Signatures\HmacSignature
     */
    private $hmacSignature;

    public function setUp(): void
    {
        $this->hmacSignature = new HmacSignature();
    }
    /**
     * @dataProvider validateParameterLengthsProvider
     */
    public function testValidateParameterLengths(
        string $consumerKey,
        string $timestamp,
        string $signature,
        bool $expectedResult
    ) {
        $generatedResult = $this->hmacSignature->validateParameterLengths(
            [
                'consumer_key' => $consumerKey,
                'timestamp' => $timestamp,
                'signature' => $signature
            ]
        );

        $this->assertEquals($expectedResult, $generatedResult);
    }

    public function validateParameterLengthsProvider(): array
    {
        return [
            ['1', '1', '1', true],
            [
                '1234567891234567',
                '1234567890123',
                '$02$ca2769c4be77037cf22e0f7a2291fe48c470ac6db2f45520a259907370eff861',
                false
            ]
        ];
    }

    /**
     * @dataProvider signProvider
     */
    public function testSign(
        string $preHashString,
        string $secretKey,
        ?string $expectedResult = null,
        $expectedException = null,
        ?string $expectedExceptionMessage = null
    ) {
        if (!empty($expectedException)) {
            $this->expectException($expectedException);
            $this->expectExceptionMessage($expectedExceptionMessage);
        }

        $generatedResult = $this->hmacSignature->sign($preHashString, $secretKey);
        $this->assertEquals($expectedResult, $generatedResult);
    }

    public function signProvider(): array
    {
        return [
            [
                'test_pre_hash_string_fakesecretkey',
                'fakesecretkey',
                null,
                ValidationException::class,
                'The pre hash string for this signature type must not contain the secret key'

            ],
            [
                'test_pre_hash_string_with_no_secret_key',
                'fakesecretkey',
                '$02$5f5ce16e00095c22544eb25a228cd210d5b9e8489fc3b98d709e1af92858f14c',
                null,
                null
            ]
        ];
    }

    /**
     * @dataProvider getVersionProvider
     */
    public function testGetVersion(
        string $expectedVersion,
        bool $result
    ) {
        $returnedVersion = $this->hmacSignature->getVersion();

        $this->assertEquals($expectedVersion === $returnedVersion, $result);
    }

    public function getVersionProvider(): array
    {
        return [
            ['02', true],
            ['01', false]
        ];
    }
}
