<?php
include_once 'Connect.php';


class DatabaseTableCreateUser
{
    public function creationTableUser()
    {
        // Initialisation de la connexion à la base de données
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {
            // Table pour stocker les informations de base des users
            $tsql = "CREATE TABLE IF NOT EXISTS USERS (
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    role VARCHAR(255) NOT NULL
                    )";           

            $conn->exec($tsql);
            echo 'Table EMPLOYE crée avec succés<br>';
        } catch (PDOException $e) {
            echo $tsql . "Connection Raté :" . $e->getMessage();
            exit;
        }

    }
}
$conn = null;
?>