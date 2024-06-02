<?php
include_once 'Connect.php';

class DatabaseTableCreateCar
{
    public function creationTableCar()
    {
        // Initialisation de la connexion à la base de données
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {
            // Table pour stocker les informations de base des voitures
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
            echo 'Table Voitures crée avec succès :<br>';

            // Table pour stocker les différentes caractéristiques des voitures
            $tcSql = "CREATE TABLE IF NOT EXISTS CARACTERISTIQUE (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                caracteristique VARCHAR(255) NOT NULL
            )";
            $conn->exec($tcSql);
            echo 'Table Caracteristique crée avec succès<br>';

            // Table pour stocker les URL des images des voitures
            $tiSql = "CREATE TABLE IF NOT EXISTS IMAGES (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                image_url VARCHAR(255) NOT NULL                        
            )";

            $conn->exec($tiSql);
            echo 'Table IMAGES crée avec succès<br>';

            // Table pour stocker les équipements des voitures
            $teSql = "CREATE TABLE IF NOT EXISTS EQUIPEMENT (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                equipement VARCHAR(255) NOT NULL
            )";

            $conn->exec($teSql);
            echo 'Table Equipement crée avec succès<br>';

            // Table pour lier les voitures et leurs caractéristiques
            $cvSql = "CREATE TABLE IF NOT EXISTS CVVOITURE (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                voiture_id INT NOT NULL,
                caracteristique_id INT NOT NULL,
                FOREIGN KEY (voiture_id) REFERENCES VOITURES(id),
                FOREIGN KEY (caracteristique_id) REFERENCES CARACTERISTIQUE(id)
            )";

            $conn->exec($cvSql);
            echo 'Table CVVOITURE crée avec succès<br>';
            
            // Table pour lier les voitures et leurs équipements
            $evSql = "CREATE TABLE IF NOT EXISTS EVVOITURE (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                voiture_id INT NOT NULL,
                equipement_id INT NOT NULL,
                FOREIGN KEY (voiture_id) REFERENCES VOITURES(id),
                FOREIGN KEY (equipement_id) REFERENCES EQUIPEMENT(id)
            )";

            $conn->exec($evSql);
            echo 'Table EVVOITURE crée avec succès<br>';
            
            // Table pour lier les voitures et leurs images
            $vtiSql = "CREATE TABLE IF NOT EXISTS VOITURE_IMAGES (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                voiture_id INT NOT NULL,
                image_id INT NOT NULL,
                FOREIGN KEY (voiture_id) REFERENCES VOITURES(id),
                FOREIGN KEY (image_id) REFERENCES IMAGES(id)
            )";

            $conn->exec($vtiSql);
            echo 'Table VOITURE_IMAGES crée avec succès<br>';
        } catch (PDOException $e) {
            echo $tvsql . "Connection Raté :" . $e->getMessage();
            exit;
        }
    }
}
$conn = null;
?>
