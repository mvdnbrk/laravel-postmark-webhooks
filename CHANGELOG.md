# Changelog

All notable changes to `laravel-postmark-webhooks` will be documented in this file.

## [Unreleased]

## [v1.4.0] - 2020-03-07

### Added
- Added support for Laravel 7. [`#4`](https://github.com/mvdnbrk/laravel-postmark-webhooks/pull/4)

## [v1.3.2] - 2019-07-31

### Changed
- Updated version constraints to support Laravel 6. [`1bf3d5f`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/1bf3d5f4b26b912449dc6b409b372ae1300c8efa)

## [v1.3.1] - 2019-05-20
- No notable changes. Clean up the garden.

## [v1.3.0] - 2019-03-18

### Fixed
- Use table name if set on the model. [`da2aded`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/da2aded3b1058ccd79520f1959ae21cbc96504cf)

### Removed
- Removed use of `postmark-webhooks.log.table` config value, use `postmark-webhooks.log.table_name` instead. [`8d82e03`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/8d82e030ef9695ce21e96488bcff0fd3516d61a5)

## [v1.2.7] - 2019-03-17

### Changed
- Use Str::snake() directly. [`752adc2`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/752adc289dc85f22c5383fd1073d77e88d4531af)

### Fixed
- Use setTable(). [`452579c`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/452579c3de69e1f8d7c24445656b5f5f830d9276)

## [v1.2.6] - 2019-02-09

### Changed
- Updated docblock. [`b2ffd4b`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/b2ffd4b48604b8c75de9c142c4b207ff7943318d)

## [v1.2.5] - 2019-02-05

### Changed
- Changed config key `log.table` to `log.table_name` in `config/postmark-webhooks.php`. [`be76d4e`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/be76d4e8518efa55ae77acc326d46f901dae1305)

### Fixed
- Fixed missing backslash in `config/postmark-webhooks.php`. [`17e1b5d`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/17e1b5db4fd1c86583c2955b4bd10f987efe518d)

## [v1.2.4] - 2019-02-05

### Added
- Added ability to make the URI path configurable. [`1a26a5f`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/1a26a5ff5c1ab9c4647e2f75d2687b77fa21f04f)

## [v1.2.3] - 2019-02-05

### Added
- Added ability to publish database migrations. [`f23b07d`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/f23b07ded3fe3ee0f46914390f36715af9d6f0ed)

## [v1.2.2] - 2019-02-03

### Added
- Added support for Laravel 5.8. [`1fc71fe`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/1fc71fe2e30c38b48b797a3d96470a37e26338b7)

## [v1.2.1] - 2018-12-05

### Added
- Added new IP address used by Postmark. [`46ea22c`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/46ea22c6722de71c8ea62544080df64ace7534b7)

## [v1.2.0] - 2018-09-25

### Added
- Added event mapping. [`bd52ccc`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/bd52ccc6d421eb87354018df8d3b23d383c51fc7)

### Changed
- Code refactor. [`f438b3a`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/f438b3a0e4fe0eb5f05e6e79fc63d7f76de8e990)

## [v1.1.0] - 2018-09-24

### Added
- Added an option to exclude event types from being logged to the database. [`49a886d`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/49a886d92de276d146b6c06120b7ab1437bab55b)
- Added an option to make the Eloquent model being used configurable. [`7395bee`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/7395beed7f57a1a1961c535be1d197d108d4425a)
- Added an option to disable logging to the database. [`04a3b32`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/04a3b3219174bdd03333e214c03c88b33e5a66de)
- Added an option to make the database table being used configurable. [`480d288`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/480d288c5d3711964f7b2803632b2b3621041544)

### Changed
- Changed PostmarkWebhookLog class to PostmarkWebhook. [`789b9af`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/789b9af41466bd0290ba5f44ba65d9bd7ee55ed8)

## [v1.0.0] - 2018-09-22

### Added
- Added dispatching of different event types. [`6a90992`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/6a9099266e8b71e565d3bedb6e171c09b6a8387f)
- Added the email address to the events and to the logs table. [`ba94bfa`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/ba94bfa9ad09d1cf7eff0cff946b65ae8122fd6a)

## [v0.2.1] - 2018-09-22

### Added 
- Added 127.0.0.1 to trusted IPs. [`edada5f`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/edada5f22a718a7f6c76ffe559c21fbc2ca8155d)

## [v0.2.0] - 2018-09-22

### Changed
- Changed the database schema for the `postmark_webhook_logs` table. [`815e2cf`](https://github.com/mvdnbrk/laravel-postmark-webhooks/commit/815e2cfd48d1f279925f36e2b877eee7c9346ac6)

## [v0.1.0] - 2018-09-22

### Initial release

[Unreleased]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.4.0...HEAD
[v1.4.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.3.2...v1.4.0
[v1.3.2]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.3.1...v1.3.2
[v1.3.1]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.3.0...v1.3.1
[v1.3.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.2.7...v1.3.0
[v1.2.7]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.2.6...v1.2.7
[v1.2.6]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.2.5...v1.2.6
[v1.2.5]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.2.4...v1.2.5
[v1.2.4]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.2.3...v1.2.4
[v1.2.3]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.2.2...v1.2.3
[v1.2.2]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.2.1...v1.2.2
[v1.2.1]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.2.0...v1.2.1
[v1.2.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.1.0...v1.2.0
[v1.1.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v1.0.0...v1.1.0
[v1.0.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v0.2.0...v1.0.0
[v0.2.1]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v0.2.0...v0.2.1
[v0.2.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/compare/v0.1.0...v0.2.0
[v0.1.0]: https://github.com/mvdnbrk/laravel-postmark-webhooks/tree/v0.1.0
