Keep-ORM 1.0 Documentation
======================

[![Latest Version][ico-version]][link-version]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![StyleCI][ico-styleci]][link-styleci]

This is the full documentation for Keep-ORM 1.0.x

Prerequisites
=============

* PHP 7.1+
* PDO driver for your respective database

Supported Databases
===================

* MySQL

Installation
============

Require via [composer](https://getcomposer.org/download/)

``` sh
$ composer require keeporm/keep:^1.0
```

Create an **index.php** file and require the autoload.php of composer

```php
<?php

include 'vendor/autoload.php';
```

After that, let's to do all necessary configuration

```php
use Keep\DB;

DB::config([
    'driver' => 'mysql',
    'host'   => 'localhost',
    'dbname' => 'keep',
    'user'   => 'root',
    'pass'   => '1234'
]);

DB::conn();
```

Basic CRUD
==========

### Retrieve

These are your basic methods to find and retrieve records from your database:

```php
$post = Post::find(1);
echo $user->title; // 'My first blog post!!'
echo $user->author_name; // 'Edson Onildo'

// Finding using dynamic finders
$post = Post::find_by_title('My first blog post!!');
$post = Post::find_by_title_or_id('My first blog post!!', 1);
$post = Post::find_by_title_and_id('My first blog post!!', 1);

// Retrieve all records
$post = Post::all();
```

### Create

Here we create a new post by instantiating a new object and then invoking the save() method:

```php
$post = new Post();
$post->title = 'My first blog post!!';
$post->author_name = 'Edson Onildo';
$post->save();

// INSERT INTO `posts` (title, author_name) VALUES ('My first blog post!!', 'Edson Onildo');
```

### Update

To update you would just need to find a record first and then change one of its attributes.

```php
$post = Post::find(1);
echo $post->title; // 'My first blog post!!'
$post->title = 'Some title';
$post->save();

// UPDATE `posts` SET title='Some title' WHERE id=1
```

### Delete

Deleting a record will not destroy the object. This means that it will call sql to delete the record in your database but you can still use the object if you need to.

```php
$post = Post::find(1);
$post->delete();

// DELETE FROM `posts` WHERE id=1
```

Contributing
============

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

Security
========

If you discover any security related issues, please email inbox.edsononildo@gmail.com instead of using the issue tracker.

Credits
=======

- [Edson Onildo][link-author]
- [All Contributors][link-contributors]

License
=======

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/github/release/EdsonOnildoJR/Keep.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/EdsonOnildoJR/Keep/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/EdsonOnildoJR/Keep.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/EdsonOnildoJR/Keep.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/124445597/shield?branch=master

[link-version]:https://github.com/EdsonOnildoJR/Keep/releases
[link-travis]: https://travis-ci.org/EdsonOnildoJR/Keep
[link-scrutinizer]: https://scrutinizer-ci.com/g/EdsonOnildoJR/Keep/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/EdsonOnildoJR/Keep
[link-styleci]: https://styleci.io/repos/124445597
[link-author]: https://github.com/EdsonOnildoJR
[link-contributors]: https://github.com/EdsonOnildoJR/Keep/contributors
