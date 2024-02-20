<?php
include_once 'Connect.php';

class AddDataUsers {

    
    public function dataUser(){
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {
            $users = [
                ['email' => 'employee@example.com', 'password' => 'Empl123*', 'role' => 'employee'],
                ['email' => 'test@example.com', 'password' => 'EmpltTest0*', 'role' => 'employee'],
                ['email' => 'mdp@example.com', 'password' => 'tmpMdp0*', 'role' => 'employee'],
                ['email' => 'momo@momo.momo', 'password' => 'Momomo0*', 'role' => 'admin'],
            ];

            foreach ($users as $user) {
                $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
                $insertSql = "INSERT INTO USERS (email, password, role) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($insertSql);
                $stmt->execute([$user['email'], $hashedPassword, $user['role']]);
            }
            echo 'Utilisateur ajouté .<br>';
            
        }
        catch(PDOException $e) {
            echo "Connection Raté: " . $e->getMessage();
            exit;
        }

    }
}