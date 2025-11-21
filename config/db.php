<?php
// config/db.php
// Creates a PDO instance `$pdo` if not already present.
if (!isset($pdo)) {
    $host = 'localhost';
    $dbname = 'casdo';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        // In production, don't display error details
        die('Database connection failed: ' . $e->getMessage());
    }
}

?>
