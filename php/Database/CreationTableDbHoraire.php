<?php
include_once 'Connect.php';

class DatabaseTableCreateHoraire
{
    public function creationTableHoraire()
    {
        // Initialisation de la connexion à la base de données
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnection();

        try {
            // Table pour stocker les informations de base des horaires
            $tsql = "CREATE TABLE IF NOT EXISTS HORAIRES (
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    day_id INT NOT NULL,
                    heure_start TIME,
                    heure_fin TIME,
                    time_period VARCHAR(255) NOT NULL,
                    is_fermed BOOLEAN NOT NULL DEFAULT FALSE
                    )";           

            $conn->exec($tsql);
            echo 'Table Horaires créée avec succès<br>';
        } catch (PDOException $e) {
            echo $tsql . " Connexion échouée : " . $e->getMessage();
            exit;
        }
    }
}
$conn = null;
?>
