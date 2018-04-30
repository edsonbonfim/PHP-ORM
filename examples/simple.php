<?php

// run simple.sql

include '../vendor/autoload.php';

use Keep\DB;

DB::config([
    'driver' => 'mysql',
    'host'   => 'localhost',
    'dbname' => 'keep',
    'user'   => 'root',
    'pass'   => '1234'
]);

DB::conn();

class Post extends Keep\Model {}

print_r(Post::all());
