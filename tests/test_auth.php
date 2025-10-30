<?php
require_once "../includes/auth.php";

echo "Testing registration...\n";
$userId = registerUser([
    'email' => 'testuser@example.com',
    'password' => '123456',
    'role' => 'user'
]);
echo $userId ? "✔ Registered successfully\n" : "❌ Registration failed\n";

echo "Testing login...\n";
$logged = loginUser('testuser@example.com', '123456');
echo $logged ? "✔ Login successful\n" : "❌ Login failed\n";
