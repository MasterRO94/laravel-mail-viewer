# Laravel 5.5+ mail logger and viewer
### Easily log and view and search in browser outgoing emails.

![preview](https://github.com/MasterRO94/packages/blob/master/mail-viewer/Mail%20Viewer%20Test%20App%20-%20Mail%20Viewer%202020-03-03%2014-02-25.png "Preview")

This package gives an ability to log all outgoing emails to a database and view them all from a browser like they will be shown in a modern mail clients (gmail, etc.).

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
php artisan mail-viewer:publish
```

You have to publish _**assets,**_ and _**views,**_ _configs_ are optional.


### Step 4: Run migrations

```
php artisan migrate
```

### Step 5: View emails
All ongoing emails you can find on `/_mail-viewer` page. Url 
