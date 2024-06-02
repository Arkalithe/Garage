<?php

class Horaire
{
    private $conn;
    public $id;
    public $day_id;
    public $heure_start;
    public $heure_fin;
    public $time_period;
    public $is_fermed;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Méthode pour obtenir tous les horaires
    public function getHoraire()
    {
        try {
            $sql = "SELECT id, day_id, heure_start, heure_fin, time_period, is_fermed FROM horaires";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention des horaires");
        }
    }

    // Méthode pour créer un nouvel horaire
    public function createHoraire()
    {
        try {
            $sql = "INSERT INTO horaires 
                    SET
                        day_id = :day_id,
                        heure_start = :heure_start, 
                        heure_fin = :heure_fin,
                        time_period = :time_period,
                        is_fermed = :is_fermed";
            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->day_id = htmlspecialchars(strip_tags($this->day_id));
            $this->heure_start = htmlspecialchars(strip_tags($this->heure_start));
            $this->heure_fin = htmlspecialchars(strip_tags($this->heure_fin));
            $this->time_period = htmlspecialchars(strip_tags($this->time_period));
            $this->is_fermed = htmlspecialchars(strip_tags($this->is_fermed));

            // Lier les paramètres
            $stmt->bindParam(":day_id", $this->day_id);
            $stmt->bindParam(":heure_start", $this->heure_start);
            $stmt->bindParam(":heure_fin", $this->heure_fin);
            $stmt->bindParam(":time_period", $this->time_period);
            $stmt->bindParam(":is_fermed", $this->is_fermed);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la création de l'horaire");
        }
    }

    // Méthode pour obtenir un seul horaire par son ID
    public function singleHoraire()
    {
        try {
            $sql = "SELECT 
                        id, 
                        day_id, 
                        heure_start, 
                        heure_fin,
                        time_period,
                        is_fermed
                    FROM 
                        horaires 
                    WHERE 
                        id = ? 
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dataRow) {
                $this->day_id = $dataRow['day_id'];
                $this->heure_start = $dataRow['heure_start'];
                $this->heure_fin = $dataRow['heure_fin'];
                $this->time_period = $dataRow['time_period'];
                $this->is_fermed = $dataRow['is_fermed'];
            } else {
                throw new Exception("Aucun horaire trouvé avec l'ID donné");
            }
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention de l'horaire");
        }
    }

    // Méthode pour mettre à jour un horaire existant
    public function updateHoraire()
    {
        try {
            $sql = "UPDATE horaires 
                    SET 
                        day_id = :day_id,
                        heure_start = :heure_start, 
                        heure_fin = :heure_fin,
                        time_period = :time_period,
                        is_fermed = :is_fermed
                    WHERE
                        id = :id";

            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->day_id = htmlspecialchars(strip_tags($this->day_id));
            $this->heure_start = htmlspecialchars(strip_tags($this->heure_start));
            $this->heure_fin = htmlspecialchars(strip_tags($this->heure_fin));
            $this->time_period = htmlspecialchars(strip_tags($this->time_period));
            $this->is_fermed = htmlspecialchars(strip_tags($this->is_fermed));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Lier les paramètres
            $stmt->bindParam(":day_id", $this->day_id);
            $stmt->bindParam(":heure_start", $this->heure_start);
            $stmt->bindParam(":heure_fin", $this->heure_fin);
            $stmt->bindParam(":time_period", $this->time_period);
            $stmt->bindParam(":is_fermed", $this->is_fermed);
            $stmt->bindParam(":id", $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la mise à jour de l'horaire");
        }
    }

    // Méthode pour supprimer un horaire existant
    public function deleteHoraire()
    {
        try {
            $sql = "DELETE FROM horaires WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":id", $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la suppression de l'horaire");
        }
    }
}
?>
