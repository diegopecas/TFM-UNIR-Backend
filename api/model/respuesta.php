<?php

class Respuesta
{

    public function __construct()
    {
    }

    public $id;
    public $pregunta;
    public $respuesta;
    public $evaluacion;
    public $observacion;
    public $ejecucion;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getPregunta()
    {
        return $this->pregunta;
    }

    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;
    }

    public function getRespuesta()
    {
        return $this->respuesta;
    }

    public function setRespuesta($respuesta)
    {
        $this->respuesta = $respuesta;
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

    public function getEjecucion()
    {
        return $this->ejecucion;
    }

    public function setEjecucion($ejecucion)
    {
        $this->ejecucion = $ejecucion;
    }

}
