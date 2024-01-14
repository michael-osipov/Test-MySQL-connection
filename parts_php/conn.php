<?php

// Local
$hostDB = "localhost";
$baseName = "test";
$userDB = "root";
$passDB = "";

// Server

try {
    $dsn = 'mysql:host=' . $hostDB . ';dbname=' . $baseName;
    $pdo = new PDO($dsn, $userDB, $passDB);
    echo "db OK <br /><br />";
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}