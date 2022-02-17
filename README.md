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

# Laravel mail logger and viewer

### Easily log, view and search in browser all outgoing emails.

![preview](https://github.com/MasterRO94/packages/blob/master/mail-viewer/Mail%20Viewer%20V2.png "Preview")

This package gives an ability to log all outgoing emails to a database and view them all from a browser like they will
be shown in a modern mail clients (gmail, etc.).

## Version Compatibility

| Laravel     | Mail Viewer |
|:------------|:------------|
| 5.5.x - 8.* | 1.3.x       |
| 9.x         | 2.x.x       |

## Upgrade from v1 to v2

Version 2 has been almost totally rewritten and brings totally new fresh UI build with Vue.js 3 and TailwindCss 3.  
It works **only with Laravel 9+** as of Symfony Mailer replacement for previously used Swift Mailer.

### Upgrade Steps

#### Composer Dependencies

You should update the dependency in your application's composer.json file:

`masterro/laravel-mail-viewer` to ^2.0

#### Database migrations

Run package migrations (requires `doctrine/dbal` to be installed):

```shell
php artisan migrate
```

#### Publish assets

Run publish command:

```shell
php artisan mail-viewer:publish --views
```

#### Update configs

V2 uses separate date format for date and time, update these in your `config/mail-viewer.php` file

```php
'date_format' => 'd.m.Y',
'time_format' => 'H:i:s',
```

#### Data pruning

V2 allows prune old records easily using `mail-viewer:prune` command. You can add it to your Scheduler.

```php
// Console/Kernel.php
$schedule->command('mail-viewer:prune')->daily();
```

You can specify how many days data will be stored before pruning using config. Default value is 31 days.

```php
'prune_older_than_days' => 31,
```

## Installation

### Step 1: Composer

From the command line, run:

```
composer require masterro/laravel-mail-viewer
```

### Step 2: Publish assets and configs

```
php artisan mail-viewer:publish
```

You have to publish _**assets,**_ and _**views,**_ _configs_ are optional.

### Step 3: Run migrations

```
php artisan migrate
```

### Step 4: View emails

All ongoing emails you can find on `/_mail-viewer` page.

## Configuration

You can review and change all the default configuration values in published `config/mail-viewer.php` file.

#### Data pruning (v2+)

The package allows you to prune old records easily using `mail-viewer:prune` command. You can add it to your Scheduler.

```php
// Console/Kernel.php
$schedule->command('mail-viewer:prune')->daily();
```
