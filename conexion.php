<?php

$host = "localhost";
$port = "5432";
$dbname = "mydb";
$user = "postgres";
$password = "123";

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );



} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
$pdo = new PDO(
    "pgsql:host=localhost;dbname=mibase",
    "EscudoF",
    "c5628442"
);
?>