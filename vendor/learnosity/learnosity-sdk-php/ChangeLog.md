# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic
Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [v1.0.5] - 2024-10-14
### Fixed
- Fixed the signature mismatch issue.
- Fixed the issue while running the 'make quickstart'
- Fixed an inconsistency with encoding to JSON
- Fixed incorrect replacement of SERVICE_ITEMS_API by SERVICE_EVENTS_API
  in services not requiring `user_id` in the security packet
- Fixed handling of `user_id` in security packet for services not
  requiring it

## [v1.0.4] - 2024-07-11
### Added
- Added composable services for signature generation.

### Refactor
- Refactored the signature generation to use composable services.

## [v1.0.3] - 2024-04-07
### Added
- Rename author-aide to authoraide
- Support author aide

## [v1.0.2] - 2023-07-03
### Added
- PHP 7.1 is now the minimum supported version.

## [v1.0.1] - 2023-06-28
### Added
- PSR-4 compliance

### Security
- Upgraded signature to match the security standard.

## [v1.0.0] - 2021-06-01
### Added
- PHP 7 to PHP 8 are supported.
- PHPUnit 6 to PHPUnit 9 are supported.
- Improved unit and integration test coverage.

### Removed
- PHP 5.6 support, PHP 7.0 is now the minimum supported version.

### Fixed
- Fixed a bug with `DataApi::requestRecursive` where it would overwrite output data unintentionally.

## [v0.10.3] - 2019-12-19
### Fixed
- Fixed the version range of the `random_compat` library
- Fixed a bug where `null` or empty string request packets would cause an exception to be thrown when calling the `Init` constructor.

## [v0.10.2] - 2019-07-29
### Fixed
- Prevent `meta` field of `$requestPacket`, which might contain information like user details for the audit trail, from being overwritten when SDK Telemetry is enabled.

## [v0.10.1] - 2019-05-06
### Fixed
- `DataApi::request*`: default `$requestPacket` to `[]` rather than `null`,
    which would cause cryptic errors if no packet is specified. Additionally, a
    warning is provided if the `$requestPacket` is not a PHP array.

## [v0.10.0] - 2018-09-17
### Added
- Telemetry support
- This ChangeLog!
