<?php
include_once 'Connect.php';

class DatabaseContent
{
    public function creationContent()
    {
        // Initialisation de la connexion à la base de données
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnection();

        try {
            // Table pour stocker les informations des réparations
            $trrsql = "CREATE TABLE IF NOT EXISTS reparation (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                intro VARCHAR(1000) NOT NULL,
                message VARCHAR(10000) NOT NULL,
                image VARCHAR(255) NOT NULL                
            )";

            $conn->exec($trrsql);
            echo 'Table reparation crée avec succés :<br>';

            // Table pour stocker les informations des dépannages
            $tvsql = "CREATE TABLE IF NOT EXISTS depannage (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                intro VARCHAR(1000) NOT NULL,
                message VARCHAR(10000) NOT NULL,
                image VARCHAR(255) NOT NULL
                
            )";

            $conn->exec($tvsql);
            echo 'Table depannage crée avec succés :<br>';

            // Table pour stocker les informations des voitures d'occasion
            $tvsql = "CREATE TABLE IF NOT EXISTS voitureOccasion (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                intro VARCHAR(1000) NOT NULL,
                image VARCHAR(255) NOT NULL
                
            )";

            $conn->exec($tvsql);
            echo 'Table voitureOccasion crée avec succés :<br>';
        } catch (PDOException $e) {
            echo $trrsql . "Connection Raté : " . $e->getMessage();
            exit;
        }
    }
}
$conn = null;
