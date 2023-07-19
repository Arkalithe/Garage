<?php

class Ocasion
{

    private $conn;
    public $id;
    public $title;

    public $intro;
    public $image;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getOcasion()
    {
        $sql = "SELECT id, title, intro, image FROM voitureoccasion";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }


    public function createOcasion()
    {
        $sql = "INSERT INTO voitureoccasion 
                SET
                     = :,
                    title = :title,
                    intro = :intro,
                    image = :image";
        $stmt = $this->conn->prepare($sql);


        $this->title = htmlspecialchars(strip_tags(($this->title)));
        $this->intro = htmlspecialchars(strip_tags(($this->intro)));
        $this->image = htmlspecialchars(strip_tags(($this->image)));


        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":intro", $this->intro);
        $stmt->bindParam(":image", $this->image);


        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function singleOcasion()
    {
        $sql = "SELECT 
                    id, 
                    title,
                    intro,
                    image
                FROM 
                voitureoccasion 
                WHERE 
                    id = ? 
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch();
        
        $this->title = $dataRow['title'];
    
        $this->intro = $dataRow['intro'];
        $this->image = $dataRow['image'];
    }

    public function updateOcasion()
    {
        $sql = "UPDATE voitureoccasion 
                SET 
                    title = :title,
                    intro = :intro,
                    image = :image
                WHERE
                    id= :id";

        $stmt = $this->conn->prepare($sql);


        $this->title = htmlspecialchars(strip_tags(($this->title)));
        $this->id = htmlspecialchars(strip_tags(($this->id)));
        $this->intro = htmlspecialchars(strip_tags(($this->intro)));
        $this->image = htmlspecialchars(strip_tags(($this->image)));


        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam("id", $this->id);
        $stmt->bindParam(":intro", $this->intro);
        $stmt->bindParam(":image", $this->image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    function deleteOcasion()
    {
        $sql = "DELETE FROM voitureoccasion WHERE id= :id";

        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
