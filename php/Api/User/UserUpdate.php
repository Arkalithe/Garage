<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: plain/text');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Employe.php';
include_once '../../AuthCheckRole.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    http_response_code(200);
    exit();
}

$database = new DatabaseConnect();
$db = $database->dbConnection();

$headers = apache_request_headers();
authCheckRole($db, $headers, ['admin']);

$employee = new Employee($db);
$data = json_decode(file_get_contents("php://input"));


$employee->id = $data->id;
$employee->email = $data->email;
$employee->password = $data->password;
$employee->role = $data->role;

if($employee->updateUsers()) {
    echo json_encode("Utilisateur modifier");
} else {
    echo json_encode("Problème modification utilisiteure");
}