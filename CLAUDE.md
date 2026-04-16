# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

`masterro/laravel-mail-viewer` is a Laravel package that logs outgoing emails to the database and ships a Vue 3 SPA for viewing them. The package is consumed by host Laravel apps — it is not a standalone application. There is no `artisan` binary, no `.env`, and no runnable Laravel kernel in this repo; tests bootstrap a Laravel environment via Orchestra Testbench.

## Commands

### PHP / backend
- `composer install` — install PHP deps.
- `./vendor/bin/pest` (or `composer test`) — run the whole suite. Tests use Testbench + an in-memory SQLite DB.
- `./vendor/bin/pest tests/MailViewerTest.php` — run a single test file.
- `./vendor/bin/pest --filter "it receives mail log attachments"` — run a single test by name.
- CI matrix runs PHP 8.2–8.5 × `prefer-lowest`/`prefer-stable` (see `.github/workflows/tests.yml`). When changing deps, verify both stability modes locally with `composer update --prefer-lowest` / `--prefer-stable`.

### Frontend
- `npm run dev` — Vite dev server on `localhost:5173` (HMR). Append `?devMode` to the mail-viewer URL in a host app to load assets from the dev server instead of the built bundle (see `resources/views/mails/index.blade.php`).
- `npm run build` — production build into `public/assets/` (consumed by the host app via `vendor:publish`).
- `npm run build.dev` — same, with `NODE_ENV=dev`.
- `npm run lint` / `npm run lint.check` — ESLint (flat config, strict type-checked Vue/TS).
- `npm run format` / `npm run format.check` — Prettier.

### Consumer-facing artisan commands (defined by the package)
- `mail-viewer:publish [--views]` — publishes config + built assets (and optionally views) into the host app. Runs `vendor:publish` under the hood with the right tags.
- `mail-viewer:prune` — wrapper over `model:prune --model=MailLog` respecting `mail-viewer.prune_older_than_days`.

## Architecture

### Mail capture pipeline
1. `MailViewerServiceProvider` (extends Laravel's `EventServiceProvider`) registers a listener on `Illuminate\Mail\Events\MessageSending`.
2. `Listeners\LogMail` hands the `Symfony\Component\Mime\Email` message to `Services\Logger`.
3. `Logger` extracts subject, HTML/text bodies, the full raw RFC822 payload, and delegates parsing to `HeadersParser` and `AttachmentsParser` before persisting a `MailLog` row.
4. `MailLog` is created with `$unguarded = true`, `timestamps = false`, and casts `headers`/`attachments` to `array`. The table name and connection are read from config at construction time — **never hardcode `mail_logs`**, go through `config('mail-viewer.table')`.

Address fields (`to`/`cc`/`bcc`/`from`) are **not** columns — they are `Attribute` accessors that lazily parse the stored headers via `AddressParser`. They appear in `$appends`, so JSON responses include them. The old `from/to/cc/bcc` JSONB columns were dropped in the 2025_03_14 migration.

### HTTP surface
Routes in `resources/routes/web.php` are prefixed by `mail-viewer.uri_prefix` (default `_mail-viewer`) and wrapped in `mail-viewer.middleware` (default `['web']`). All routes point at `Controllers\MailController`:
- `GET /` → Blade shell (`mails.index`) that mounts the Vue app.
- `GET /emails` → paginated JSON feed (driven by `Services\Resource::fetch`, which uses cursor-style `oldestId`/`latestId` params, not offsets).
- `GET /stats` → counts per time bucket (today, yesterday, week, month, year, total), filtered by the configured retention window.
- `GET /emails/{mailLog}/payload|raw-payload|attachments` and `attachments/{fileName}` — payload inspection + attachment download. Attachments are re-parsed at request time from `payload` using `Opcodes\MailParser\Message`.

### Frontend (resources/js)
Vue 3 + TypeScript (strict), Vite 8, Tailwind 4 (via `@tailwindcss/vite`), Shiki for code highlighting, `flowbite-datepicker`. No Pinia — global state is a shared `reactive()` store in `store/index.ts` holding `initialized`, `activeEmail`, `payloads` cache, and `autoUpdateEnabled`.

- `@/` alias maps to `resources/js/`.
- `api/api.ts` builds URLs from `window.location` (`baseUrl`) and de-duplicates concurrent requests with keyed `AbortController`s — reuse `request()` rather than calling `fetch` directly.
- `components/` is split into `Sidebar` (list/filter/footer), `Main` (detail tabs: Preview, HtmlSource, Text, Headers, Attachments, Payload), `Common`, `Icons`, `Skeletons`. Custom directives live in `directives/` (`tw-merge`, `debounce`, `visibility`) and are registered globally in `app.ts`.

### Publishing model
The service provider declares three publish tags that `mail-viewer:publish` drives:
- `mail-viewer-config` → `config/mail-viewer.php`
- `mail-viewer-views` → `resources/views/vendor/mail-viewer`
- `mail-viewer-assets` (also tagged `laravel-assets`) → `public/vendor/mail-viewer`

The built Vue bundle lives in `public/assets/` and must be committed/built before release so that `vendor:publish` has something to copy into host apps.

## Conventions

- All PHP files use `declare(strict_types=1);` and are namespaced under `MasterRO\MailViewer\*`. Services are registered as `scoped` singletons and constructor-injected with promoted properties.
- Tests extend `MasterRO\MailViewer\Tests\BaseTestCase` via Pest's `pest()->extend(...)` in `tests/Pest.php`. `BaseTestCase::sendTestEmails()` is the idiomatic way to fabricate log rows; test mailables live in `tests/TestObjects/` and fixtures (images, PDFs, blade views) in `tests/Fixtures/`.
- Prettier enforces 2-space indent, single quotes, semicolons, `printWidth: 150`, with `prettier-plugin-organize-imports` and `prettier-plugin-tailwindcss`. ESLint uses `vueTsConfigs.strictTypeChecked` — `any` is allowed, but `vue/multi-word-component-names` and `vue/no-v-html` are intentionally off.
- When adding columns, write a new migration file in `database/migrations/` rather than editing the original `2018_01_12_…` creation migration (host apps may already have it applied).
- Keep new config keys env-driven with a `MAIL_VIEWER_*` prefix, matching the pattern in `config/mail-viewer.php`.
