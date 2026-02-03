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

<p align="center">
    <a href="https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md">
        <img src="https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg" alt="StandWithUkraine">
    </a>
</p>

# Laravel Mail Viewer

Easily log, view, and search outgoing emails directly in your browser.

![Screenshot of Laravel Mail Viewer - Light Mode](./art/v3-light.png "Preview Light")
![Screenshot of Laravel Mail Viewer - Dark Mode](./art/v3-dark.png "Preview Dark")

This package logs all outgoing emails to a database and provides a web interface to view them, formatted as they appear in modern email clients like Gmail.

---

<!-- TOC -->
* [Laravel Mail Viewer](#laravel-mail-viewer)
  * [Features](#features)
  * [Installation](#installation)
    * [Step 1: Install via Composer](#step-1-install-via-composer)
    * [Step 2: Publish Assets & Configurations](#step-2-publish-assets--configurations)
    * [Step 3: Run Migrations](#step-3-run-migrations)
    * [Step 4: View Emails](#step-4-view-emails)
  * [Configuration](#configuration)
    * [Data Pruning](#data-pruning)
  * [Production Usage](#production-usage)
    * [Restrict Access with Middleware](#restrict-access-with-middleware)
    * [Disable package in production mode](#disable-package-in-production-mode)
      * [Disable auto-discovery:](#disable-auto-discovery)
      * [Register package for non-production environments](#register-package-for-non-production-environments)
  * [License](#license)
  * [Credits](#credits)
<!-- TOC -->

## Features
- Logs all outgoing emails to the database
- Modern in-browser email viewer
- Searchable UI with auto-refreshing entries
- Configurable route and access protection
- Optional email pruning

## Installation
### Step 1: Install via Composer

Run the following command in your terminal:

```sh
composer require masterro/laravel-mail-viewer
```

### Step 2: Publish Assets & Configurations

```sh
php artisan mail-viewer:publish
```

### Step 3: Run Migrations

```sh
php artisan migrate
```

### Step 4: View Emails

Visit `/_mail-viewer` in your browser to access the email viewer.

> **Note:** The route can be customized in the configuration file.

---

## Configuration

You can adjust default settings in the `config/mail-viewer.php` file.

### Data Pruning

The package supports Laravel's [Model Pruning](https://laravel.com/docs/eloquent#pruning-models). Define how many days emails should be retained in the configuration:

```php
'prune_older_than_days' => 365,
```

---

## Production Usage

By default, the email viewer is publicly accessible. 
In a production environment, it's highly recommended to restrict access 
using middleware or something like [Access Screen](https://github.com/MasterRO94/laravel-access-screen) package.
Alternatively, you can disable the package in production environments.

### Restrict Access with Middleware

Modify your `config/mail-viewer.php` to apply authorization:

```php
'middleware' => ['web', 'can:viewMailLogs'],
```

> **Note:** `viewMailLogs` is just an example ability you can register via Laravel’s [Authorization Gate](https://laravel.com/docs/authorization#writing-gates). 
> This ability is not included in the package.

You can also limit access by IP address in `App\Http\Middleware\RestrictMailViewerAccess.php`:

```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictMailViewerAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->ip(), ['127.0.0.1', '::1', 'YOUR_ALLOWED_IP'])) {
            abort(403);
        }

        return $next($request);
    }
}
```

Apply it in config:

```php
'middleware' => ['web', RestrictMailViewerAccess::class],
```

Now, only authorized users or allowed IPs can access the mail viewer.

---

### Disable package in production mode
#### Disable auto-discovery:
```json
"extra": {
  "laravel": {
    "dont-discover": [
      "masterro/laravel-mail-viewer"
    ]
  }
},
```

#### Register package for non-production environments
In your application's `ServiceProvider`
```php
use MasterRO\MailViewer\Providers\MailViewerServiceProvider;

public function register(): void
{
    if (!$this->app->environment('production')) {
        $this->app->register(MailViewerServiceProvider::class);
    }
}
```

## License

This package is open-source software licensed under the [MIT license](LICENSE).

---

## Credits

Developed by [MasterRO](https://github.com/MasterRO94).

