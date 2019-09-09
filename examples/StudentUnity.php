<?php

namespace App\Model;

use Bonfim\ActiveRecord\Model;
use Bonfim\ActiveRecord\QueryBuilder;

class StudentUnity extends Model
{
    protected static $table = 'student_unity';

    public $id;
    public $student_id;
    public $course_unity_id;
    public $is_done = 0;
    public $is_initial = 1;
    public $date_modified;
    public $date_created;

    /**
     * @param Student|int $student
     * @return QueryBuilder
     */
    public static function getFromStudent($student): QueryBuilder
    {
        return self::select('course_unity_id')
            ->where('student_id', $student->id ?? $student);
    }

    /**
     * @param Student|int $student
     * @param Unity|int $unity
     * @return StudentUnity|null
     */
    public static function subscribe($student, $unity): ?self
    {
        $instance = self::newInstance();
        $instance->student_id = $student->id ?? $student;
        $instance->course_unity_id = $unity->id ?? $unity;
        return $instance->save();
    }

    public static function getInitialFromCourse(Course $course)
    {
        return self::getFromStudent($course->getStudent())
            ->where('course_id', $course->id)
            ->where('is_initial', 1);
    }

    public static function getSubscribedFromCourse(Course $course)
    {
        return self::getFromStudent($course->getStudent())
            ->where('course_id', $course->id);
    }
}
