<?php
declare(strict_types=1);

$config = require __DIR__ . '/../config/config.php';

function getPDO(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $db = $GLOBALS['__JOBPORTAL_CONFIG_DB__'] ?? $config->db;

    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $db->host,
        $db->port,
        $db->name,
        $db->charset
    );

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $db->user, $db->pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        // In production, log and show a friendly message
        http_response_code(500);
        echo "Database connection error.";
        error_log("DB connection error: " . $e->getMessage());
        exit;
    }
}
