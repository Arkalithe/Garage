<?php
include_once 'Connect.php';
include_once 'CreationDb.php';
include_once 'CreationTableDb.php';    

function initDb(){
$db_create = new DatabaseCreate();
$conn = $db_create->creationDb();

$db_table = new DatabaseTableCreate();
$conn = $db_table->creationTable();
}



