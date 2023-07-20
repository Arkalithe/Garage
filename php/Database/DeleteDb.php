<?php
include_once 'Connect.php';

$db_connection = new DatabaseConnect();

try {
    $conn = $db_connection->dbConnection();

    $deleteQueries = [
        'DELETE FROM Users;',
        'DELETE FROM voitureOccasion;',
        'DELETE FROM horaires;',
        'DELETE FROM reparation;',
        'DELETE FROM depannage;',
        'DELETE FROM CVVOITURE;',
        'DELETE FROM EVVOITURE;',
        'DELETE FROM VOITURE_IMAGES;',
        'DELETE FROM EQUIPEMENT;',
        'DELETE FROM IMAGES;',
        'DELETE FROM CARACTERISTIQUE;',
        'DELETE FROM VOITURES;',
        'DELETE FROM AVIS;'
    ];

    foreach ($deleteQueries as $query) {
        $conn->exec($query);
        echo 'Delete query executed.<br>';
    }
} catch(PDOException $e) {
    echo "Connection Raté : <br>" . $e->getMessage();
    exit;
}