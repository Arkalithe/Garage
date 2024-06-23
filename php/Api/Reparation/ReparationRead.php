<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Reparation.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    http_response_code(200);
    exit();
}

$database = new DatabaseConnect();
$db = $database->dbConnection();
$items = new Reparation($db);
$stmt = $items->getReparation();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($row);
