<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    http_response_code(200);
    exit();
}

include_once '../../Database/Connect.php';
include_once '../../Class/Ocasion.php';

$database = new DatabaseConnect();
$db = $database->dbConnection();
$items = new Ocasion($db);
$stmt = $items->getOcasion();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($row);
