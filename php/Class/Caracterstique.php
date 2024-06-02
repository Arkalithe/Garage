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

    // Méthode pour obtenir les caractéristiques associées à une voiture
    public function getCaracteristique($voitureId)
    {
        try {
            $sql = "SELECT 
                        c.id, c.caracteristique
                    FROM 
                        caracteristique c
                    INNER JOIN cvvoiture cv ON c.id = cv.caracteristique_id
                    WHERE cv.voiture_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $voitureId);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention des caractéristiques");
        }
    }

    // Méthode pour créer une nouvelle caractéristique et l'associer à une voiture
    public function createCaracteristique($voitureId)
    {
        try {
            $sql = "INSERT INTO caracteristique (caracteristique) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $this->caracteristique);

            if ($stmt->execute()) {
                $caracteristiqueId = $this->conn->lastInsertId();
                $this->linkCaracteristiqueToVoiture($caracteristiqueId, $voitureId);
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la création de la caractéristique");
        }
    }

    // Méthode privée pour lier une caractéristique à une voiture
    private function linkCaracteristiqueToVoiture($caracteristiqueId, $voitureId)
    {
        try {
            $sql = "INSERT INTO cvvoiture (voiture_id, caracteristique_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $voitureId);
            $stmt->bindParam(2, $caracteristiqueId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la liaison de la caractéristique à la voiture");
        }
    }

    // Méthode pour supprimer une caractéristique
    public function deleteCaracteristique($caracteristiqueId)
    {
        try {
            $this->unlinkCaracteristiqueFromVoiture($caracteristiqueId);
            $sql = "DELETE FROM caracteristique WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $caracteristiqueId);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la suppression de la caractéristique");
        }
    }

    // Méthode privée pour dissocier une caractéristique d'une voiture
    private function unlinkCaracteristiqueFromVoiture($caracteristiqueId)
    {
        try {
            $sql = "DELETE FROM cvvoiture WHERE caracteristique_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $caracteristiqueId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la dissociation de la caractéristique de la voiture");
        }
    }
}
?>
