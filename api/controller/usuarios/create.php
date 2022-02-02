<?php
include_once '../../../config/cors.php';

include_once '../../service/usuarios.service.php';

$data = json_decode(file_get_contents("php://input"));

$item = new UsuarioService();

$item->setUsuario($data);
// $item->rol->setNombre($data->nombre);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

$id = $item->createUsuario();
if ($id != null) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Usuario creado.";
    $respuesta->respuesta->id = $id;
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Usuario no creado.";
    echo json_encode($respuesta);
}
