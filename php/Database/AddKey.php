<?php
include_once 'Connect.php';

class AddKey
{
    public function addKey()
    {

        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();
        try {
            $sql = "ALTER TABLE voitures
                    ADD CONSTRAINT fk_voitures_images
                    FOREIGN KEY (primary_image_url)
                    REFERENCES images(image_url)";

            $conn->exec($sql);
            echo 'Foreign Key  primary_image_url ajouté a Voitures avec succés :<br>';

            $sql = "ALTER TABLE images
                    ADD CONSTRAINT unique_voiture_id
                    UNIQUE (voiture_id)";

            $conn->exec($sql);
            echo 'Unique Key  voiture_id ajouté a Images avec succés :<br>';

        } catch (PDOException $e) {

            echo $sql . "Connection Raté :" . $e->getMessage();
            exit;
        }
    }
}
