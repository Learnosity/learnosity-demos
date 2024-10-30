<?php

namespace LearnositySdk\Services;

use LearnositySdk\Exceptions\ValidationException;
use LearnositySdk\Services\PreHashStrings\PreHashStringInterface;
use LearnositySdk\Services\PreHashStrings\LegacyPreHashString;

class PreHashStringFactory
{
    protected const PRE_HASH_STRING_GENERATORS = [
        /* Add newer services at the top, so they are chosen in priority */
        LegacyPreHashString::class,
    ];

    /**
     * @var array
     */
    protected /* array */ $validServices;

    public function __construct()
    {
        $this->validServices = $this->buildValidServices(static::PRE_HASH_STRING_GENERATORS);
    }

    protected function buildValidServices(array $preHashStringGenerators): array
    {
        $validServices = [];

        foreach ($preHashStringGenerators as $preHashStringGenerator) {
            $validServices = array_merge($validServices, $preHashStringGenerator::getSupportedServices());
        }

        return $validServices;
    }

    public function getValidServices(): array
    {
        return $this->validServices;
    }

    /**
     * @param string $service
     * @param string $v1Compat whether a legacy pre-hash string for v1 signature format should be created
     * @return PreHashStringInterface
     * @throws \Exception
     */
    public function getPreHashStringGenerator(string $service, bool $v1Compat = false): PreHashStringInterface
    {
        if (empty($service)) {
            throw new ValidationException('The `service` argument wasn\'t found or was empty');
        }
        $service = strtolower($service);

        foreach (static::PRE_HASH_STRING_GENERATORS as $preHashStringGenerator) {
            if ($preHashStringGenerator::supportsService($service)) {
                return new $preHashStringGenerator($service, $v1Compat);
            }
        }
        throw new ValidationException("The service provided ($service) is not valid");
    }
}
