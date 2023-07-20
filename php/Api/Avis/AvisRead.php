<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Avis.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();
$items = new Avis($db);
$stmt = $items->getAvis();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($row);
