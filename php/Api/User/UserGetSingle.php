<?php

header("Access-Control-Allow-Origin: https://imaginative-lollipop-cdaa75.netlify.app");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: plain/text');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");


include_once '../../Database/Connect.php';
include_once '../../Class/Employe.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();
$items = new Employee($db);
$items->id = isset($_GET['id']) ? $_GET['id'] : die();

$items->singleUsers();

if($items->id != null){
    $arr = array(
        "id" => $items->id,
        "email" => $items->email,
        "password" => $items->password,
        "role" => $items->role
    );
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode("Utilisateure Introuvable.");
}
