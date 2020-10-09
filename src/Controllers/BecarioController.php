<?php

namespace Formacion\Controllers;

use Formacion\Exceptions\NotFoundException;
use Formacion\Exceptions\DbException;
use Formacion\Models\BecarioModel;

class BecarioController extends AbstractController
{
    protected $customerId;

    public function initBecario(): string
    {
        $becarioModel = $this->di->get('BecarioModel');
        try {
            $nacionalidades = $becarioModel->getNacionalidad();
            $formaciones = $becarioModel->getFormacion();
            $formadores = $becarioModel->getFormador();
        } catch (\Exception $e) {
            $this->log->error("Error getting data: " . $e->getMessage());
            $params = ['errorMessage' => 'Data not found!!'];
            return $this->render('error.twig', $params);
        }
        $params = [
            'nacionalidades' => $nacionalidades,
            'formaciones' => $formaciones,
            'formadores' => $formadores
        ];
        return $this->render('addBecario.twig', $params);
    }

    public function addBecario(): string
    {
        $infoBecario = [];
        $infoBecario['firstname'] = $this->request->getParams()->getString('firstname');
        $infoBecario['lastname'] = $this->request->getParams()->getString('lastname');
        $infoBecario['country_id'] = (int)$this->request->getParams()->getString('country');
        $infoBecario['formation_id'] = (int)$this->request->getParams()->getString('formation');
        $formador_id = (int)$this->request->getParams()->getString('formador');
        
        $becarioModel = $this->di->get('BecarioModel');
        try {
            $becarioModel->addBecario($infoBecario, $formador_id);
        } catch (\Exception $e) {
            $this->log->error("Error inserting data: " . $e->getMessage());
            $params = ['errorMessage' => 'Its not possible to insert data!!'];
            return $this->render('error.twig', $params);
        }
        
        return $this->initBecario();
    }

    public function modBecarios(): string
    {
        $becarioModel = $this->di->get('BecarioModel');
        try {
            $becarios = $becarioModel->getBecarios();
            $nacionalidades = $becarioModel->getNacionalidad();
            $formaciones = $becarioModel->getFormacion();
            $formadores = $becarioModel->getFormador();
        } catch (\Exception $e) {
            $this->log->error("Error getting data: " . $e->getMessage());
            $params = ['errorMessage' => 'Data not found!!'];
            return $this->render('error.twig', $params);
        }

        $params = [
            'becarios' => $becarios,
            'nacionalidades' => $nacionalidades,
            'formaciones' => $formaciones,
            'formadores' => $formadores
        ];
        
        return $this->render('modifyBecario.twig', $params);
    }

    public function modifyBecarios(): string
    {
        $datos = $this->request->getParams()->getArray('check_list');
        $becariosAModificar = [];
        foreach($datos as $key => $value) {
            $becariosAModificar[$key] = [
                'id' => $value,
                'firstname' => $this->request->getParams()->getString('firstname-'.$value),
                'lastname' => $this->request->getParams()->getString('lastname-'.$value),
                'country_id' => (int)$this->request->getParams()->getString('country-'.$value),
                'formation_id' => (int)$this->request->getParams()->getString('formation-'.$value),
                'formador_id' => (int)$this->request->getParams()->getString('formador-'.$value)
            ];
        }

        $becarioModel = $this->di->get('BecarioModel');
        try {
            $becarioModel->modifyBecarios($becariosAModificar);
        } catch (\Exception $e) {
            $this->log->error("Error getting data: " . $e->getMessage());
            $params = ['errorMessage' => 'Data not found!!'];
            return $this->render('error.twig', $params);
        }
        
        return $this->delBecarios();
    }

    public function delBecarios(): string
    {
        $becarioModel = $this->di->get('BecarioModel');
        try {
            $becarios = $becarioModel->getBecarios();
        } catch (\Exception $e) {
            $this->log->error("Error getting data: " . $e->getMessage());
            $params = ['errorMessage' => 'Data not found!!'];
            return $this->render('error.twig', $params);
        }

        $params = [
            'becarios' => $becarios
        ];
        
        return $this->render('deleteBecario.twig', $params);
    }

    public function deleteBecarios(): string
    {
       $becariosABorrar = $this->request->getParams()->getArray('check_list');
       $becarioModel = $this->di->get('BecarioModel');
        try {
            $becarioModel->deleteBecarios($becariosABorrar);
        } catch (\Exception $e) {
            $this->log->error("Error deleting data: " . $e->getMessage());
            $params = ['errorMessage' => 'Data not deleted!!'];
            return $this->render('error.twig', $params);
        }
        return $this->delBecarios();
    }
}
