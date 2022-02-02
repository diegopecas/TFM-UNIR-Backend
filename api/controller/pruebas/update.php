<?php
include_once '../../../config/cors.php';

include_once '../../service/pruebas.service.php';
include_once '../../model/prueba.php';

$item = new PruebasService();

$data = json_decode(file_get_contents("php://input"));

$item->setIdPrueba($data->id);
$item->setPrueba($data);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->updatePrueba()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Prueba actualizado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Prueba no actualizado.";
    echo json_encode($respuesta);
}
