<?php
include_once 'Connect.php';

class DatabaseTableCreateAvis
{
    public function creationTableCar()
    {
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {
            $tvsql = "CREATE TABLE IF NOT EXISTS AVIS (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                message VARCHAR(255) NOT NULL,
                note INT() NOT NULL
                
            )";         

            $conn->exec($tvsql);
            echo 'Table Avis crée avec succés :';
        } catch (PDOException $e) {
            echo $tvsql . "Connection Raté : azer" . $e->getMessage();
            exit;
        }

    }
}
$conn = null;