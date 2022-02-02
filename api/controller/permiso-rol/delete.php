<?php
include_once '../../../config/cors.php';

include_once '../../service/permisos-rol.service.php';

$item = new PermisoRolService();

$data = json_decode(file_get_contents("php://input"));

// $item->id = $data->id;
$item->setIdPermisoRol($data->id);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->deletePermisoRol()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "PermisoRol eliminado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "PermisoRol no pudo ser eliminado.";
    echo json_encode($respuesta);
}
