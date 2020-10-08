<?php

namespace Formacion\Exceptions;

use Exception;

class DbException extends Exception {

    public function __construct($message = null) {
        $message = $message ? : 'Bad Db connection';
        parent::__construct($message);
    }

}

?>