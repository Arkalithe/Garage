<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: access");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../Database/Connect.php';
include_once '../Class/JwtHandler.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$data = json_decode(file_get_contents("php://input"));

$returnData = [];

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $returnData = array(
        'success' => 0,
        'status' => 404,
        'message' => 'Page non trouvé'
    );
    http_response_code(404);

} elseif (!isset($data->email) || !isset($data->password) || empty(trim($data->email)) || empty(trim($data->password))) {
    $fields = ['fields' => ['email', 'password']];
    $returnData = array(
        'success' => 0,
        'status' => 422,
        'message' => 'Remplissez tous les champs !',
        'data' => $fields
    );
    http_response_code(422);

} else {
    $email = trim($data->email);
    $password = trim($data->password);
    

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $returnData = array(
            'success' => 0,
            'status' => 422,
            'message' => 'Adresse Email Invalid !'
        );
        http_response_code(422);
    }
    elseif (strlen($password) < 8) {
        $returnData = array(
            'success' => 0,
            'status' => 422,
            'message' => 'Le mot de passe doit avoir 8 caractères'
        );
        http_response_code(422);
    } else {
        $employee = new Employee($db);
        $employee->email = $email;
        $employee->singleUsers();

        if (!empty($employee->id)) {
            if (password_verify($password, $employee->password)) {

                $jwt = new JwtHandler();
                $accessToken = $jwt->jwtEncodeData(
                    'http://localhost',
                    array("id" => $employee->id, "role" => $employee->role)
                );
                
                $returnData = array(
                    'success' => 1,
                    'status' => 200,
                    'message' => 'Vous êtes connecté.',
                    'accessToken' => $accessToken 
                );
            } else {
                $returnData = array(
                    'success' => 0,
                    'status' => 422,
                    'message' => 'Mot de passe incorrect'
                );
                http_response_code(422);
            }
        } else {
            $returnData = array(
                'success' => 0,
                'status' => 422,
                'message' => 'Adresse Email incorrecte'
            );
            http_response_code(422);
        }
    }
}

echo json_encode($returnData);
