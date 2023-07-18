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

    public function getEquipement($voitureId)
    {
        $sql = "SELECT 
                    e.id, e.equipement
                FROM 
                    equipement e
                INNER JOIN evvoiture ev On e.id = ev.equipement_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $voitureId);
        $stmt->execute();
        return $stmt;
    }


    public function createEquipement($voitureId)
    {
        $sql = "INSERT INTO equipement (equipement) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->equipement);

        if ($stmt->execute()) {
            $equipementId = $this->conn->lastInsertId();
            $this->linkEquipementToVoiture($equipementId, $voitureId);
            return true;
        }
        return false;
    }

    private function linkEquipementToVoiture($equipementId, $voitureId)
    {
        $sql = "INSERT INTO evvoiture (voiture_id, equipement_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $voitureId);
        $stmt->bindParam(2, $equipementId);
        $stmt->execute();
    }

  
    
    public function deleteEquipement($equipementId)
    {
        $this->unlinkEquipementFromVoiture($equipementId);
        $sql = "DELETE FROM equipement WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $equipementId);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    private function unlinkEquipementFromVoiture($equipementId)
    {
        $sql = "DELETE FROM evvoiture WHERE equipement_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $equipementId);
        $stmt->execute();
    }
}
