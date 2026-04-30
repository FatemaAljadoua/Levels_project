<?php
$host = 'localhost';
$db_name = 'levels';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

$dns = "mysql:host=$host;dbname=$db_name;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
    PDO::ATTR_EMULATE_PREPARES => false 
];

try {
    $pdo = new PDO($dns, $username, $password, $options);
} catch (PDOException $e) {
    response(500, 'Connection failed ' . $e->getMessage());
}
