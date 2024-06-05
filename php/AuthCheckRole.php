<?php
include_once './AuthCheckRole.php';


function authCheckRole($db, $header, $requiredRoles)
{
    $auth = new Auth($db, $header);
    $authResult = $auth->isValide(null);

    if ($authResult['sucess'] === 0) {
        http_response_code(403);
        echo json_encode(["success" => 0, "message" => "Accès refusé : rôle insuffisant", "details" => $authResult]);
        exit();
    }

    $userRole = $authResult['data']->role;

    if (!in_array($userRole, $requiredRoles)) {
        http_response_code(403);
        echo json_encode(["success" => 0, "message" => "Accès refusé : rôle insuffisant"]);
        exit();
    }
}
