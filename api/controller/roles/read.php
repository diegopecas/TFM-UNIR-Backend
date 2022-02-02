<?php
include_once '../../../config/cors.php';

include_once '../../service/roles.service.php';

$items = new RolesService();

$stmt = $items->getRoles();
$itemCount = $stmt->rowCount();
// echo $itemCount;

if ($itemCount > 0) {

    $arr = array();
    $arr["body"] = array();
    $arr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "id" => $id,
            "nombre" => $nombre
        );

        array_push($arr["body"], $e);
    }
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}

// echo 'ok';