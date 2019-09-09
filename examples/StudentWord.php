<?php

namespace App\Model;

use Bonfim\ActiveRecord\Model;
use Bonfim\ActiveRecord\QueryBuilder;

class StudentWord extends Model
{
    protected static $table = 'student_word';

    public $id;
    public $student_id;
    public $word_id;
    public $lesson_id;
    public $course_unity_id;
    public $score;
    public $date_modified;
    public $date_created;

    /**
     * @param $student
     * @return QueryBuilder
     */
    public static function getFromStudent($student): QueryBuilder
    {
        return self::select('word_id')
            ->where('student_id', $student->id ?? $student);
    }

    /**
     * @param Student|int $student
     * @param Word|int $word
     * @param Lesson|int $lesson
     * @param Unity|int|null $unity
     */
    public static function subscribe($student, $word, $lesson, $unity = null)
    {
        $instance = self::newInstance();
        $instance->student_id = $student->id ?? $student;
        $instance->word_id = $word->id ?? $word;
        $instance->lesson_id = $lesson->id ?? $lesson;
        $instance->course_unity_id = $unity->id ?? $unity;
        $instance->save();
    }
}
