<?php
header('Content-Type: application/json');

//if request is POST method
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //get raw body
    $json = file_get_contents('php://input');
    //decode JSON as array
    $data = json_decode($json, true);
    //pack array in JSON with additional received
    echo json_encode(['received' => $data]);
}

?>