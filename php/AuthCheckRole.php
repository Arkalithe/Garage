<?php
include_once __DIR__ .'/AuthMiddleware.php';

function authCheckRole($db, $headers, $requiredRoles)
{
    $auth = new AuthMiddleware($db, $headers);
    $authResult = $auth->isValide();

    if ($authResult['success'] === 0) {
        http_response_code(403);
        echo json_encode(["success" => 0, "message" => "Accès refusé : rôle insuffisant", "details" => $authResult]);
        exit();
    }

    if (is_object($authResult['data']) && property_exists($authResult['data'], 'role')) {
        $userRole = $authResult['data']->role;
    } else {
        http_response_code(403);
        echo json_encode(["success" => 0, "message" => "Accès refusé : rôle manquant"]);
        exit();
    }

    if (!in_array($userRole, $requiredRoles)) {
        http_response_code(403);
        echo json_encode(["success" => 0, "message" => "Accès refusé : rôle insuffisant"]);
        exit();
    }
}