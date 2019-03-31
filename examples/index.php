<?php

include getcwd() . '/vendor/autoload.php';

use Bonfim\ActiveRecord\ActiveRecord;
use Bonfim\ActiveRecord\Examples\Database\Migrations\TweetSchema;
use Bonfim\ActiveRecord\Examples\Database\Migrations\UserSchema;


ActiveRecord::connection('mysql:host=localhost;dbname=note', 'root', 'batatapalha123');

$tweet = new TweetSchema();
$tweet->up();
$dump = $tweet->run();

//$user = new UserSchema();
//$user->up();
//$dump = $user->run();

echo $dump;

echo "\n";
