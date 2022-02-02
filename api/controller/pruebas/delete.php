<?php
include_once '../../../config/cors.php';

include_once '../../service/pruebas.service.php';

$item = new PruebasService();

$data = json_decode(file_get_contents("php://input"));

// $item->id = $data->id;
$item->setIdPrueba($data->id);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->deletePrueba()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Prueba eliminado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Prueba no pudo ser eliminado.";
    echo json_encode($respuesta);
}
