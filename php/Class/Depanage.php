<?php

class Depanage
{

    private $conn;
    public $id;
    public $title;
    public $message;
    public $intro;
    public $image;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getDepanage()
    {
        $sql = "SELECT id, title, message, intro, image FROM Depannage";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }


    public function createDepanage()
    {
        $sql = "INSERT INTO Depannage 
                SET
                    message = :message,
                    title = :title,
                    intro = :intro,
                    image = :image";
        $stmt = $this->conn->prepare($sql);

        $this->message = htmlspecialchars(strip_tags(($this->message)));
        $this->title = htmlspecialchars(strip_tags(($this->title)));
        $this->intro = htmlspecialchars(strip_tags(($this->intro)));
        $this->image = htmlspecialchars(strip_tags(($this->image)));

        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":intro", $this->intro);
        $stmt->bindParam(":image", $this->image);


        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function singleDepanage()
    {
        $sql = "SELECT 
                    id, 
                    message, 
                    title,
                    intro,
                    image
                FROM 
                    Depannage 
                WHERE 
                    id = ? 
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch();
        
        $this->title = $dataRow['title'];
        $this->message = $dataRow['message'];        
        $this->intro = $dataRow['intro'];
        $this->image = $dataRow['image'];
    }

    public function updateDepanage()
    {
        $sql = "UPDATE Depannage 
                SET 
                    message = :message,
                    title = :title,
                    intro = :intro,
                    image = :image
                WHERE
                    id= :id";

        $stmt = $this->conn->prepare($sql);

        $this->message = htmlspecialchars(strip_tags(($this->message)));
        $this->title = htmlspecialchars(strip_tags(($this->title)));
        $this->id = htmlspecialchars(strip_tags(($this->id)));
        $this->intro = htmlspecialchars(strip_tags(($this->intro)));
        $this->image = htmlspecialchars(strip_tags(($this->image)));

        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":intro", $this->intro);
        $stmt->bindParam(":image", $this->image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    function deleteDepanage()
    {
        $sql = "DELETE FROM Depannage WHERE id= :id";

        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
