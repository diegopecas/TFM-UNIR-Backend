<?php
include_once '../../../config/cors.php';

include_once '../../service/ejecucion.service.php';

$item = new EjecucionesService();

$data = json_decode(file_get_contents("php://input"));

// $item->id = $data->id;
$item->setIdEjecucion($data->id);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->deleteEjecucion()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Ejecucion eliminado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Ejecucion no pudo ser eliminado.";
    echo json_encode($respuesta);
}
