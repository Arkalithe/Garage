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

    // Méthode pour obtenir tous les avis
    public function getAvis()
    {
        try {
            $sql = "SELECT id, name, message, note, moderate FROM avis";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention des avis");
        }
    }

    // Méthode pour créer un nouvel avis
    public function createAvis()
    {
        try {
            $sql = "INSERT INTO avis 
                    SET
                        message = :message,
                        name = :name,
                        note = :note,
                        moderate = :moderate";
            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->message = htmlspecialchars(strip_tags($this->message));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->note = htmlspecialchars(strip_tags($this->note));
            $this->moderate = htmlspecialchars(strip_tags($this->moderate));

            // Lier les paramètres
            $stmt->bindParam(":message", $this->message);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":note", $this->note);
            $stmt->bindParam(":moderate", $this->moderate);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la création de l'avis");
        }
    }

    // Méthode pour obtenir un seul avis par son ID
    public function singleAvis()
    {
        try {
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
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dataRow) {
                $this->name = $dataRow['name'];
                $this->message = $dataRow['message'];
                $this->note = $dataRow['note'];
                $this->moderate = $dataRow['moderate'];
            } else {
                throw new Exception("Aucun avis trouvé avec l'ID donné");
            }
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention de l'avis");
        }
    }

    // Méthode pour mettre à jour un avis existant
    public function updateAvis()
    {
        try {
            $sql = "UPDATE avis 
                    SET 
                        message = :message,
                        name = :name,
                        note = :note,
                        moderate = :moderate
                    WHERE
                        id = :id";

            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->message = htmlspecialchars(strip_tags($this->message));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->note = htmlspecialchars(strip_tags($this->note));
            $this->moderate = htmlspecialchars(strip_tags($this->moderate));

            // Lier les paramètres
            $stmt->bindParam(":message", $this->message);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":note", $this->note);
            $stmt->bindParam(":moderate", $this->moderate);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la mise à jour de l'avis");
        }
    }

    // Méthode pour supprimer un avis existant
    public function deleteAvis()
    {
        try {
            $sql = "DELETE FROM avis WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":id", $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la suppression de l'avis");
        }
    }
}
?>
