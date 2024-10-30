<?php

namespace LearnositySdk\Services\Signatures;

use LearnositySdk\Exceptions\ValidationException;

interface SignatureInterface
{
    /**
     * @throws ValidationException
     */
    public function sign(
        string $preHashString,
        string $secretKey
    ): string;

    public function validateParameterLengths(array $security): bool;

    public function getVersion(): string;
}
