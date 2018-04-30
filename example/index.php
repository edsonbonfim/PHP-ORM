<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

include '../vendor/autoload.php';

use Keep\DB;

DB::config([
    'driver' => 'mysql',
    'host'   => 'localhost',
    'dbname' => 'keep',
    'user'   => 'root',
    'pass'   => '1234'
]);

$conn = DB::conn();

class Post extends Keep\Model
{
}

$post = Post::find_by_title_and_id('Post6', 6);
$post->id = 7;
$post->title = 'Post7';
$post->author_name = 'Edson Onildo';
$post->update();

var_dump($post);
