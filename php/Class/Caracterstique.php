<?php

class Caracteristique
{

    private $conn;
    public $id;
    public $caracteristique;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCaracteristique($voitureId)
    {
        $sql = "SELECT 
                    c.id, c.caracteristique
                FROM 
                    caracteristique c
                INNER JOIN cvvoiture vi On i.id = vi.caracteristique_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $voitureId);
        $stmt->execute();
        return $stmt;
    }


    public function createCaracteristique($voitureId)
    {
        $sql = "INSERT INTO caracteristique (caracteristique) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->caracteristique);

        if ($stmt->execute()) {
            $caracteristiqueId = $this->conn->lastInsertId();
            $this->linkCaracteristiqueToVoiture($caracteristiqueId, $voitureId);
            return true;
        }
        return false;
    }

    private function linkCaracteristiqueToVoiture($caracteristiqueId, $voitureId)
    {
        $sql = "INSERT INTO cvvoiture (voiture_id, caracteristique_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $voitureId);
        $stmt->bindParam(2, $caracteristiqueId);
        $stmt->execute();
    }

    public function deleteCaracteristique($caracteristiqueId)
    {
        $this->unlinkCaracteristiqueFromVoiture($caracteristiqueId);
        $sql = "DELETE FROM caracteristique WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $caracteristiqueId);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    private function unlinkCaracteristiqueFromVoiture($caracteristiqueId)
    {
        $sql = "DELETE FROM cvvoiture WHERE caracteristique_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $caracteristiqueId);
        $stmt->execute();
    }
}
