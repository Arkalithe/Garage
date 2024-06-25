<?php
include_once 'Connect.php';

class AddDataUsers {

    
    public function dataUser(){
        // Initialisation de la connexion à la base de données
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnection();

        try {
            $users = [
                // Liste des utilisateurs à ajouter
                ['email' => 'employee@example.com', 'password' => 'Empl123*', 'role' => 'employee'],
                ['email' => 'test@example.com', 'password' => 'EmpltTest0*', 'role' => 'employee'],
                ['email' => 'mdp@example.com', 'password' => 'tmpMdp0*', 'role' => 'employee'],
                ['email' => 'momo@momo.momo', 'password' => 'Momomo0*', 'role' => 'admin'],
            ];

            
            foreach ($users as $user) {
                // Hachage du mot de passe pour des raisons de sécurité
                $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
                // Requête SQL pour insérer les données de l'utilisateur
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
?>