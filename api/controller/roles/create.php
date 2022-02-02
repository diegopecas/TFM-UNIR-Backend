<?php
include_once '../../../config/cors.php';

include_once '../../service/roles.service.php';

$data = json_decode(file_get_contents("php://input"));

$item = new RolesService();

$item->setRol($data);
// $item->rol->setNombre($data->nombre);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

$id = $item->createRol();
if ($id != null) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Rol creado.";
    $respuesta->respuesta->id = $id;
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Rol no creado.";
    echo json_encode($respuesta);
}
