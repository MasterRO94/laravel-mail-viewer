# Changelog

All notable changes to `masterro/laravel-mail-viewer` are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project
adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.2.1] - 2026-08-04

### Fixed

- Duplicate email-verification listener → two verification emails per user registration.
  `MailViewerServiceProvider` extended Laravel's `Illuminate\Foundation\Support\Providers\EventServiceProvider`,
  whose `configureEmailVerification()` guard only inspects that provider's own `$listen` array. It
  therefore bound `Illuminate\Auth\Listeners\SendEmailVerificationNotification` a second time, on top
  of the one the host application already registered via `->withEvents()`, and that listener has no
  idempotency check. Any app with email verification enabled sent two emails per registration. The
  provider now extends `Illuminate\Support\ServiceProvider` and binds only its own `MessageSending`
  listener. No configuration or API changes; upgrading is enough.

## [3.2.0] - 2026-06-03

### Added

- Indexes on the `mail_logs` table
  ([#66](https://github.com/MasterRO94/laravel-mail-viewer/pull/66)).

### Fixed

- Config and route bugs
  ([#66](https://github.com/MasterRO94/laravel-mail-viewer/pull/66)).
- Email handling logic and database query compatibility
  ([#69](https://github.com/MasterRO94/laravel-mail-viewer/pull/69)).

## [3.1.0] - 2026-03-19

### Added

- Laravel 13.x compatibility
  ([#54](https://github.com/MasterRO94/laravel-mail-viewer/pull/54)).

## [3.0.0] - 2026-02-04

### Added

- Fresh UI with light and dark themes.
- Attachments download.
- Source code highlighting with [shiki](https://github.com/shikijs/shiki).
- Auto load of new entries.

### Changed

- Improved UX.

### Removed

- PHP 8.1 support.

## [3.0.0.beta.2] - 2025-04-10

### Added

- Auto load of new entries.

### Changed

- Updated tests and readme, plus small fixes.

## [3.0.0.beta] - 2025-04-04

### Added

- Fresh UI with light and dark themes.
- Attachments download.
- Source code highlighting with [shiki](https://github.com/shikijs/shiki).

### Changed

- Improved UX and various optimizations.

### Removed

- PHP 8.1 support.

## [2.4.0] - 2025-02-23

### Added

- Laravel 12 and PHP 8.4 support.

## [2.3.1] - 2024-04-02

### Added

- Support for `doctrine/dbal` 4.

## [2.3.0] - 2024-03-22

### Added

- Laravel 11 support
  ([#21](https://github.com/MasterRO94/laravel-mail-viewer/pull/21)).

## [2.2.2] - 2023-02-15

### Fixed

- PHPUnit 10 configuration.

## [2.2.1] - 2023-02-15

### Added

- Laravel 9 support restored after it was removed.

### Fixed

- Migration default value for the `payload` text column.
- PHPUnit 10 tests.

## [2.2.0] - 2023-02-03

### Added

- Laravel 10 support.

## [2.1.0] - 2022-08-01

### Added

- Config option to set the date timezone.

## [2.0.5] - 2022-02-22

### Added

- Ability to define a header link to follow.

## [2.0.4] - 2022-02-17

### Fixed

- Assorted bug fixes.

## [2.0.3] - 2022-02-17

### Fixed

- Ship production assets in the build.

## [2.0.2] - 2022-02-17

### Fixed

- Migrations.

## [2.0.1] - 2022-02-17

### Added

- Laravel 9.1 support.

## [2.0.0] - 2022-02-17

### Added

- Laravel 9 support.
- Tests.

### Changed

- Updated UI and rewrote the logic almost from scratch.

## [1.3.4] - 2022-02-17

### Added

- Notice that a new version is available.

## [1.3.3] - 2021-04-09

### Fixed

- Log record created with empty fields on newer Laravel versions when a connection is specified
  (fillable/guarded attribute handling).

## [1.3.2] - 2020-09-09

### Added

- Laravel 8 support.
- `mail-viewer:publish` command.

## [1.3.1] - 2020-07-22

### Changed

- Split the action returning a view or JSON into two separate actions.

### Fixed

- Config key for the URI prefix.

## [1.2.1] - 2020-03-04

### Fixed

- Laravel 7 support.

## [1.2.0] - 2020-03-02

### Added

- Laravel 7 support.

### Changed

- Main section styles now use fixed positioning.

## [1.1.1] - 2019-11-29

### Fixed

- Laravel 6+ support.

## [1.1.0] - 2019-09-01

### Added

- Laravel 6 support.
- Ability to define a database connection.

## [1.0.1] - 2019-05-28

### Fixed

- Assorted fixes.

## [1.0.0] - 2019-03-05

### Added

- Laravel 5.8 support.

## [0.1.0] - 2019-02-10

### Added

- Refresh emails.
- Filter emails by all fields (from, to, cc, bcc, subject, body).

## [0.0.1-alpha5] - 2018-09-26

### Added

- Laravel 5.7 support.

## [0.0.1-alpha4] - 2018-05-18

### Added

- Cc and Bcc displayed on the view page when present.

## [0.0.1-alpha3] - 2018-02-21

### Added

- Laravel 5.6 support.

## [0.0.1-alpha2] - 2018-01-16

### Added

- "No emails logged." message when the log table is empty.

## [0.0.1-alpha] - 2018-01-16

### Added

- First draft release.

[3.2.1]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v3.2.0...v3.2.1
[3.2.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v3.1.0...v3.2.0
[3.1.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v3.0.0...v3.1.0
[3.0.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.4.0...v3.0.0
[3.0.0.beta.2]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v3.0.0.beta...v3.0.0.beta.2
[3.0.0.beta]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.4.0...v3.0.0.beta
[2.4.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.3.1...v2.4.0
[2.3.1]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.3.0...v2.3.1
[2.3.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.2.2...v2.3.0
[2.2.2]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.2.1...v2.2.2
[2.2.1]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.2.0...v2.2.1
[2.2.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.1.0...v2.2.0
[2.1.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.0.5...v2.1.0
[2.0.5]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.0.4...v2.0.5
[2.0.4]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.0.3...v2.0.4
[2.0.3]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.0.2...v2.0.3
[2.0.2]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.0.1...v2.0.2
[2.0.1]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v2.0.0...v2.0.1
[2.0.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v1.3.4...v2.0.0
[1.3.4]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v1.3.3...v1.3.4
[1.3.3]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v1.3.2...v1.3.3
[1.3.2]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v1.3.1...v1.3.2
[1.3.1]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v1.2.1...v1.3.1
[1.2.1]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v1.2.0...v1.2.1
[1.2.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v1.1.1...v1.2.0
[1.1.1]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v1.1.0...v1.1.1
[1.1.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v1.0.1...v1.1.0
[1.0.1]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v0.1.0...v1.0.0
[0.1.0]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v0.0.1-alpha5...v0.1.0
[0.0.1-alpha5]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v0.0.1-alpha4...v0.0.1-alpha5
[0.0.1-alpha4]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v0.0.1-alpha3...v0.0.1-alpha4
[0.0.1-alpha3]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v0.0.1-alpha2...v0.0.1-alpha3
[0.0.1-alpha2]: https://github.com/MasterRO94/laravel-mail-viewer/compare/v0.0.1-alpha...v0.0.1-alpha2
[0.0.1-alpha]: https://github.com/MasterRO94/laravel-mail-viewer/releases/tag/v0.0.1-alpha
