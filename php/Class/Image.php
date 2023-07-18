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

    public function getImage($voitureId)
    {
        $sql = "SELECT 
                    i.id, i.image_url                    
                FROM 
                    images i
                INNER JOIN voiture_images vi On i.id = vi.image_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $voitureId);
        $stmt->execute();
        return $stmt;
    }


    public function createImage($voitureId)
    {
        $sql = "INSERT INTO images (image_url) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->image_url);

        if ($stmt->execute()) {
            $imageId = $this->conn->lastInsertId();
            $this->linkImageToVoiture($imageId, $voitureId);
            return true;
        }
        return false;
    }

    private function linkImageToVoiture($imageId, $voitureId)
    {
        $sql = "INSERT INTO voiture_images (voiture_id, image_id) VALUES (:voiture_id, :image_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":voiture_id", $voitureId);
        $stmt->bindParam(":image_id", $imageId);
        $stmt->execute();
    }
    
    public function deleteImage($imageId)
    {
        $this->unlinkImageFromVoiture($imageId);
        $sql = "DELETE FROM images WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $imageId);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    private function unlinkImageFromVoiture($imageId)
    {
        $sql = "DELETE FROM voiture_images WHERE image_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $imageId);
        $stmt->execute();
    }

    public function getLastInsertedId()
    {
        return $this->conn->lastInsertId();
    }
}