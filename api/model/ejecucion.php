<?php

class Ejecucion
{

    public function __construct()
    {
    }

    public $id;
    public $prueba;
    public $evaluacion;
    public $observacion;
    public $usuario;
    public $fecha;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPrueba()
    {
        return $this->prueba;
    }

    public function setPrueba($prueba)
    {
        $this->prueba = $prueba;
    }
    public function getEvaluacion()
    {
        return $this->evaluacion;
    }

    public function setEvaluacion($evaluacion)
    {
        $this->evaluacion = $evaluacion;
    }
    public function getObservacion()
    {
        return $this->observacion;
    }

    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
}
