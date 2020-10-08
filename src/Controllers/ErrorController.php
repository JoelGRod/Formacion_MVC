<?php

namespace Formacion\Controllers;

class ErrorController extends AbstractController {
    public function notFound(string $message = 'Page not found!!'): string {
        $params = ['errorMessage' => $message];
        return $this->render('error.twig', $params);
    }
}

?>