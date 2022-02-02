<?php

class PermisoRol
{

    public function __construct()
    {
    }

    public $id;
    public $permiso;
    public $rol;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPermiso()
    {
        return $this->permiso;
    }

    public function setPermiso($permiso)
    {
        $this->permiso = $permiso;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }
}
