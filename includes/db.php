<?php
$config = require_once __DIR__ . '/../config/config.php';

try {
    $pdo = new PDO(
        "mysql:host=" . $config->db->host . ";dbname=" . $config->db->name . ";charset=" . $config->db->charset,
        $config->db->user,
        $config->db->pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
