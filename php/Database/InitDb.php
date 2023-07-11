<?php
include_once 'Connect.php';
include_once 'CreationDb.php';
include_once 'CreationTableDbUser.php';    
include_once 'CreationTableDbCar.php';    
include_once 'CreationTableDbAvis.php';

$db_create = new DatabaseCreate();
$db_table_user = new DatabaseTableCreateUser();
$db_table_car = new DatabaseTableCreateCar();
$db_table_avis = new DatabaseTableCreateAvis();


try {
    $db_create->creationDb();
    $db_table_user->creationTableUser();
    $db_table_car->creationTableCar();
    $db_table_avis->creationTableCar();

} catch (PDOException $e) {
    echo $tsql . "Connection Raté : <br>" . $e->getMessage();
    exit;
}

