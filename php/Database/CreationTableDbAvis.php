<?php
include_once 'Connect.php';

class DatabaseTableCreateAvis
{
    public function creationTableAvis()
    {
        // Initialisation de la connexion à la base de données
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnection();

        try {
            // Table pour stocker les informations de base des avis
            $tvsql = "CREATE TABLE IF NOT EXISTS AVIS (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                message VARCHAR(255) NOT NULL,
                note INT NOT NULL,
                moderate INT NOT NULL                
            )";         

            $conn->exec($tvsql);
            echo 'Table Avis crée avec succés :<br>';
        } catch (PDOException $e) {
            echo $tvsql . "Connection Raté : " . $e->getMessage();
            exit;
        }

    }
}
$conn = null;
?>