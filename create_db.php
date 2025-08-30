<?php
// load .env variables ili postavi ručno
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '1234';
$DB_HOST = getenv('DB_HOST') ?: '172.17.0.2';
$DB_PORT = getenv('DB_PORT') ?: '3306';
$DB_NAME = getenv('DB_NAME') ?: 'symfony_starter';

try {
    // konekcija bez baze, da možemo provjeriti/kreirati
    $pdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;charset=utf8mb4", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // provjeri postoji li baza
    $stmt = $pdo->query("SHOW DATABASES LIKE '$DB_NAME'");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($result);
    if ($stmt->rowCount() === 0) {
        echo "Baza '$DB_NAME' ne postoji. Kreiram...\n";
        $pdo->exec("CREATE DATABASE `$DB_NAME` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        echo "Baza '$DB_NAME' je kreirana.\n";
    } else {
        echo "Baza '$DB_NAME' već postoji.\n";
    }

} catch (PDOException $e) {
    echo "Greška: " . $e->getMessage() . "\n";
    exit(1);
}
