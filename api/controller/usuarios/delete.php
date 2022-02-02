<?php
include_once '../../../config/cors.php';

include_once '../../service/usuarios.service.php';

$item = new UsuarioService();

$data = json_decode(file_get_contents("php://input"));

// $item->id = $data->id;
$item->setIdUsuario($data->id);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->deleteUsuario()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Usuario eliminado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Usuario no pudo ser eliminado.";
    echo json_encode($respuesta);
}
