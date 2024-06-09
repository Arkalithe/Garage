<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");
include_once '../../Database/Connect.php';
include_once '../../Class/Employe.php';
include_once '../../AuthCheckRole.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    http_response_code(200);
    exit();
}

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$headers = apache_request_headers();
authCheckRole($conn, $headers, ['admin']);

$employee = new Employee($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->ids)) {
    $ids = $data->ids;

    $successCount = 0;
    $errorCount = 0;

    foreach ($ids as $id) {
        $employee->id = $id;
        $employee->singleUsers();
        if ($employee->role !== 'Admin') { 
            if ($employee->deleteUsers()) {
                $successCount++;
            } else {
                $errorCount++;
            }
        }
    }

    $response = [
        "message" => "Deleted users successfully.",
        "successCount" => $successCount,
        "errorCount" => $errorCount
    ];

    echo json_encode($response);
} else {
    echo json_encode("No user IDs provided.");
}