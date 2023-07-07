<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: access");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../Database/Connect.php';

$db_connection = new DatabaseConnect();
$conn = $db_connection->dbConnectionNamed();
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
$role = "Employe";

if ($_SERVER["REQUEST_METHOD"] != "POST") :

    $returnData = msg(0, 404, 'Page Not Found');
    

elseif (
    !isset($data->email)
    || !isset($data->password)
    || empty(trim($data->password))
    || empty(trim($data->password))
) :

    $fields = ['fields' => ['email', 'password']];
    $returnData = msg(0, 422, 'Remplisez tous les champs requis', $fields);
    http_response_code(422);

else :
    $email = trim($data->email);
    $password = trim($data->password);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
        $returnData = msg(0, 422, 'Adresse Mail Invalid');
        http_response_code(422);
    elseif (strlen($password) < 8) :
        $returnData = msg(0, 422, 'Le mots de passe doit avoir au moins 8 caractere');
        http_response_code(422);
    else :
        try {
            $check_email = "SELECT `email` FROM `users` WHERE `email`=:email";
            $check_email_stmt = $conn->prepare($check_email);
            $check_email_stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $check_email_stmt->execute();
            if ($check_email_stmt->rowCount()) :
                $returnData = msg(0, 422, 'Cette adresse Mail est déja utilisé');
                http_response_code(422);
            else :
                $insert_query = "INSERT INTO `users`(`email`,`password`, role) VALUES(:email,:password,:role)";
                $insert_stmt = $conn->prepare($insert_query);


                $insert_stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $insert_stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
                $insert_stmt->bindValue(':role', $role, PDO::PARAM_STR);

                $insert_stmt->execute();
                $returnData = msg(1, 201, 'Employe ajouté reussie');
                http_response_code(201);

            endif;
        } catch (PDOException $e) {
            $returnData = msg(0, 500, $e->getMessage());
        }
    endif;
endif;
echo json_encode($returnData);
