<?php
include_once '../../../config/cors.php';

include_once '../../service/pasos.service.php';
include_once '../../model/paso.php';

$item = new PasosService();

$data = json_decode(file_get_contents("php://input"));

$item->setIdPaso($data->id);
$item->setPaso($data);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->updatePaso()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Paso actualizado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Paso no actualizado.";
    echo json_encode($respuesta);
}
