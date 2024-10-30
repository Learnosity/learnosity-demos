<?php

namespace LearnositySdk\Services\PreHashStrings;

interface PreHashStringInterface
{
    /* Generate a string ready to be signed
     * @param array $security
     * @param array|null $request
     * @param string|null $action
     * @param string|null $secret only for legacy pre-hash string generation when $v1Compat is true
     * @return string the pre-hash string
     */
    public function getPreHashString(array $security, $request, ?string $action, ?string $secret): string;

    /** Return a list of all supported services
     * @return string[]
     */
    public static function getSupportedServices(): array;

    /** Return true if the service is supported
     * @param string $service
     * @return bool
     */
    public static function supportsService(string $service): bool;

    /** Validate a request to be signed, and return a potentially modified request
     * @param array $security
     * @return array <$updatedRequest, $updatedSecurity>
     * */
    public function validate(array $security): array;
}
