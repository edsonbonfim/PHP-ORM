<?php

namespace App\Model;

use Bonfim\ActiveRecord\Model;

class Word extends Model
{
    protected static $table = 'word';

    public $id;
    public $name;
    public $definition;
    public $audio;
    public $distractor;
    public $date_modified;
    public $date_created;

    /**
     * @param Student|int $student
     * @return Word[]|null
     */
    public static function getFromStudent($student): ?array
    {
        return self::in('id', StudentWord::getFromStudent($student))->get();
    }
}
