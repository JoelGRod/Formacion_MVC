<?php

namespace Formacion\Core;

/*
Objetivo: Filtrar los datos que vienen por $_GET, $_POST
y $_COOKIES
*/

class FilteredMap {
    private $map;

    public function __construct(array $baseMap) {
        $this->map = $baseMap;
    }

    public function has(string $key): bool {
        return isset($this->map[$key]);
    }

    // Private??
    public function get(string $key) {
        return $this->map[$key] ?? null;
    }

    // Filter functions

    public function getInt(string $key) {
        return (int) $this->get($key);
    }

    public function getNumber(string $key) {
        return (float) $this->get($key);
    }

    // Security!! try to avoid the sql injection
    public function getString(string $key, bool $filter = true) {
        $value = (string) $this->get($key);
        return $filter ? addslashes($value) : $value;
    }

    public function getArray(string $key) {
        return $this->get($key);
    }
}

?>