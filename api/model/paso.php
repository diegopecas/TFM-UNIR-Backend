<?php

class Paso
{

    public function __construct()
    {
    }

    public $id;
    public $prueba;
    public $nombre;
    public $descripcion;

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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
}
