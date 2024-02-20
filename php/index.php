<?php
$indexPath = __DIR__ . '/../build/index.html';
if (file_exists($indexPath)) {
    require_once($indexPath);
} else {
    // Gérer l'erreur si le fichier n'existe pas
   echo header('HTTP/1.0 404 Not Found');
   
}