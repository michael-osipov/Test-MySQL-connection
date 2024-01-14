<?php

// Create conn_params.php in the same folder and paste your connection parametrs there:
// $hostDB = "";
// $baseName = "";
// $userDB = "";
// $passDB = "";

include 'conn_params.php';
$hostDB = $hostDB ?? "localhost";
$baseName = $baseName ?? "test";
$userDB = $userDB ?? "root";
$passDB = $passDB ?? "";

try {
    $dsn = 'mysql:host=' . $hostDB . ';dbname=' . $baseName;
    $pdo = new PDO($dsn, $userDB, $passDB);
    echo "db OK <br /><br />";
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}