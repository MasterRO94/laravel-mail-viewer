<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg">
</p>

<p align="center">
    <a href="https://packagist.org/packages/masterro/laravel-mail-viewer">
        <img src="https://img.shields.io/packagist/v/masterro/laravel-mail-viewer.svg?style=flat-rounded" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/masterro/laravel-mail-viewer">
        <img src="https://img.shields.io/packagist/dt/masterro/laravel-mail-viewer.svg?style=flat-rounded" alt="Total Downloads">
    </a>
    <a href="https://github.com/MasterRO94/laravel-mail-viewer/blob/master/LICENSE">
        <img src="https://img.shields.io/github/license/MasterRO94/laravel-mail-viewer" alt="License">
    </a>
</p>

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
