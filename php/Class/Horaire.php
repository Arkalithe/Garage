<?php

class Horaire
{

    private $conn;
    public $id;
    public $jour;
    public $matin;
    public $apresmidi;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getHoraire()
    {
        $sql = "SELECT id, 
                    jour, matin, apresmidi
                FROM 
                    horaires";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }


    public function createHoraire()
    {
        $sql = "INSERT INTO horaires 
                SET
                    jour = :jour,
                    matin = :matin, 
                    apresmidi = :apresmidi,
                    ";
        $stmt = $this->conn->prepare($sql);
        $this->jour = htmlspecialchars(strip_tags(($this->jour)));
        $this->matin = htmlspecialchars(strip_tags(($this->matin)));
        $this->apresmidi = htmlspecialchars(strip_tags(($this->apresmidi)));
 

        $stmt->bindParam(":jour", $this->jour);
        $stmt->bindParam(":matin", $this->matin);
        $stmt->bindParam(":apresmidi", $this->apresmidi);


        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function singleHoraire()
    {
        $sql = "SELECT 
                    id, 
                    jour, matin, apresmidi,
                FROM 
                    horaires 
                WHERE 
                    id = ? 
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch();

        $this->matin = $dataRow['jour'];
        $this->matin = $dataRow['matin'];
        $this->apresmidi = $dataRow['apresmidi'];
    }

    public function updateHoraire()
    {
        $sql = "UPDATE horaires 
                SET 
                    jour = :jour,
                    matin = :matin, 
                    apresmidi = :apresmidi
                WHERE
                    id = :id";
    
        $stmt = $this->conn->prepare($sql);
    
        $this->jour = htmlspecialchars(strip_tags(($this->jour)));
        $this->matin = htmlspecialchars(strip_tags(($this->matin)));
        $this->apresmidi = htmlspecialchars(strip_tags(($this->apresmidi)));
        $this->id = htmlspecialchars(strip_tags(($this->id)));
    
        $stmt->bindParam(":jour", $this->jour);
        $stmt->bindParam(":matin", $this->matin);
        $stmt->bindParam(":apresmidi", $this->apresmidi);
        $stmt->bindParam(":id", $this->id);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    function deteleteHoraire()
    {
        $sql = "DELETE FROM horaires WHERE id= :id";

        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
