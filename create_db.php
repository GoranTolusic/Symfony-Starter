<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$DB_USER = $_ENV['DB_USER'] ?: 'root';
$DB_PASS = $_ENV['DB_PASS'] ?: '1234';
$DB_HOST = $_ENV['DB_HOST'] ?: '172.17.0.2';
$DB_PORT = $_ENV['DB_PORT'] ?: '3306';
$DB_NAME = $_ENV['DB_NAME'] ?: 'symfony_starter';

try {
    //Initialize connection to db
    $pdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;charset=utf8mb4", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Check if database with same name already exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '$DB_NAME'");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //If not, we are creating one
    if ($stmt->rowCount() === 0) {
        echo "Database '$DB_NAME' does not exists. Creating...\n";
        $pdo->exec("CREATE DATABASE `$DB_NAME` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        echo "Database '$DB_NAME' created.\n";
    } else {
        echo "Database '$DB_NAME' already exists.\n";
    }

} catch (PDOException $e) {
    echo "DB Error: " . $e->getMessage() . "\n";
    exit(1);
}
