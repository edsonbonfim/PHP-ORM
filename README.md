activerecord.php
================

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Implementação do padrão de projeto active record em PHP

Table of Contents
-----------------

* [Prerequisites](#prerequisites)
* [Supported Databases](#supported-databases)
* [Installation](#installation)
* [Basic CRUD](#basic-crud)
    * [Retrieve](#retrieve)
    * [Create](#create)
    * [Update](#update)
    * [Delete](#delete)
* [Contributing](#contributing)
* [Security](#security)
* [Credits](#credits)
* [License](#license)

Prerequisites
-------------

* PHP 7.1+
* PDO driver for your respective database

Supported Databases
-------------------

* MySQL
* SQLite
* PostgreSQL
* Oracle

Installation
------------

Require via [composer](https://getcomposer.org/download/)

``` sh
$ composer require bonfim/activerecord
```

Create an **index.php** file and require the autoload.php of composer

```php
<?php

include 'vendor/autoload.php';
```

After that, let's to do all necessary configuration

```php
use Bonfim\ActiveRecord\ActiveRecord;

ActiveRecord::config('mysql:host=localhost;dbname=testdb', 'username', 'password');
```

Basic CRUD
----------

### Retrieve

These are your basic methods to find and retrieve records from your database:

```php
// Retrieve all records
$posts = Post::all();

// Retrieve records with specific keys
$posts = Post::select(['title']);

// Find records with a condition
$posts = Post::find('WHERE id = ?', [1]);
```

### Create

Here we create a new post by instantiating a new object and then invoking the save() method:

```php
$post = new Post();
$post->title = 'My first blog post!!';
$post->author_name = 'Edson Onildo';
$post->save();
```

```sql
INSERT INTO `posts` (`title`, `author_name`) VALUES ("My first blog post!!", "Edson Onildo");
```

### Update

To update you would just need to find a record first and then change one of its attributes.

```php
$post = Post::find('WHERE `id` = ?', [1])[0];
echo $post->title; // 'My first blog post!!'
$post->title = 'Some title';
$post->save();
```

```sql
UPDATE `posts` SET title='Some title' WHERE id=1;
```

### Delete

Deleting a record will not destroy the object. This means that it will call sql to delete the record in your database but you can still use the object if you need to.

```php
$post = Post::find('WHERE `id` = ?');
$post->delete();
```

```sql
DELETE FROM `posts` WHERE id=1;
```

Change log
----------

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

Testing
-------

``` bash
$ composer test
```

Contributing
------------

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

Security
--------

If you discover any security related issues, please email inbox.edsononildo@gmail.com instead of using the issue tracker.

Credits
-------

- [Edson Onildo][link-author]
- [All Contributors][link-contributors]

License
-------

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/edsononildo/orm.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/EdsonOnildoJR/activerecord.php/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/EdsonOnildoJR/activerecord.php.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/EdsonOnildoJR/activerecord.php.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/edsononildo/orm.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/edsononildo/orm
[link-travis]: https://travis-ci.org/EdsonOnildoJR/activerecord.php
[link-scrutinizer]: https://scrutinizer-ci.com/g/EdsonOnildoJR/activerecord.php/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/EdsonOnildoJR/activerecord.php
[link-downloads]: https://packagist.org/packages/edsononildo/orm
[link-author]: https://github.com/EdsonOnildoJR
[link-contributors]: ../../contributors
