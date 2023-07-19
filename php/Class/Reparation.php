<?php

class Reparation
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

    public function getReparation()
    {
        $sql = "SELECT id, title, message, intro, image FROM Reparation";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }


    public function createReparation()
    {
        $sql = "INSERT INTO Reparation 
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

    public function singleReparation()
    {
        $sql = "SELECT 
                    id, 
                    message, 
                    title,
                    intro,
                    image
                FROM 
                    Reparation 
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

    public function updateReparation()
    {
        $sql = "UPDATE Reparation 
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
    function deleteReparation()
    {
        $sql = "DELETE FROM Reparation WHERE id= :id";

        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
