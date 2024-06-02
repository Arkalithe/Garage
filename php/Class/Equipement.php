<?php

class Equipement
{
    private $conn;
    public $id;
    public $equipement;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Méthode pour obtenir les équipements associés à une voiture
    public function getEquipement($voitureId)
    {
        try {
            $sql = "SELECT 
                        e.id, e.equipement
                    FROM 
                        equipement e
                    INNER JOIN evvoiture ev ON e.id = ev.equipement_id
                    WHERE ev.voiture_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $voitureId);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention des équipements");
        }
    }

    // Méthode pour créer un nouvel équipement et l'associer à une voiture
    public function createEquipement($voitureId)
    {
        try {
            $sql = "INSERT INTO equipement (equipement) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $this->equipement);

            if ($stmt->execute()) {
                $equipementId = $this->conn->lastInsertId();
                $this->linkEquipementToVoiture($equipementId, $voitureId);
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la création de l'équipement");
        }
    }

    // Méthode privée pour lier un équipement à une voiture
    private function linkEquipementToVoiture($equipementId, $voitureId)
    {
        try {
            $sql = "INSERT INTO evvoiture (voiture_id, equipement_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $voitureId);
            $stmt->bindParam(2, $equipementId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la liaison de l'équipement à la voiture");
        }
    }

    // Méthode pour supprimer un équipement
    public function deleteEquipement($equipementId)
    {
        try {
            $this->unlinkEquipementFromVoiture($equipementId);
            $sql = "DELETE FROM equipement WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $equipementId);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la suppression de l'équipement");
        }
    }

    // Méthode privée pour dissocier un équipement d'une voiture
    private function unlinkEquipementFromVoiture($equipementId)
    {
        try {
            $sql = "DELETE FROM evvoiture WHERE equipement_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $equipementId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la dissociation de l'équipement de la voiture");
        }
    }
}
?>
