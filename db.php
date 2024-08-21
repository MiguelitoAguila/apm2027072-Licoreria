<?php
$dsn = 'mysql:host=localhost;dbname=liquor_store';
$username = 'root'; // Cambia esto según tu configuración de XAMPP
$password = ''; // Cambia esto según tu configuración de XAMPP

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
