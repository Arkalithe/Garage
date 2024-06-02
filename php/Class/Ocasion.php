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

    // Méthode pour obtenir toutes les voitures d'occasion
    public function getOcasion()
    {
        try {
            $sql = "SELECT id, title, intro, image FROM voitureoccasion";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention des voitures d'occasion");
        }
    }

    // Méthode pour créer une nouvelle voiture d'occasion
    public function createOcasion()
    {
        try {
            $sql = "INSERT INTO voitureoccasion 
                    SET
                        title = :title,
                        intro = :intro,
                        image = :image";
            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->intro = htmlspecialchars(strip_tags($this->intro));
            $this->image = htmlspecialchars(strip_tags($this->image));

            // Lier les paramètres
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":intro", $this->intro);
            $stmt->bindParam(":image", $this->image);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la création de la voiture d'occasion");
        }
    }

    // Méthode pour obtenir une seule voiture d'occasion par son ID
    public function singleOcasion()
    {
        try {
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
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dataRow) {
                $this->title = $dataRow['title'];
                $this->intro = $dataRow['intro'];
                $this->image = $dataRow['image'];
            } else {
                throw new Exception("Aucune voiture d'occasion trouvée avec l'ID donné");
            }
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention de la voiture d'occasion");
        }
    }

    // Méthode pour mettre à jour une voiture d'occasion existante
    public function updateOcasion()
    {
        try {
            $sql = "UPDATE voitureoccasion 
                    SET 
                        title = :title,
                        intro = :intro,
                        image = :image
                    WHERE
                        id = :id";

            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->intro = htmlspecialchars(strip_tags($this->intro));
            $this->image = htmlspecialchars(strip_tags($this->image));

            // Lier les paramètres
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":intro", $this->intro);
            $stmt->bindParam(":image", $this->image);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la mise à jour de la voiture d'occasion");
        }
    }

    // Méthode pour supprimer une voiture d'occasion existante
    public function deleteOcasion()
    {
        try {
            $sql = "DELETE FROM voitureoccasion WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":id", $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la suppression de la voiture d'occasion");
        }
    }
}
?>
