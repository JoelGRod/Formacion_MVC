<?php

namespace Formacion\Controllers;

use Formacion\Core\Request;
use Formacion\Utils\DependencyInjector;

abstract class AbstractController {
    protected $request;
    protected $db;
    protected $config;
    protected $view;
    protected $log;
    protected $di;

    public function __construct(DependencyInjector $di, Request $request) {
        $this->di = $di;
        $this->request = $request;
        
        $this->db = $di->get('PDO');
        $this->config = $di->get('Utils\Config');
        $this->view = $di->get('Twig_Environment');
        $this->log = $di->get('Logger');
    }

    protected function render(string $template, array $params): string {
        return $this->view->render($template, $params);
    }
}

?>