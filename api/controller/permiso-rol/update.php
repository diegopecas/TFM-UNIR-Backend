<?php
include_once '../../../config/cors.php';

include_once '../../service/roles.service.php';
include_once '../../model/rol.php';

$item = new RolesService();

$data = json_decode(file_get_contents("php://input"));

$item->setIdRol($data->id);
$item->setRol($data);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->updateRol()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Rol actualizado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Rol no actualizado.";
    echo json_encode($respuesta);
}
