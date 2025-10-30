<?php
require_once __DIR__ . '/../config/config.php';

/**
 * Returns a PDO instance.
 * Usage: $pdo = getPDO();
 */
function getPDO(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $dsn