<?php

namespace Bookstore\Domain;

class Becario {
    private static $lastId = 0;
    protected $id;
    protected $firstname;
    protected $surname;
    protected $nacionalidad_id;
    protected $formacion_id;

    public function __construct(
        int $id,
        string $firstname,
        string $surname,
        int $nacionalidad_id,
        int $formacion_id
    ) {
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->nacionalidad_id = $nacionalidad_id;
        $this->formacion_id = $formacion_id;

        if(empty($id)) {
            $this->id = ++self::$lastId;
        } else {
            $this->id = $id;
            if($id > self::$lastId) {
                self::$lastId == $id;
            }
        }
    }

    public function getFirstname(): string {
        return $this->firstname;
    }

    public function getSurname(): string {
        return $this->surname;
    }

    public static function getLastId(): int {
        return self::$lastId;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNacionalidadId(): int {
        return $this->nacionalidad_id;
    }
    
    public function getFormacionId(): int {
        return $this->formacion_id;
    }
}

?>