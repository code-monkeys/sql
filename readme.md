# m/sql

A small database library.


## Installation

```
composer require m/sql
```


## Usage

```php
use sql\Mysql;

$db = Mysql::fromConfig([
    "host" => "db01.internal",
    "user" => "app",
    "pass" => "secret",
    "db"   => "shop",
]);

$rows = $db->read("SELECT * FROM cart WHERE user_id = 123");
// returns array of associative arrays

$num = $db->write("UPDATE cart SET updated = NOW() WHERE id = 456");
// returns number of affected rows
```

## API

```php
interface DbInterface
{
    public static function fromConfig(array $config);
    public static function fromUrl($url);

    public function read($sql);
    public function write($sql);
    public function config($key = null, $value = null);
}
```

The config can be parsed from a URL and changed at will:

```php
$db = Mysql::fromUrl("mysql://username:password@host/db");
$db = Mysql::fromUrl($_ENV["DATABASE_URL"]);

$currHost = $db->config("host");                   // get current config value
$oldValue = $db->config("host", "db02.internal");  // change one item, returns old value
$config   = $db->config();                         // get all config values
```


## Status

[![Travis Status](https://api.travis-ci.org/dotser/sql.svg?branch=master)](https://travis-ci.org/dotser/sql)
[![Latest Stable Version](https://poser.pugx.org/m/sql/v/stable)](https://packagist.org/packages/m/sql)
[![Total Downloads](https://poser.pugx.org/m/sql/downloads)](https://packagist.org/packages/m/sql)
[![Coverage Status](https://coveralls.io/repos/github/dotser/sql/badge.svg?branch=master)](https://coveralls.io/github/dotser/sql?branch=master)
