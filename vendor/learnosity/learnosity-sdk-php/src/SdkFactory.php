<?php

namespace LearnositySdk;

use LearnositySdk\Exceptions\ValidationException;
use LearnositySdk\Request\Init;

class SdkFactory
{
    private const REQUIRED_ARGUMENTS = ['service', 'securityPacket', 'secret'];
    private const OPTIONAL_ARGUMENTS = ['requestPacket', 'action', 'signatureFactory'];


    /**
     * @param array $arguments
     * @return Init
     * @throws ValidationException
     */
    public function buildInit(array $arguments): Init
    {
        $optionalArgs = [];

        foreach (self::REQUIRED_ARGUMENTS as $key) {
            if (empty($arguments[$key])) {
                throw new ValidationException('Argument ' . $key . ' must be set');
            }
        }
        foreach (self::OPTIONAL_ARGUMENTS as $key) {
            $optionalArgs[$key] = $arguments[$key] ?? null;
        }

        return new Init(
            $arguments['service'],
            $arguments['securityPacket'],
            $arguments['secret'],
            $optionalArgs['requestPacket'],
            $optionalArgs['action'],
            $optionalArgs['signatureFactory']
        );
    }
}
