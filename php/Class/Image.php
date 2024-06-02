<?php

class Image
{
    private $conn;
    public $id;
    public $image_url;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Méthode pour obtenir les images associées à une voiture
    public function getImage($voitureId)
    {
        try {
            $sql = "SELECT 
                        i.id, i.image_url                    
                    FROM 
                        images i
                    INNER JOIN voiture_images vi ON i.id = vi.image_id
                    WHERE vi.voiture_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $voitureId);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention des images");
        }
    }

    // Méthode pour créer une nouvelle image et l'associer à une voiture
    public function createImage($voitureId)
    {
        try {
            $sql = "INSERT INTO images (image_url) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $this->image_url);

            if ($stmt->execute()) {
                $imageId = $this->conn->lastInsertId();
                $this->linkImageToVoiture($imageId, $voitureId);
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la création de l'image");
        }
    }

    // Méthode privée pour lier une image à une voiture
    private function linkImageToVoiture($imageId, $voitureId)
    {
        try {
            $sql = "INSERT INTO voiture_images (voiture_id, image_id) VALUES (:voiture_id, :image_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":voiture_id", $voitureId);
            $stmt->bindParam(":image_id", $imageId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la liaison de l'image à la voiture");
        }
    }

    // Méthode pour supprimer une image
    public function deleteImage($imageId)
    {
        try {
            $this->unlinkImageFromVoiture($imageId);
            $sql = "DELETE FROM images WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $imageId);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la suppression de l'image");
        }
    }

    // Méthode privée pour dissocier une image d'une voiture
    private function unlinkImageFromVoiture($imageId)
    {
        try {
            $sql = "DELETE FROM voiture_images WHERE image_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $imageId);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la dissociation de l'image de la voiture");
        }
    }

    // Méthode pour obtenir l'ID du dernier enregistrement inséré
    public function getLastInsertedId()
    {
        return $this->conn->lastInsertId();
    }
}
?>
