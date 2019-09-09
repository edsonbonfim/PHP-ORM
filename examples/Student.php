<?php

namespace App\Model;

use Bonfim\ActiveRecord\Model;

class Student extends Model
{
    protected static $table = 'student';

    public $id;
    public $affiliate_id = 2;
    public $language_id = 2;
    public $disabled = 0;
    public $credits = 0;
    public $private_access = 0;
    public $name;
    public $email;
    public $password;
    public $date_expire;
    public $image;
    public $sson;
    public $sson_expire;
    public $date_last_login;
    public $date_modified;
    public $date_created;
    public $is_admin;
    public $level_id;

    /**
     * @var Course|null
     */
    private $initial = null;

    /**
     * @var Course[]|null
     */
    private $courses = null;

    /**
     * @var Unity[]|null
     */
    private $unities = null;

    /**
     * @var Word[]|null
     */
    private $words = null;

    /**
     * @var Lesson[]|null
     */
    private $lessons = null;

    public static function login(string $email, string $password): self
    {
        return self::where('email', $email)
            ->where('password', md5($password))
            ->first();
    }

    public static function signup(string $name, string $email, string $password): self
    {
        $instance = self::newInstance();

        $instance->name = $name;
        $instance->email = $email;
        $instance->password = md5($password);

        return $instance->save();
    }

    /**
     * @param Course|int $course
     * @return StudentCourse|null
     */
    public function addCourse($course): ?StudentCourse
    {
        $studentCourse = StudentCourse::subscribe($this, $course);

        if (!$studentCourse) {
            return null;
        }

        $this->courses[] = $course;

        return $studentCourse;
    }

    /**
     * @param Unity|int $unity
     * @return StudentUnity|null
     */
    public function addUnity($unity): ?StudentUnity
    {
        $studentUnity = StudentUnity::subscribe($this, $unity);

        if (!$studentUnity) {
            return null;
        }

        $this->unities[] = $unity;

        return $studentUnity;
    }

    /**
     * @param Word|int $word
     * @return StudentWord|null
     */
    public function addWord($word): ?StudentWord
    {
//        $studentWord = StudentWord::subscribe($this, $word);
//
//        if (!$studentWord) {
//            return null;
//        }
//
//        $this->words[] = $word;
//
//        return $studentWord;
    }

    /**
     * @return Course[]|null
     */
    public function getCourses(): ?array
    {
        if ($this->courses === null) {
            $this->courses = Course::getFromStudent($this);
        }

        return $this->courses;
    }

    /**
     * Retorna todas as unidades de todos os cursos
     * que o estudante esta matriculado
     *
     * @return Unity[]|null
     */
    public function getUnities(): ?array
    {
        if ($this->unities === null) {
            $this->unities = Unity::getFromStudent($this);
        }

        return $this->unities;
    }

    /**
     * @return Word[]|null
     */
    public function getWords(): ?array
    {
        if ($this->words === null) {
            $this->words = Word::getFromStudent($this);
        }

        return $this->words;
    }

    /**
     * Retorna todas as licoes realizadas pelo estudante
     *
     * @return Lesson[]|null
     */
    public function getLessons(): ?array
    {
        if ($this->lessons === null) {
            $this->lessons = Lesson::getFromStudent($this);
        }

        return $this->lessons;
    }

    /**
     * Retorna o curso atual que o aluno esta realizando,
     * isto eh, o curso inicial
     *
     * @return Course|null
     */
    public function getInitialCourse(): ?Course
    {
        if (!$this->initial) {
            $this->initial = Course::getInitialFromStudent($this);
            $this->initial->setStudent($this);
        }

        return $this->initial;
    }

    /**
     * Retorna todos os cursos que o aluno esta matriculado,
     * exceto o curso inicial
     *
     * @return Course[]|null
     */
    public function getNotInitialCourses(): ?array
    {
        $courses = $this->getCourses();

        if (!$this->courses) {
            return null;
        }

        $initial = $this->getInitialCourse();

        $notInitials = [];

        foreach ($courses as $course) {
            if ($course->id === $initial->id) {
                continue;
            }
            $notInitials[] = $course;
        }

        return $notInitials;
    }
}
