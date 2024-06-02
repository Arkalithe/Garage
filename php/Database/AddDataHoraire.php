<?php
include_once 'Connect.php';

class AddDataHoraire
{
    public function dataHoraire()
    {
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {
            // Données à insérer dans la table HORAIRES
            $horaires = [
                ['day_id' => 1, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
                ['day_id' => 2, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
                ['day_id' => 3, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
                ['day_id' => 4, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
                ['day_id' => 5, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
                ['day_id' => 6, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
                ['day_id' => 7, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => true],

                ['day_id' => 2, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
                ['day_id' => 3, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
                ['day_id' => 4, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
                ['day_id' => 1, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
                ['day_id' => 5, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
                ['day_id' => 6, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
                ['day_id' => 7, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Afternoon', 'is_fermed' => true],
                
            ];

            // Préparation de la requête d'insertion
            $sql = "INSERT INTO HORAIRES (day_id, heure_start, heure_fin, time_period, is_fermed) 
                    VALUES (:day_id, :heure_start, :heure_fin, :time_period, :is_fermed)";
            
            $stmt = $conn->prepare($sql);
            
            // Boucle pour insérer chaque horaire
            foreach ($horaires as $horaire) {
                $stmt->bindParam(':day_id', $horaire['day_id']);
                $stmt->bindParam(':heure_start', $horaire['heure_start']);
                $stmt->bindParam(':heure_fin', $horaire['heure_fin']);
                $stmt->bindParam(':time_period', $horaire['time_period']);
                $stmt->bindParam(':is_fermed', $horaire['is_fermed'], PDO::PARAM_BOOL);
                $stmt->execute();
            }

            echo 'Table Horaires peuplée avec succès<br>';
        } catch (PDOException $e) {
            echo "Connexion échouée : " . $e->getMessage();
            exit;
        }
    }
}
?>