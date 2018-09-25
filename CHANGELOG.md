# Changelog

All notable changes to `laravel-postmark-webhooks` will be documented in this file.

## [Unreleased]

## [1.2.0] - 2018-09-25

### Added
- Added event mapping. [`bd52ccc`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/bd52ccc6d421eb87354018df8d3b23d383c51fc7)

### Changed
- Code refactor. [`f438b3a`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/f438b3a0e4fe0eb5f05e6e79fc63d7f76de8e990)

## [1.1.0] - 2018-09-24

### Added

- Added an option to exclude event types from being logged to the database. [`49a886d`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/49a886d92de276d146b6c06120b7ab1437bab55b)
- Added an option to make the Eloquent model being used configurable. [`7395bee`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/7395beed7f57a1a1961c535be1d197d108d4425a)
- Added an option to disable logging to the database. [`04a3b32`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/04a3b3219174bdd03333e214c03c88b33e5a66de)
- Added an option to make the database table being used configurable. [`480d288`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/480d288c5d3711964f7b2803632b2b3621041544)

### Changed
- Changes PostmarkWebhookLog class to PostmarkWebhook. [`789b9af`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/789b9af41466bd0290ba5f44ba65d9bd7ee55ed8)

## [1.0.0] - 2018-09-22

### Added
- Added dispatching of different event types. [`6a90992`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/6a9099266e8b71e565d3bedb6e171c09b6a8387f)
- Added the email address to the events and to the logs table. [`ba94bfa`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/ba94bfa9ad09d1cf7eff0cff946b65ae8122fd6a)

## [0.2.1] - 2018-09-22

### Added 
- Added 127.0.0.1 to trusted IPs. [`edada5f`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/edada5f22a718a7f6c76ffe559c21fbc2ca8155d)

## [0.2.0] - 2018-09-22

### Changed
- Changed the database schema for the `postmark_webhook_logs` table. [`815e2cf`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/815e2cfd48d1f279925f36e2b877eee7c9346ac6)

## [0.1.0] - 2018-09-22

### Pre-release

[Unreleased]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.2.0...HEAD
[1.2.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v0.2.0...v1.0.0
[0.2.1]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v0.2.0...v0.2.1
[0.2.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/tree/v0.1.0
