<?php

namespace App\Model;

use Bonfim\ActiveRecord\Model;

class Lesson extends Model
{
    protected static $table = 'lesson';

    public $id;
    public $page_unity;
    public $course_unity_id;
    public $disabled;
    public $level_id;
    public $proficiency;
    public $title;
    public $layout_lateral;
    public $intro;
    public $body;
    public $image;
    public $audio;
    public $video;
    public $video_times;
    public $game;
    public $copyright;
    public $publisher;
    public $source;
    public $author;
    public $editor;
    public $date_modified;
    public $date_created;
    public $is_atividade;

    /**
     * @param Student|int $student
     * @return Lesson[]|null
     */
    public static function getFromStudent($student)
    {
        return self::in('id', StudentLesson::getFromStudent($student))->get();
    }
}
