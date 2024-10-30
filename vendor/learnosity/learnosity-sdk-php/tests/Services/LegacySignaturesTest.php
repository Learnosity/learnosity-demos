<?php

namespace LearnositySdk\Services;

use LearnositySdk\AbstractTestCase; // XXX: should be in a Test namespace
use LearnositySdk\Fixtures\ParamsFixture; // XXX: should be in a Test namespace
use LearnositySdk\Services\PreHashStrings\LegacyPreHashString;
use LearnositySdk\Services\SignatureFactory;
use LearnositySdk\Services\Signatures\HashSignature;
use LearnositySdk\Services\Signatures\HmacSignature;

class LegacySignaturesTest extends AbstractTestCase
{
    /**
     * @var SignatureFactory
     */
    private /* SignatureFactory */ $signatureFactory;

    public function setUp(): void
    {
        $this->signatureFactory = new SignatureFactory();
    }

    /** @dataProvider legacySignaturesProvider */
    public function testLegacySignatures(
        string $expectedSignature,
        string $signatureVersion,
        string $service,
        array $securityPacket,
        string $secret,
        array $requestPacket,
        ?string $action
    ) {
        $preHashStringGenerator = new LegacyPreHashString(
            $service,
            $signatureVersion == HashSignature::SIGNATURE_VERSION
        );
        $secretForPreHashString = $signatureVersion == HashSignature::SIGNATURE_VERSION
            ? $secret
            : null;
        $preHashString = $preHashStringGenerator->getPreHashString(
            $securityPacket,
            $requestPacket,
            $action,
            $secretForPreHashString
        );
        $signatureGenerator = $this->signatureFactory->getSignatureGenerator(
            $signatureVersion
        );

        $signature = $signatureGenerator->sign($preHashString, $secret);

        $this->assertEquals($expectedSignature, $signature);
    }

    /** @return array<
     *     string $expectedSignature,
     *     string $signatureVersion,
     *     string $service,
     *     array $securityPacket,
     *     string $secret,
     *     array $requestPacket,
     *     ?string $action
     * >
     */
    public function legacySignaturesProvider(): array
    {
        $testCases = [];

        foreach ([HashSignature::SIGNATURE_VERSION, HmacSignature::SIGNATURE_VERSION] as $signatureVersion) {
            foreach (LegacyPreHashString::getSupportedServices() as $service) {
                $expectedSig = ParamsFixture::getSignatureForService($service, $signatureVersion);

                if (empty($expectedSig)) {
                    /* The deprecation of this signature version predates the addition of this service */
                    continue;
                }

                $case = array_merge(
                    [
                        'expected' => $expectedSig,
                        'signatureVersion' => $signatureVersion,
                    ],
                    ParamsFixture::getWorkingParamsForService($service, true)
                );

                $testCases["sig-{$signatureVersion}_api-{$service}"] = $case;
            }
        }

        return $testCases;
    }
}
