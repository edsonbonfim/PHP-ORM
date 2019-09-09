<?php

namespace App\Model;

use Bonfim\ActiveRecord\Model;

class Course extends Model
{
    protected static $table = 'course';

    public $id;
    public $name;
    public $disabled;
    public $level_id;
    public $is_basic;
    public $description;
    public $image;
    public $author;
    public $date_modified;
    public $date_created;

    /**
     * @var Student|null
     */
    private $student = null;

    /**
     * @var Unity[]|null
     */
    private $unities = null;

    /**
     * @param Student|int $student
     * @return Course[]|null
     */
    public static function getFromStudent($student): ?array
    {
        return self::in('id', StudentCourse::getFromStudent($student))->get();
    }

    /**
     * @param Student|int $student
     * @return Course|null
     */
    public static function getInitialFromStudent($student): ?self
    {
        return self::in('id', StudentCourse::getInitialFromStudent($student))->first();
    }

    public function subscribe()
    {
        //
    }

    /**
     * Retorna todas as unidades do curso
     *
     * @return Unity[]|null
     */
    public function getUnities(): ?array
    {
        if (!$this->unities) {
            $this->unities = Unity::getFromCourse($this)->get();
        }

        return $this->unities;
    }

    public function setStudent(Student $student)
    {
        $this->student = $student;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    /**
     * Retorna a unidade inicial do curso
     *
     * @return Unity|null
     */
    public function getInitialUnity(): ?Unity
    {
        $unity = Unity::getInitialFromCourse($this);
        $unity->setCourse($this);
        return $unity;
    }

    public function getSubscribedUnities()
    {
        return Unity::getSubscribedFromCourse($this);
    }
}
