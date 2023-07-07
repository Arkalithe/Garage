<?php
include_once 'Connect.php';

class DatabaseTableCreateCar
{
    public function creationTableCar()
    {
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {
            $tvsql = "CREATE TABLE IF NOT EXISTS VOITURES (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                prix INT(11) NOT NULL,
                kilometrage INT(11) NOT NULL,
                annee_circulation INT(4) NOT NULL,
                caracteristique VARCHAR(255),
                equipement VARCHAR(255),
                image VARCHAR(255) NOT NULL,
                modele  VARCHAR(255) NOT NULL,
                nom  VARCHAR(255) NOT NULL,
                prenom VARCHAR(255) NOT NULL,
                numero  VARCHAR(255) NOT NULL
            )";         

            $conn->exec($tvsql);
            echo 'Table Voitures crée avec succés :';
        } catch (PDOException $e) {
            echo $tvsql . "Connection Raté : azer" . $e->getMessage();
            exit;
        }

    }
}
$conn = null;