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

    // Méthode pour obtenir tous les horaires
    public function getHoraire()
    {
        try {
            $sql = "SELECT id, jour, matin, apresmidi FROM horaires";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention des horaires");
        }
    }

    // Méthode pour créer un nouvel horaire
    public function createHoraire()
    {
        try {
            $sql = "INSERT INTO horaires 
                    SET
                        jour = :jour,
                        matin = :matin, 
                        apresmidi = :apresmidi";
            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->jour = htmlspecialchars(strip_tags($this->jour));
            $this->matin = htmlspecialchars(strip_tags($this->matin));
            $this->apresmidi = htmlspecialchars(strip_tags($this->apresmidi));

            // Lier les paramètres
            $stmt->bindParam(":jour", $this->jour);
            $stmt->bindParam(":matin", $this->matin);
            $stmt->bindParam(":apresmidi", $this->apresmidi);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la création de l'horaire");
        }
    }

    // Méthode pour obtenir un seul horaire par son ID
    public function singleHoraire()
    {
        try {
            $sql = "SELECT 
                        id, 
                        jour, 
                        matin, 
                        apresmidi
                    FROM 
                        horaires 
                    WHERE 
                        id = ? 
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dataRow) {
                $this->jour = $dataRow['jour'];
                $this->matin = $dataRow['matin'];
                $this->apresmidi = $dataRow['apresmidi'];
            } else {
                throw new Exception("Aucun horaire trouvé avec l'ID donné");
            }
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention de l'horaire");
        }
    }

    // Méthode pour mettre à jour un horaire existant
    public function updateHoraire()
    {
        try {
            $sql = "UPDATE horaires 
                    SET 
                        jour = :jour,
                        matin = :matin, 
                        apresmidi = :apresmidi
                    WHERE
                        id = :id";

            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->jour = htmlspecialchars(strip_tags($this->jour));
            $this->matin = htmlspecialchars(strip_tags($this->matin));
            $this->apresmidi = htmlspecialchars(strip_tags($this->apresmidi));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Lier les paramètres
            $stmt->bindParam(":jour", $this->jour);
            $stmt->bindParam(":matin", $this->matin);
            $stmt->bindParam(":apresmidi", $this->apresmidi);
            $stmt->bindParam(":id", $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la mise à jour de l'horaire");
        }
    }

    // Méthode pour supprimer un horaire existant
    public function deleteHoraire()
    {
        try {
            $sql = "DELETE FROM horaires WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":id", $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la suppression de l'horaire");
        }
    }
}
?>
