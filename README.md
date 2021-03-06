# Pollen Wp Db Component

[![Latest Version](https://img.shields.io/badge/release-1.0.0-blue?style=for-the-badge)](https://www.presstify.com/pollen-solutions/container/)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)
[![PHP Supported Versions](https://img.shields.io/badge/PHP->=7.0-8892BF?style=for-the-badge&logo=php)](https://www.php.net/supported-versions.php)

Pollen **Wp Db** Component is a Wordpress adapter for the Pollen Database Component.

## Installation

```bash
composer require pollen-solutions/wp-db
```

## Basic Usage

### User

#### Standard (with formatted meta-attributes appends)

```php
use Pollen\WpDb\Eloquent\User;

$users = User::on()->limit(10)->get();
try {
    $data = json_encode($users->toArray(), JSON_THROW_ON_ERROR);
} catch (\Throwable $e ) {
    $data = $e->getMessage();
}
echo $data;
```

#### Include all non formatted metadatas

```php
use Pollen\WpDb\Eloquent\User;

$users = User::on()->with('metas')->limit(10)->get();
try {
    $data = json_encode($users->toArray(), JSON_THROW_ON_ERROR);
} catch (\Throwable $e ) {
    $data = $e->getMessage();
}
echo $data;
```

#### With formatted meta-attributes disabled

```php
use Pollen\WpDb\Eloquent\User;

$users = User::on()->limit(10)->get();
try {
    $data = json_encode($users->makeHidden(User::metaAttributes())->toArray(), JSON_THROW_ON_ERROR);
} catch (\Throwable $e ) {
    $data = $e->getMessage();
}
echo $data;

```

#### With all related posts (not recommended)

Major resource consumer, bad practice ...

```php
use Pollen\WpDb\Eloquent\User;

$users = User::on()->with('posts')->find(1);
try {
    $data = json_encode($users->toArray(), JSON_THROW_ON_ERROR);
} catch (\Throwable $e ) {
    $data = $e->getMessage();
}
echo $data;

```

#### Role contraints

##### Global scope

```php
namespace App\Model;

use Pollen\WpDb\Eloquent\User;

class Administrator extends User
{
    public $userRoleScope = 'administrator';
}

$admins = Administrator::on()->limit(10)->get();
try {
    $data = json_encode($admins->toArray(), JSON_THROW_ON_ERROR);
} catch (\Throwable $e ) {
    $data = $e->getMessage();
}
echo $data;

```

##### Dynamic scope 

```php
use Pollen\WpDb\Eloquent\User;

$users = User::on()->role('administrator')->limit(10)->get();
try {
    $data = json_encode($users->toArray(), JSON_THROW_ON_ERROR);
} catch (\Throwable $e ) {
    $data = $e->getMessage();
}
echo $data;

```

#### Blog contraints

##### Global scope

```php
use Pollen\WpDb\Eloquent\User;

User::setBlogScope(2);

$users = User::on()->role('administrator')->limit(10)->get();
try {
    $data = json_encode($users->toArray(), JSON_THROW_ON_ERROR);
} catch (\Throwable $e ) {
    $data = $e->getMessage();
}
echo $data;

User::resetBlogScope();

```

##### Dynamic scope

```php
use Pollen\WpDb\Eloquent\User;

$users = User::on()->blog(2)->limit(10)->get();
try {
    $data = json_encode($users->toArray(), JSON_THROW_ON_ERROR);
} catch (\Throwable $e ) {
    $data = $e->getMessage();
}
echo $data;

```
