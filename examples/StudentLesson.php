<?php

namespace App\Model;

use Bonfim\ActiveRecord\Model;
use Bonfim\ActiveRecord\QueryBuilder;

class StudentLesson extends Model
{
    protected static $table = 'student_lesson';

    public $id;
    public $student_id;
    public $lesson_id;
    public $course_unity_id;
    public $skill_id;
    public $score;
    public $date_modified;
    public $date_created;

    /**
     * @param Student|int $student
     * @return QueryBuilder
     */
    public static function getFromStudent($student): QueryBuilder
    {
        return self::select('lesson_id')
            ->where('student_id', $student->id ?? $student);
    }
}
