<?php
require_once "../includes/db.php";

echo "Testing DB connection...\n";
$stmt = $pdo->query("SELECT COUNT(*) AS count FROM users");
$row = $stmt->fetch();
echo "✔ Connected successfully. User count: {$row['count']}\n";
