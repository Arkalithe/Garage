<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: access");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../Database/Connect.php';
include_once '../Class/Employe.php';
include_once '../AuthCheckRole.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$db_connection = new DatabaseConnect();
$db = $db_connection->dbConnection();
$employe = new Employee($db);

$headers = apache_request_headers();
authCheckRole($db, $headers, ['admin']);

function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        "success" => $success,
        "status" => $status,
        "message" => $message
    ], $extra);
}

$data = json_decode(file_get_contents("php://input"));
$returnData = [];
$role = "Employee";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $returnData = msg(0, 404, 'Page Not Found');
    http_response_code(404);
} elseif (
    !isset($data->email) ||
    !isset($data->password) ||
    empty(trim($data->email)) ||
    empty(trim($data->password))
) {
    $fields = ['fields' => ['email', 'password']];
    $returnData = msg(0, 422, 'Remplissez tous les champs requis', $fields);
    http_response_code(422);
} else {
    $email = trim($data->email);
    $password = trim($data->password);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $returnData = msg(0, 422, 'Adresse Mail Invalide');
        http_response_code(422);
    } elseif (strlen($password) < 8) {
        $returnData = msg(0, 422, 'Le mot de passe doit avoir au moins 8 caractères');
        http_response_code(422);
    } else {
        try {
            $user = $employe->getUserByEmail($email);

            if ($user) {
                $returnData = msg(0, 422, 'Cette adresse Mail est déjà utilisée');
                http_response_code(422);
            } else {
                $employe->email = $email;
                $employe->password = $password;
                $employe->role = $role;

                if ($employe->createUsers()) {
                    $returnData = msg(1, 201, 'Employé ajouté avec succès');
                    http_response_code(201);
                } else {
                    $returnData = msg(0, 500, 'Erreur lors de l\'ajout de l\'employé');
                    http_response_code(500);
                }
            }
        } catch (PDOException $e) {
            $returnData = msg(0, 500, $e->getMessage());
            http_response_code(500);
        }
    }
}

echo json_encode($returnData);

?>
