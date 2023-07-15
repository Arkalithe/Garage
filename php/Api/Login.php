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

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}



$data = json_decode(file_get_contents("php://input"));

$returnData = [];

if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page non trouvé');    

elseif(!isset($data->email) 
    || !isset($data->password)

    || empty(trim($data->email))
    || empty(trim($data->password))

    ):

    $fields = ['fields' => ['email','password', 'role']];
    $returnData = msg(0,422,'Remplissez tous les champs !',$fields);
    http_response_code(422);

else:
    $email = trim($data->email);
    $password = trim($data->password);


    if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
        $returnData = msg(0,422,'Adresse Email Invalid ! ');
        http_response_code(422);

    elseif(strlen($password) < 8):
        $returnData = msg(0,422,'Le mot de passe doit avoire 8 caracatère, une majuscule, un chiffre et un caractère spécial');
        http_response_code(422);

    else:
        try{

            $fetch_user_by_email = "SELECT * FROM `users` WHERE `email`=:email";
            $query_stmt = $db->prepare($fetch_user_by_email);
            $query_stmt->bindValue(':email', $email,PDO::PARAM_STR);            
            $query_stmt->execute();

            if($query_stmt->rowCount()):
                $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
                $check_password = password_verify($password, $row['password']);                

                if($check_password):

                    $jwt = new JwtHandler();

                    $accessToken = $jwt->jwtEncodeData(
                        'http://localhost',
                        array("id"=> $row['id'], "role"=>$row['role'])
                    );

                    $returnData = [
                        'success' => 1,
                        'message' => 'Vous êtes connecté.',
                        'accessToken' => $accessToken,


                    ];                    

                else:
                    $returnData = msg(0,422,'Mot de passe Incorect');
                    http_response_code(422);
                endif;


            else:
                $returnData = msg(0,422,'Addresse Email Incorect!');
                http_response_code(422);
            endif;
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
            http_response_code(500);
        }

    endif;

endif;

echo json_encode(array( $accessToken));