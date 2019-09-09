<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../vendor/autoload.php';

use Bonfim\ActiveRecord\ActiveRecord;
use Bonfim\ActiveRecord\DB;
use Bonfim\ActiveRecord\QueryBuilder;
ActiveRecord::conn('mysql:host=localhost;dbname=alexianb_sistema', 'root', 'batatafrita');

use App\Model;

echo "<pre>";

$student = Model\Student::login('support@alexianbrothersonline.com', 'KEY.123.00');

$course  = $student->getInitialCourse();
$courses = $student->getNotInitialCourses();
$unities = $course->getUnities();
$unity   = $course->getInitialUnity();

$countSubscribedUnities = count($course->getSubscribedUnities());


$lessons = $student->getInitialCourse()->getInitialUnity()->getNotFinishedLessons();

var_dump($lessons);
