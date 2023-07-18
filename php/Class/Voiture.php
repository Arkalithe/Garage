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
    public $modele;
    public $nom;
    public $prenom;
    public $numero;
    public $voiture_images;
    public $evvoiture;
    public $cvvoitre;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getVoiture()
    {
        $sql = "SELECT 
                    V.id,
                    V.prix,
                    V.kilometrage,
                    V.annee_circulation,
                    V.modele,
                    V.nom,
                    V.prenom,
                    V.numero,
                    GROUP_CONCAT(DISTINCT C.caracteristique) as cvvoiture,
                    GROUP_CONCAT(DISTINCT E.equipement) as evvoiture,
                    GROUP_CONCAT(DISTINCT I.image_url) AS voiture_images
                FROM
                    VOITURES V
                LEFT JOIN
                    CVVOITURE CV ON V.id = CV.voiture_id
                LEFT JOIN
                    CARACTERISTIQUE C ON CV.caracteristique_id = C.id
                LEFT JOIN
                    EVVOITURE EV ON V.id = EV.voiture_id
                LEFT JOIN
                    EQUIPEMENT E ON EV.equipement_id = E.id
                LEFT JOIN
                    VOITURE_IMAGES VI ON V.id = VI.voiture_id
                LEFT JOIN
                    IMAGES I ON VI.image_id = I.id
                GROUP BY
                    V.id";

                    

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }


    public function createVoiture()
    {
        $sql = "INSERT INTO VOITURES 
                SET 
                    prix = :prix,
                    kilometrage = :kilometrage,
                    annee_circulation = :annee_circulation,
                    modele = :modele,
                    nom = :nom,
                    prenom = :prenom,
                    numero = :numero";
        $stmt = $this->conn->prepare($sql);

        $this->prix = htmlspecialchars(strip_tags($this->prix));
        $this->kilometrage = htmlspecialchars(strip_tags($this->kilometrage));
        $this->annee_circulation = htmlspecialchars(strip_tags($this->annee_circulation));
        $this->modele = htmlspecialchars(strip_tags($this->modele));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->numero = htmlspecialchars(strip_tags($this->numero));

        $stmt->bindParam(":prix", $this->prix);
        $stmt->bindParam(":kilometrage", $this->kilometrage);
        $stmt->bindParam(":annee_circulation", $this->annee_circulation);
        $stmt->bindParam(":modele", $this->modele);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":numero", $this->numero);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function singleVoiture()
    {
        $sql = "SELECT 
                    V.id,
                    V.prix,
                    V.kilometrage,
                    V.annee_circulation,
                    V.modele,
                    V.nom,
                    V.prenom,
                    V.numero,
                    GROUP_CONCAT(DISTINCT C.caracteristique) as cvvoiture,
                    GROUP_CONCAT(DISTINCT E.equipement) as evvoiture,
                    GROUP_CONCAT(DISTINCT I.image_url) AS voiture_images
                FROM
                    VOITURES V
                LEFT JOIN
                    CVVOITURE CV ON V.id = CV.voiture_id
                LEFT JOIN
                    CARACTERISTIQUE C ON CV.caracteristique_id = C.id
                LEFT JOIN
                    EVVOITURE EV ON V.id = EV.voiture_id
                LEFT JOIN
                    EQUIPEMENT E ON EV.equipement_id = E.id
                LEFT JOIN
                    VOITURE_IMAGES VI ON V.id = VI.voiture_id
                LEFT JOIN
                    IMAGES I ON VI.image_id = I.id
                WHERE
                    V.id = :id
                LIMIT 0,1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $dataRow['id'];
        $this->prix = $dataRow['prix'];
        $this->kilometrage = $dataRow['kilometrage'];
        $this->annee_circulation = $dataRow['annee_circulation'];
        $this->modele = $dataRow['modele'];
        $this->nom = $dataRow['nom'];
        $this->prenom = $dataRow['prenom'];
        $this->numero = $dataRow['numero'];
        $this->caracteristique = explode(',',$dataRow['cvvoiture']);
        $this->equipement = explode(',', $dataRow['evvoiture']);
        $this->voiture_images = explode(',', $dataRow['voiture_images']);
    }

    public function updateVoiture()
    {
        $sql = "UPDATE VOITURES 
                SET 
                    prix = :prix,
                    kilometrage = :kilometrage,
                    annee_circulation = :annee_circulation,
                    modele = :modele,
                    nom = :nom,
                    prenom = :prenom,
                    numero = :numero
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($sql);

        $this->prix = htmlspecialchars(strip_tags($this->prix));
        $this->kilometrage = htmlspecialchars(strip_tags($this->kilometrage));
        $this->annee_circulation = htmlspecialchars(strip_tags($this->annee_circulation));
        $this->modele = htmlspecialchars(strip_tags($this->modele));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->numero = htmlspecialchars(strip_tags($this->numero));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":prix", $this->prix);
        $stmt->bindParam(":kilometrage", $this->kilometrage);
        $stmt->bindParam(":annee_circulation", $this->annee_circulation);
        $stmt->bindParam(":modele", $this->modele);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":numero", $this->numero);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteVoiture()
    {
        $sql = "DELETE FROM VOITURES WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getLastInsertedId()
    {
        return $this->conn->lastInsertId();
    }
}