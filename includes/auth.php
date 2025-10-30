<?php
require_once __DIR__ . '/db.php';
session_start();

/**
 * Register a new user (job seeker or employer)
 */
function registerUser($data) {
    global $pdo;

    $email = trim($data['email']);
    $password = password_hash($data['password'], PASSWORD_BCRYPT);
    $role = $data['role'] ?? 'user';

    $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$email, $password, $role]);

    return $pdo->lastInsertId();
}

/**
 * Authenticate and log in a user
 */
function loginUser($email, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        return true;
    }

    return false;
}

/**
 * Get currently logged-in user info
 */
function getLoggedUser() {
    global $pdo;

    if (!isset($_SESSION['user_id'])) {
        return null;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

/**
 * Check if user has specific role
 */
function requireRole($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header("Location: /public/login.php");
        exit;
    }
}

/**
 * Logout
 */
function logoutUser() {
    session_destroy();
    header("Location: /public/login.php");
    exit;
}
