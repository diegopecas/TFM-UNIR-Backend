<?php
include_once '../../../config/cors.php';

include_once '../../service/usuarios.service.php';
include_once '../../model/usuario.php';

$item = new UsuarioService();

$data = json_decode(file_get_contents("php://input"));

$item->setUsuario($data);

$item->getUsuarioByPw();

if (!($item->getUsuario()->id == '')) {
    
    $arr = array();
    $arr["body"] = array();

    $e = array(
        "id" =>  $item->getUsuario()->id,
        "nombre" => $item->getUsuario()->nombre,
        "contrasena" => $item->getUsuario()->contrasena,
        "rol" => $item->getUsuario()->rol
    );
    array_push($arr["body"], $e);

    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(200);
    echo json_encode(array("message" => "Usuario no encontrado."));
}
