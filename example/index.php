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
    'pass'   => ''
]);

$conn = DB::conn();

class Test extends Keep\Model
{
}

// $test = new Test;
//
// $test->id = 1;
// $test->nome = "Test1";
//
// $save = $test->save();


// $test = Test::find(1);
// $test->delete();

//$test = Test::find_by_nome_or_id('stest6', 1);
//var_dump($test);


//print_r(Test::all());
