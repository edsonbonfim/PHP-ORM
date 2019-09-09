<?php

namespace App\Model;

use Bonfim\ActiveRecord\Model;
use Bonfim\ActiveRecord\QueryBuilder;

class StudentCourse extends Model
{
    protected static $table = 'student_course';

    public $id;
    public $student_id;
    public $course_id;
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
        return self::select('course_id')
            ->where('student_id', $student->id ?? $student);
    }

    /**
     * @param Student|int $student
     * @param Course|int $course
     * @return StudentCourse|null
     */
    public static function subscribe($student, $course): ?self
    {
        $instance = self::newInstance();
        $instance->student_id = $student->id ?? $student;
        $instance->course_id  = $course->id  ?? $course;
        return $instance->save();
    }

    public static function getInitialFromStudent(Student $student)
    {
        return self::getFromStudent($student)
            ->where('is_initial', 1);
    }
}
