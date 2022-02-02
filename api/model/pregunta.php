<?php

class Pregunta
{

    public function __construct()
    {
    }

    public $id;
    public $paso;
    public $nombre;
    public $tipo;
    public $opciones;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPaso()
    {
        return $this->paso;
    }

    public function setPaso($paso)
    {
        $this->paso = $paso;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getOpciones()
    {
        return $this->opciones;
    }

    public function setOpciones($opciones)
    {
        $this->opciones = $opciones;
    }
}
