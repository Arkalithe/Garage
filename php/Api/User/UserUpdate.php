<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: plain/text');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Employe.php';
include_once '../AuthCheckRole.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$headers = apache_request_headers();
authCheckRole($conn, $headers, ['admin']);

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