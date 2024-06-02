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

    // Méthode pour obtenir toutes les entrées de dépannage
    public function getDepanage()
    {
        try {
            $sql = "SELECT id, title, message, intro, image FROM Depannage";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention des dépannages");
        }
    }

    // Méthode pour créer une nouvelle entrée de dépannage
    public function createDepanage()
    {
        try {
            $sql = "INSERT INTO Depannage 
                    SET
                        message = :message,
                        title = :title,
                        intro = :intro,
                        image = :image";
            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->message = htmlspecialchars(strip_tags($this->message));
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->intro = htmlspecialchars(strip_tags($this->intro));
            $this->image = htmlspecialchars(strip_tags($this->image));

            // Lier les paramètres
            $stmt->bindParam(":message", $this->message);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":intro", $this->intro);
            $stmt->bindParam(":image", $this->image);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la création du dépannage");
        }
    }

    // Méthode pour obtenir une seule entrée de dépannage par son ID
    public function singleDepanage()
    {
        try {
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
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dataRow) {
                $this->title = $dataRow['title'];
                $this->message = $dataRow['message'];
                $this->intro = $dataRow['intro'];
                $this->image = $dataRow['image'];
            } else {
                throw new Exception("Aucun dépannage trouvé avec l'ID donné");
            }
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention du dépannage");
        }
    }

    // Méthode pour mettre à jour une entrée de dépannage existante
    public function updateDepanage()
    {
        try {
            $sql = "UPDATE Depannage 
                    SET 
                        message = :message,
                        title = :title,
                        intro = :intro,
                        image = :image
                    WHERE
                        id = :id";

            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->message = htmlspecialchars(strip_tags($this->message));
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->intro = htmlspecialchars(strip_tags($this->intro));
            $this->image = htmlspecialchars(strip_tags($this->image));

            // Lier les paramètres
            $stmt->bindParam(":message", $this->message);
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
            throw new Exception("Échec de la mise à jour du dépannage");
        }
    }

    // Méthode pour supprimer une entrée de dépannage existante
    public function deleteDepanage()
    {
        try {
            $sql = "DELETE FROM Depannage WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":id", $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la suppression du dépannage");
        }
    }
}
?>
