<?php
include_once 'Connect.php';
include_once 'CreationDb.php';
include_once 'CreationTableDbUser.php';
include_once 'CreationTableDbCar.php';
include_once 'CreationTableDbAvis.php';
include_once 'CreationTableDbHoraire.php';
include_once 'CreationDatabaseContent.php';
include_once 'AddDataCar.php';
include_once 'AddDataContent.php';
include_once 'AddDataHoraire.php';
include_once 'AddDataAvis.php';
include_once 'AddDataUsers.php';

// Initialisation de la connexion à la base de données
$db_connection = new DatabaseConnect();
$conn = $db_connection->dbConnection();

// Initialisation des objets pour la création et le peuplement de la base de données
$db_create = new DatabaseCreate();
$db_table_user = new DatabaseTableCreateUser();
$db_table_car = new DatabaseTableCreateCar();
$db_table_avis = new DatabaseTableCreateAvis();
$db_table_horaire = new DatabaseTableCreateHoraire();
$db_table_content = new DatabaseContent();
$add_data_car = new AddDataCar();
$add_data_content = new AddDataContent();
$add_data_horaire = new AddDataHoraire();
$add_data_avis = new AddDataAvis();
$add_data_users = new AddDataUsers();


try {
    // Création de la base de données et des tables
    $db_create->creationDb();
    $db_table_user->creationTableUser();
    $db_table_car->creationTableCar();
    $db_table_avis->creationTableAvis();
    $db_table_horaire->creationTableHoraire();
    $db_table_content->creationContent();

    // Démarrage de la transaction
    $conn->beginTransaction();

    // Peuplement des tables
    $add_data_content->dataContent();
    $add_data_horaire->dataHoraire();
    $add_data_avis->dataAvis();
    $add_data_users->dataUser();
    $add_data_car->dataCar();

    // Validation de la transaction
    $conn->commit();
    echo "Base de données créée et peuplée avec succès<br>";

} catch (PDOException $e) {
    // Annulation de la transaction en cas d'erreur
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo "Connection Raté : <br>" . $e->getMessage();
    exit;
} finally {
    // Fermeture de la connexion
    $conn = null;
}