<?php

class Voiture
{

    private $conn;
    public $id;
    public $prix;
    public $kilometrage;
    public $annee_circulation;
    public $caracteristique;
    public $equipement;
    public $image;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getVoiture()
    {
        $sql = "SELECT id, prix, kilometrage, annee_circulation, caracteristique, equipement, image FROM voitures";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }


    public function createVoiture()
    {
        $sql = "INSERT INTO voitures 
                SET 
                    prix = :prix,
                    kilometrage = :kilometrage,
                    annee_circulation = :annee_circulation,
                    caracteristique = :caracteristique,
                    equipement = :equipement,
                    image = :image";
        $stmt = $this->conn->prepare($sql);

        $this->prix=htmlspecialchars(strip_tags(($this->prix)));
        $this->kilometrage=htmlspecialchars(strip_tags(($this->kilometrage)));
        $this->annee_circulation=htmlspecialchars(strip_tags(($this->annee_circulation)));
        $this->caracteristique=htmlspecialchars(strip_tags(($this->caracteristique)));
        $this->equipement=htmlspecialchars(strip_tags(($this->equipement)));
        $this->image=htmlspecialchars(strip_tags(($this->image)));
        
        $stmt->bindParam(":prix", $this->prix);
        $stmt->bindParam(":kilometrage", $this->kilometrage);
        $stmt->bindParam(":annee_circulation", $this->annee_circulation);
        $stmt->bindParam(":caracteristique", $this->caracteristique);
        $stmt->bindParam(":equipement", $this->equipement);
        $stmt->bindParam(":image", $this->image);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function singleVoiture() {
        $sql = "SELECT 
                    id, 
                    prix, 
                    kilometrage, 
                    annee_circulation, 
                    caracteristique, 
                    equipement, 
                    image 
                FROM 
                    voitures 
                WHERE 
                    id = ? 
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->prix = $dataRow['prix'];
        $this->kilometrage = $dataRow['kilometrage'];
        $this->annee_circulation = $dataRow['annee_circulation'];
        $this->caracteristique = $dataRow['caracteristique'];
        $this->equipement = $dataRow['equipement'];
        $this->image = $dataRow['image'];
    }

    public function updateVoiture() {
        $sql = "UPDATE voitures 
                SET 
                    prix = :prix,
                    kilometrage = :kilometrage,
                    annee_circulation = :annee_circulation,
                    caracteristique = :caracteristique,
                    equipement = :equipement,
                    image = :image
                WHERE
                    id= :id";

        $stmt = $this->conn->prepare($sql);

        $this->prix=htmlspecialchars(strip_tags(($this->prix)));
        $this->kilometrage=htmlspecialchars(strip_tags(($this->kilometrage)));
        $this->annee_circulation=htmlspecialchars(strip_tags(($this->annee_circulation)));
        $this->caracteristique=htmlspecialchars(strip_tags(($this->caracteristique)));
        $this->equipement=htmlspecialchars(strip_tags(($this->equipement)));
        $this->image=htmlspecialchars(strip_tags(($this->image)));
        $this->id=htmlspecialchars(strip_tags(($this->id)));

        
        $stmt->bindParam(":prix", $this->prix);
        $stmt->bindParam(":kilometrage", $this->kilometrage);
        $stmt->bindParam(":annee_circulation", $this->annee_circulation);
        $stmt->bindParam(":caracteristique", $this->caracteristique);
        $stmt->bindParam(":equipement", $this->equipement);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam("id", $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
    function deteleteVoiture() {
        $sql = "DELETE FROM voitures WHERE id= :id";

        $stmt = $this->conn->prepare($sql);
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
