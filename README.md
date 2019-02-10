# Laravel 5.5+ mail logger and viewer
### Easily log and view in browser outgoing emails.

This package gives an ability to log all outgoing emails to a database and view them all from a browser like them will be shown in a modern mail clients (gmail, etc.).

## Installation

### Step 1: Composer

From the command line, run:

```
composer require masterro/laravel-mail-viewer
```

### Step 2: Service Provider (Supports package auto-discovery)

For manual registration open `config/app.php` and, within the `providers` array, append:

```
MasterRO\MailViewer\Providers\MailViewerServiceProvider::class
```

This will bootstrap the package into Laravel.

### Step 3: Publish Configs

```
php artisan vendor:publish --provider="MasterRO\MailViewer\Providers\MailViewerServiceProvider"
```

You have to publish _**assets,**_ _configs_ are optional.


### Step 4: Run migrations

```
php artisan migrate
```

### Step 5: View emails
All ongoing emails would be displayed on `/_mail-viewer` page by default.
