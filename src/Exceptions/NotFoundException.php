<?php

    namespace Formacion\Exceptions;

    use Exception;

    class NotFoundException extends Exception {
        public function __construct($message = null) {
            $message = $message?: 'Not found.';
            parent::__construct($message);
        }
    }
?>