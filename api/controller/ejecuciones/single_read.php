<?php
include_once '../../../config/cors.php';

include_once '../../service/roles.service.php';
include_once '../../model/rol.php';

$item = new RolesService();

$data = new Rol();

$data->id = isset($_GET['id']) ? $_GET['id'] : die();

$item->setIdRol($data->id);

$item->getSingleRol();

if ($item->getRol()->id != null) {
    // create array
    $emp_arr = array(
        "id" =>  $item->getRol()->id,
        "nombre" => $item->getRol()->nombre
    );

    http_response_code(200);
    echo json_encode($emp_arr);
} else {
    http_response_code(404);
    echo json_encode("Employee not found.");
}
