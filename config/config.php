<?php
$host = 'localhost';
$dbname = 'nasib';
$usuario = 'root';
$senha = ''; // Coloca a tua senha do MySQL se tiveres uma

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar à base de dados: " . $e->getMessage());
}
?>