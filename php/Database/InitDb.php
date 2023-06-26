<?php
include_once 'Connect.php';
include_once 'CreationDb.php';
include_once 'CreationTableDbUser.php';    



$db_create = new DatabaseCreate();
$db_table_user = new DatabaseTableCreateUser();






try {
    $db_create->creationDb();
    $db_table_user->creationTableUser();


} catch (PDOException $e) {
    echo $tsql . "Connection Raté : <br>" . $e->getMessage();
    exit;
}

