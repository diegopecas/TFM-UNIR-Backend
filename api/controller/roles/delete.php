<?php
include_once '../../../config/cors.php';

include_once '../../service/roles.service.php';

$item = new RolesService();

$data = json_decode(file_get_contents("php://input"));

// $item->id = $data->id;
$item->setIdRol($data->id);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->deleteRol()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Rol eliminado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Rol no pudo ser eliminado.";
    echo json_encode($respuesta);
}
