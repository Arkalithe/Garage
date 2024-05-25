<?php
include_once 'Connect.php';

class AddDataHoraire
{
    public function dataHoraire()
    {
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {
            $horaires = [
                ['jour' => 'Lundi', 'matin' => '08:45 - 12:00', 'apresmidi' => '14:00 - 18:00'],
                ['jour' => 'Samedi', 'matin' => '08:45 - 12:00',  'apresmidi' => '14:00 - 18:00'],
                ['jour' => 'Mardi', 'matin' => '08:45 - 12:00', 'apresmidi' => '14:00 - 18:00'],
                ['jour' => 'Mercredi', 'matin' => '08:45 - 12:00',  'apresmidi' => '14:00 - 18:00'],
                ['jour' => 'Jeudi', 'matin' => '08:45 - 12:00',  'apresmidi' => '14:00 - 18:00'],
                ['jour' => 'Vendredi', 'matin' => '08:45 - 12:00', 'apresmidi' => '14:00 - 18:00'],
                ['jour' => 'Dimanche', 'matin' => 'Fermé', "apresmidi" => '']
            ];

            $stmt = $conn->prepare("INSERT INTO HORAIRES (jour, matin, apresmidi)
                VALUES (?, ?, ?)");

            foreach ($horaires as $data) {
                
                $stmt->execute([$data['jour'], $data['matin'], $data['apresmidi']]);
                echo 'Horaire ajouté .<br>';
            }
        } catch (PDOException $e) {
            echo "Connection Raté: " . $e->getMessage();
            exit;
        }
    }
}
?>