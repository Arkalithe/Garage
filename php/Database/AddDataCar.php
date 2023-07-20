<?php
include_once 'Connect.php';

class AddDataCar {
    
    public function dataCar() {

        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {
            $voituresData = [
                [1, 15000, 50000, 2019, 'Model X', 'John', 'Doe', '1234567890'],
                [2, 12000, 40000, 2018, 'Model Y', 'Jane', 'Smith', '9876543210'],
                [3, 18000, 60000, 2020, 'Model Z', 'Robert', 'Johnson', '4567890123'],
                [4, 20000, 55000, 2017, 'Model A', 'Michael', 'Brown', '7890123456'],
                [5, 14000, 45000, 2019, 'Model B', 'Emily', 'Davis', '5678901234'],
                [6, 16000, 55000, 2018, 'Model C', 'David', 'Miller', '8901234567'],
                [7, 13000, 50000, 2019, 'Model D', 'Emma', 'Wilson', '3456789012'],
                [8, 17000, 45000, 2017, 'Model E', 'Andrew', 'Taylor', '6789012345'],
                [9, 19000, 60000, 2020, 'Model F', 'Olivia', 'Anderson', '0123456789'],
                [10, 11000, 40000, 2018, 'Model G', 'Daniel', 'Thomas', '9012345678']
            ];

            $voituresStmt = $conn->prepare("INSERT INTO VOITURES (id, prix, kilometrage, annee_circulation, modele, nom, prenom, numero)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            foreach ($voituresData as $data) {
                $voituresStmt->execute($data);
            }

            echo "Data ajouter dans la table VOITURES avec succes.<br>";

            $caracteristiqueData = [
                [1, 'Caracterisique 1'],
                [2, 'Caracterisique 2'],
                [3, 'Caracterisique 3'],
                [4, 'Caracterisique 4'],
                [5, 'Caracterisique 5'],
                [6, 'Caracterisique 6'],
                [7, 'Caracterisique 7'],
                [8, 'Caracterisique 8'],
                [9, 'Caracterisique 9'],
                [10, 'Caracterisique 10']
            ];

            $caracteristiqueStmt = $conn->prepare("INSERT INTO CARACTERISTIQUE (id, caracteristique) VALUES (?, ?)");

            foreach ($caracteristiqueData as $data) {
                $caracteristiqueStmt->execute($data);
            }

            echo "Data ajouter dans la table CARACTERISTIQUE avec succes.<br>";
            $equipementData = [
                [1,'Equipment 1'],
                [2,'option 2'],
                [3,'Equipment 3'],
                [4,'option 4'],
                [5,'Equipment 5'],
                [6,'option 6'],
                [7,'Equipment 7'],
                [8,'option 8'],
                [9,'Equipment 9'],
                [10,'option 10']
            ];

            $equipementStmt = $conn->prepare("INSERT INTO EQUIPEMENT (id, equipement) VALUES (? ,?)");

            foreach ($equipementData as $data) {
                $equipementStmt->execute($data);
            }

            echo "Data ajouter dans la table EQUIPEMENT avec succes.<br>";

            $cvvoitureData = [
                [1, 1],
                [1, 2],
                [2, 3],
                [3, 4],
                [4, 5],
                [4, 6],
                [5, 7],
                [6, 8],
                [7, 9],
                [8, 10],
                [8, 2] 
            ];

            $cvvoitureStmt = $conn->prepare("INSERT INTO CVVOITURE (voiture_id, caracteristique_id) VALUES (?, ?)");

            foreach ($cvvoitureData as $data) {
                $cvvoitureStmt->execute($data);
            }

            echo "Data ajouter dans la table CVVOITURE avec succes.<br>";
            
            $evvoitureData = [
                [1, 1],
                [2, 2],
                [2, 3],
                [3, 4],
                [4, 5],
                [5, 6],
                [6, 7],
                [7, 8],
                [7, 9],
                [8, 10],
                [8, 1]
            ];

            $evvoitureStmt = $conn->prepare("INSERT INTO EVVOITURE (voiture_id, equipement_id) VALUES (?, ?)");

            foreach ($evvoitureData as $data) {
                $evvoitureStmt->execute($data);
            }

            echo "Data ajouter dans la table EVVOITURE avec succes.<br>";

        
            $imagesData = [
                [1, 'Voiture.png'],
                [2, 'Voiture5.png'],
                [3, 'Voiture1.png'],
                [4, 'Voiture2.png'],
            ];
            
            $imagesStmt = $conn->prepare("INSERT INTO IMAGES (id, image_url) VALUES (?, ?)");
            
            foreach ($imagesData as $data) {
                $imagesStmt->execute($data);
            }
            echo "Data ajouté dans la tabler IMAGES avec success.<br>";


            $voitureImagesData = [
                [1, 1],  
                [1, 2],  
                [2, 3],
                [3, 4],
                [4, 1],  
                [5, 2],  
                [6, 3],
                [7, 4],    
                [8, 1],  
                [9, 2],  
                [10, 3],                    
            ];
            
            $voitureImagesStmt = $conn->prepare("INSERT INTO VOITURE_IMAGES (voiture_id, image_id) VALUES (?, ?)");
            
            foreach ($voitureImagesData as $data) {
                $voitureImagesStmt->execute($data);
            }
            
            echo "Data ajouté dans la tabler VOITURE_IMAGES avec success.<br>";


        }         
        catch(PDOException $e) {
            echo "Ajout Data Raté: " . $e->getMessage() ;
        }
    }
}


?>
