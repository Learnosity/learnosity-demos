<?php

namespace LearnositySdk\Services;

use LearnositySdk\Services\Signatures\SignatureInterface;
use LearnositySdk\Services\Signatures\HashSignature;
use LearnositySdk\Services\Signatures\HmacSignature;

class SignatureFactory
{
    /**
     * @param string $version
     * @return SignatureInterface
     * @throws \Exception
     */
    public function getSignatureGenerator(string $version): SignatureInterface
    {
        switch ($version) {
            case HashSignature::SIGNATURE_VERSION:
                $signatureInstance = new HashSignature();
                break;
            default:
                $signatureInstance = new HmacSignature();
        }

        return $signatureInstance;
    }

    /**
     * @param string $signature
     * @return string
     */
    public function getSignatureVersion(string $signature): string
    {
        return $signature[0] === '$' ?
            HmacSignature::SIGNATURE_VERSION : HashSignature::SIGNATURE_VERSION;
    }
}
