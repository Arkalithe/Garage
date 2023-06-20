<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require './Database/Connect.php';
include_once './Database/InitDb.php';

$db_connection = New DatabaseConnect();
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

if ($_SERVER["REQUEST_METHOD"] != "POST" ) :

    $returnData = msg(0, 404, 'Page Not Found');

elseif(
    !isset($data->email)
    || !isset($data->password)
    || empty(trim($data->password))
    || empty(trim($data->password))
) :

$fields = ['fields' => [ 'email', 'password']];
$returnData = msg(0, 422, 'Remplisez tous les champs requis', $fields);

else : 
    $email = trim($data->email);
    $password = trim($data->password);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) :
        $returnData = msg(0, 422, 'Adresse Mail Invalid');
        elseif (strlen($password) < 8) :
            $returnData = msg(0, 422, 'Le mots de passe doit avoir au moins 8 caractere');

            else : 
                try{
                    $check_email = "SELECT `email` FROM `users` WHERE `email`=:email";
                    $check_email_stmt = $conn->prepare($check_email);
                    $check_email_stmt->bindValue(':email', $email, PDO::PARAM_STR);
                    $check_email_stmt->execute();
                    if ($check_email_stmt->rowCount()) :
                        $returnData = msg(0, 422, 'Cette adresse Mail est déja utilisé');
                        else : 
                            $insert_query = "INSERT INTO `users`(`email`,`password`) VALUES(:email,:password)";
                            $insert_stmt = $conn->prepare($insert_query);


                            $insert_stmt->bindValue(':email', $email, PDO::PARAM_STR);
                            $insert_stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            
                            $insert_stmt->execute();            
                            $returnData = msg(1, 201, 'Employe ajouté reussie');

                        endif;            
                } catch (PDOException $e) {
                    $returnData = msg(0, 500, $e->getMessage());
                }
            endif;
        endif;
echo json_encode($returnData);

