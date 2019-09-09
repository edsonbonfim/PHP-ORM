<?php

namespace App\Model;

use Bonfim\ActiveRecord\Model;
use Bonfim\ActiveRecord\QueryBuilder;

class Unity extends Model
{
    protected static $table = 'course_unity';

    public $id;
    public $name;
    public $course_id;
    public $level_id;
    public $ordem;
    public $disabled;
    public $description;
    public $image;
    public $icon;
    public $chapters;
    public $authors;
    public $date_modified;
    public $date_created;

    /**
     * @var Lesson[]|null
     */
    private $lessons = null;

    private $course = null;

    /**
     * @param Student|int $student
     * @return Unity[]|null
     */
    public static function getFromStudent($student): ?array
    {
        return self::in('id', StudentUnity::getFromStudent($student))->get();
    }

    /**
     * @param Course|int $course
     * @return QueryBuilder
     */
    public static function getFromCourse($course): QueryBuilder
    {
        return self::where('course_id', $course->id ?? $course);
    }

    public static function getInitialFromCourse($course): ?self
    {
        return self::in('id', StudentUnity::getInitialFromCourse($course))->first();
    }

    public static function getSubscribedFromCourse(Course $course)
    {
        return self::in('id', StudentUnity::getSubscribedFromCourse($course))->get();
    }

    /**
     * @return Lesson[]|null
     */
    public function getFinishedLessons()
    {
        return Lesson::in('id', function () {
            return StudentLesson::getFromStudent($this->getCourse()->getStudent())
                ->where('course_unity_id', $this->id);
        })->get();
    }

    public function getNotFinishedLessons()
    {
        return Lesson::in('id', function () {
            return StudentLesson::getFromStudent();
        });
    }

    public function setCourse($course)
    {
        $this->course = $course;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }
}
