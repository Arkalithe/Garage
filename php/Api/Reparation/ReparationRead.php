<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");


include_once '../../Database/Connect.php';
include_once '../../Class/Reparation.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();
$items = new Reparation($db);
$stmt = $items->getReparation();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($row);