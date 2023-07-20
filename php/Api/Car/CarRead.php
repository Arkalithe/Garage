<?php

header("Access-Control-Allow-Origin: https://main--imaginative-lollipop-cdaa75.netlify.app/");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");


include_once '../../Database/Connect.php';
include_once '../../Class/Voiture.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();
$items = new Voiture($db);
$stmt = $items->getVoiture();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($row);
