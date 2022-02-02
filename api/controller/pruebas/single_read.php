<?php
include_once '../../../config/cors.php';

include_once '../../service/pruebas.service.php';
include_once '../../model/prueba.php';

$item = new PruebasService();

$data = new Prueba();

$data->id = isset($_GET['id']) ? $_GET['id'] : die();

$item->setIdPrueba($data->id);

$item->getSinglePrueba();

if ($item->getPrueba()->id != null) {
    // create array
    $emp_arr = array(
        "id" =>  $item->getPrueba()->id,
        "nombre" => $item->getPrueba()->nombre,
        "estado" => $item->getPrueba()->estado,
        "descripcion" => $item->getPrueba()->descripcion
    );

    http_response_code(200);
    echo json_encode(array("body" => $emp_arr));
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}
