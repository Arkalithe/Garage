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
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                prix INT NOT NULL,
                kilometrage INT NOT NULL,
                annee_circulation INT NOT NULL,
                modele VARCHAR(255) NOT NULL,
                nom VARCHAR(255) NOT NULL,
                prenom VARCHAR(255) NOT NULL,
                numero VARCHAR(255) NOT NULL    
            )";

            $conn->exec($tvsql);
            echo 'Table Voitures crée avec succés :<br>';

            $tcSql = "CREATE TABLE IF NOT EXISTS CARACTERISTIQUE (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                caracteristique VARCHAR(255) NOT NULL
            )";
            $conn->exec($tcSql);
            echo 'Table Caracteristique crée avec succès<br>';

            $tiSql = "CREATE TABLE IF NOT EXISTS IMAGES (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                image BLOB NOT NULL                        
            )";

            $conn->exec($tiSql);
            echo 'Table IMAGES crée avec succès<br>';

            $teSql = "CREATE TABLE IF NOT EXISTS EQUIPEMENT (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                equipement VARCHAR(255) NOT NULL
            )";

            $conn->exec($teSql);
            echo 'Table Equipement crée avec succès<br>';

            $cvSql = "CREATE TABLE IF NOT EXISTS CVVOITURE (
                voiture_id INT NOT NULL,
                caracteristique_id INT NOT NULL,
                FOREIGN KEY (voiture_id) REFERENCES VOITURES(id),
                FOREIGN KEY (caracteristique_id) REFERENCES CARACTERISTIQUE(id)
            )";

            $conn->exec($cvSql);
            echo 'Table CVVOITURE crée avec succès<br>';

            $evSql = "CREATE TABLE IF NOT EXISTS EVVOITURE (
                voiture_id INT NOT NULL,
                equipement_id INT NOT NULL,
                FOREIGN KEY (voiture_id) REFERENCES VOITURES(id),
                FOREIGN KEY (equipement_id) REFERENCES EQUIPEMENT(id)
            )";

            $conn->exec($evSql);
            
            echo 'Table EVVOITURE crée avec succès<br>';

        } catch (PDOException $e) {
            echo $tvsql . "Connection Raté :" . $e->getMessage();
            exit;
        }
    }
}
$conn = null;
