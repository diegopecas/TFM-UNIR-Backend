<?php
include_once '../../../config/cors.php';

include_once '../../service/pasos.service.php';

$item = new PasosService();

$data = json_decode(file_get_contents("php://input"));

// $item->id = $data->id;
$item->setIdPaso($data->id);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->deletePaso()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Paso eliminado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Paso no pudo ser eliminado.";
    echo json_encode($respuesta);
}
