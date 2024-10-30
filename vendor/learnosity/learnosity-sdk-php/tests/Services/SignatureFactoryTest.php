<?php

namespace LearnositySdk\Services;

use LearnositySdk\AbstractTestCase;
use LearnositySdk\Services\Signatures\HashSignature;
use LearnositySdk\Services\Signatures\HmacSignature;

class SignatureFactoryTest extends AbstractTestCase
{
    /**
     * @dataProvider getSignatureGeneratorProvider
     */
    public function testGetSignatureGenerator(
        string $version,
        string $instance
    ) {
        $signatureFactory = new SignatureFactory();
        $returnedInstance = $signatureFactory->getSignatureGenerator($version);

        $this->assertInstanceOf($instance, $returnedInstance);
    }

    public function getSignatureGeneratorProvider(): array
    {
        return [
            ['01', HashSignature::class],
            ['02', HmacSignature::class]
        ];
    }

    /**
     * @dataProvider getSignatureVersionProvider
     */
    public function testGetSignatureVersion(
        string $signature,
        string $version
    ) {
        $signatureFactory = new SignatureFactory();
        $returnedVersion = $signatureFactory->getSignatureVersion($signature);

        $this->assertEquals($version, $returnedVersion);
    }

    public function getSignatureVersionProvider(): array
    {
        return [
            ['12345uytrewsdfgh', '01'],
            ['$02$12345uytrewsdfgh', '02']
        ];
    }
}
