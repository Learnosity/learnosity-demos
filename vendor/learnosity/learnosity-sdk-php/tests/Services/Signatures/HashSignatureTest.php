<?php

namespace LearnositySdk\Services\Signatures;

use LearnositySdk\AbstractTestCase;
use LearnositySdk\Exceptions\ValidationException;

class HashSignatureTest extends AbstractTestCase
{
    /**
     * @var \LearnositySdk\Services\Signatures\HashSignature
     */
    private $hashSignature;

    public function setUp(): void
    {
        $this->hashSignature = new HashSignature();
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
        $generatedResult = $this->hashSignature->validateParameterLengths(
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
                'ca2769c4be77037cf22e0f7a2291fe48c470ac6db2f45520a259907370eff861',
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

        $generatedResult = $this->hashSignature->sign($preHashString, $secretKey);
        $this->assertEquals($expectedResult, $generatedResult);
    }

    public function signProvider(): array
    {
        return [
            [
                'test_pre_hash_string_fakesecretkey',
                'fakesecretkey',
                '7c458bc183a806a329418259f0e1b2fda23b849b81f305aaa806c75fbd75c4c3',
                null,
                null
            ],
            [
                'test_pre_hash_string_with_no_secret_key',
                'fakesecretkey',
                null,
                ValidationException::class,
                'The pre hash string for this signature type must contain the secret key'
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
        $returnedVersion = $this->hashSignature->getVersion();

        $this->assertEquals($expectedVersion === $returnedVersion, $result);
    }

    public function getVersionProvider(): array
    {
        return [
            ['01', true],
            ['02', false]
        ];
    }
}
