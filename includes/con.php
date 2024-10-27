<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../.');
$dotenv->load();

$dsn = 'mysql:host=' . $_ENV['MYSQL_HOST'] . ';dbname=' . $_ENV['MYSQL_DATABASE'] . ';charset=utf8';
$user = $_ENV['MYSQL_USER'];
$password = $_ENV['MYSQL_PASSWORD'];

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
