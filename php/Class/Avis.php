<?php

class Avis
{

    private $conn;
    public $id;
    public $name;
    public $message;
    public $note;
    public $moderate;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAvis()
    {
        $sql = "SELECT id, name, message, note, moderate FROM avis";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }


    public function createAvis()
    {
        $sql = "INSERT INTO avis 
                SET
                    message = :message,
                    name = :name,
                    note = :note,
                    moderate = :moderate";
        $stmt = $this->conn->prepare($sql);

        $this->message = htmlspecialchars(strip_tags(($this->message)));
        $this->name = htmlspecialchars(strip_tags(($this->name)));
        $this->note = htmlspecialchars(strip_tags(($this->note)));
        $this->moderate = htmlspecialchars(strip_tags(($this->moderate)));

        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":note", $this->note);
        $stmt->bindParam(":moderate", $this->moderate);


        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function singleAvis()
    {
        $sql = "SELECT 
                    id, 
                    message, 
                    name,
                    note,
                    moderate
                FROM 
                    avis 
                WHERE 
                    id = ? 
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch();
        
        $this->name = $dataRow['name'];
        $this->message = $dataRow['message'];        
        $this->note = $dataRow['note'];
        $this->moderate = $dataRow['moderate'];
    }

    public function updateAvis()
    {
        $sql = "UPDATE avis 
                SET 
                    message = :message,
                    name = :name,
                    note = :note,
                    moderate = :moderate
                WHERE
                    id= :id";

        $stmt = $this->conn->prepare($sql);

        $this->message = htmlspecialchars(strip_tags(($this->message)));
        $this->name = htmlspecialchars(strip_tags(($this->name)));
        $this->id = htmlspecialchars(strip_tags(($this->id)));
        $this->note = htmlspecialchars(strip_tags(($this->note)));
        $this->moderate = htmlspecialchars(strip_tags(($this->moderate)));

        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam("id", $this->id);
        $stmt->bindParam(":note", $this->note);
        $stmt->bindParam(":moderate", $this->moderate);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    function deleteAvis()
    {
        $sql = "DELETE FROM avis WHERE id= :id";

        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
