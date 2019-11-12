# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic
Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

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
