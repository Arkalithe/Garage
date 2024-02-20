<?php

if (!file_exists(__DIR__ . '/../build/index.html')) {
    header('HTTP/1.1 404 Not Found');
    echo '404 Not Found';
    exit();
}

require __DIR__ . '/../build/index.html';
