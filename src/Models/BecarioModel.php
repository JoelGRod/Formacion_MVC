<?php

namespace Formacion\Models;

use Formacion\Exceptions\DbException;
use Formacion\Exceptions\NotFoundException;

class BecarioModel extends AbstractModel
{
    // Fetch Data
    public function getNacionalidad()
    {
        $query = 'SELECT id, etiqueta FROM nacionalidad';
        $sth = $this->db->prepare($query);
        $sth->execute();

        $nacionalidades = $sth->fetchAll();

        if (empty($nacionalidades)) {
            throw new NotFoundException();
        }

        return $nacionalidades;
    }

    public function getFormacion()
    {
        $query = 'SELECT id, etiqueta FROM formacion';
        $sth = $this->db->prepare($query);
        $sth->execute();

        $formaciones = $sth->fetchAll();

        if (empty($formaciones)) {
            throw new NotFoundException();
        }

        return $formaciones;
    }

    public function getFormador()
    {
        $query = 'SELECT f.id, f.nombre, f.apellidos, s.etiqueta as sala
        FROM formador f
        LEFT JOIN sala s ON f.sala_id = s.id';
        $sth = $this->db->prepare($query);
        $sth->execute();

        $formadores = $sth->fetchAll();

        if (empty($formadores)) {
            throw new NotFoundException();
        }

        return $formadores;
    }

    public function addBecario(array $infoBecario, string $formador_id)
    {
        $this->db->beginTransaction();

        $query = <<<SQL
        INSERT INTO becario (nombre, apellidos, nacionalidad_id, formacion_id) VALUES
        (:firstname, :lastname, :country_id, :formation_id)
        SQL;

        $sth = $this->db->prepare($query);
        if (!$sth->execute($infoBecario)) {
            $this->db->rollBack();
            throw new DbException($sth->errorInfo()[2]);
        }

        $lastBecarioId = $this->db->lastInsertId();

        $query = <<<SQL
        INSERT INTO formador_has_becario (formador_id, becario_id) VALUES
        (:formador_id, :becario_id)
        SQL;

        $params = [
            'formador_id' => $formador_id,
            'becario_id' => $lastBecarioId
        ];

        $sth = $this->db->prepare($query);
        if (!$sth->execute($params)) {
            $this->db->rollBack();
            throw new DbException($sth->errorInfo()[2]);
        }

        $this->db->commit();
    }

    public function getBecarios()
    {
        $query = 'SELECT b.id, b.nombre, b.apellidos, b.nacionalidad_id, b.formacion_id, 
        n.etiqueta as nacionalidad, 
        fo.etiqueta as formacion,
        f.id as formador_id, 
        f.nombre as nombre_formador, 
        s.etiqueta as sala,
        fhf.fecha_inicio as inicio,
        fhf.fecha_fin as fin
        FROM formador_has_becario fhb 
        INNER JOIN becario b ON fhb.becario_id = b.id 
        INNER JOIN formador f ON fhb.formador_id = f.id
        INNER JOIN nacionalidad n ON b.nacionalidad_id = n.id
        INNER JOIN formacion fo ON b.formacion_id = fo.id
        INNER JOIN sala s ON f.sala_id = s.id
        INNER JOIN formador_has_formacion fhf ON f.id = fhf.formador_id
        WHERE fo.id = fhf.formacion_id';

        $sth = $this->db->prepare($query);
        $sth->execute();

        $becarios = $sth->fetchAll();

        if (empty($becarios)) {
            throw new NotFoundException();
        }

        return $becarios;
    }

    public function deleteBecarios(array $becarioIds)
    {
        $query = 'DELETE FROM becario WHERE id = :id';
        foreach ($becarioIds as $key => $value) {
            $sth = $this->db->prepare($query);
            $sth->bindValue('id', $value);

            if (!$sth->execute()) {
                throw new DbException($sth->errorInfo()[2]);
            }
        }
    }

    public function modifyBecarios(array $becarios)
    {
        $this->db->beginTransaction();

        $query = <<<SQL
        UPDATE becario SET
        nombre = :nombre,
        apellidos = :apellidos,
        nacionalidad_id = :nacionalidad_id,
        formacion_id = :formacion_id
        WHERE id = :id
        SQL;

        foreach ($becarios as $key => $becario) {
            $sth = $this->db->prepare($query);
            $sth->bindValue('nombre', $becario['firstname']);
            $sth->bindValue('apellidos', $becario['lastname']);
            $sth->bindValue('nacionalidad_id', $becario['country_id']);
            $sth->bindValue('formacion_id', $becario['formation_id']);
            $sth->bindValue('id', $becario['id']);
            if (!$sth->execute()) {
                $this->db->rollBack();
                throw new DbException($sth->errorInfo()[2]);
            }
        }

        $query = <<<SQL
        UPDATE formador_has_becario SET
        formador_id = :formador_id
        WHERE becario_id = :id
        SQL;

        foreach ($becarios as $key => $becario) {
            $sth = $this->db->prepare($query);
            $sth->bindValue('formador_id', $becario['formador_id']);
            $sth->bindValue('id', $becario['id']);
            if (!$sth->execute()) {
                $this->db->rollBack();
                throw new DbException($sth->errorInfo()[2]);
            }
        }

        $this->db->commit();
    }
}
