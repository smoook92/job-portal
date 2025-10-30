<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$pdo = getPDO();

/**
 * Register a user (job_seeker or employer).
 * Returns user id on success or throws Exception.
 */
function registerUser(array $data): int {
    global $pdo;
    
    $email = trim(strtolower($data['email']));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('Invalid email.');
    }
    if (strlen($data['password']) < 8) {
        throw new InvalidArgumentException('Password must be >= 8 characters.');
    }
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        throw new RuntimeException('Email already registered.');
    }

    $hash = password_hash($data['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO users (email, password_hash, role, first_name, last_name, phone)
        VALUES (:email, :hash, :role, :first_name, :last_name, :phone)
    ");
    $stmt->execute([
        ':email' => $email,
        ':hash' => $hash,
        ':role' => $data['role'] ?? 'job_seeker',
        ':first_name' => $data['first_name'] ?? null,
        ':last_name' => $data['last_name'] ?? null,
        ':phone' => $data['phone'] ?? null
    ]);

    return (int)$pdo->lastInsertId();
}

/**
 * Login function: returns user row on success, false on failure.
 */
function loginUser(string $email, string $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, email, password_hash, role, first_name, last_name, is_active FROM users WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => strtolower(trim($email))]);
    $user = $stmt->fetch();

    if (!$user) {
        return false;
    }
    if (!$user['is_active']) {
        return false;
    }

    if (password_verify($password, $user['password_hash'])) {

        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password_hash = :h WHERE id = :id");
            $stmt->execute([':h' => $newHash, ':id' => $user['id']]);
        }


        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];

        unset($user['password_hash']);
        return $user;
    }

    return false;
}

/** Ensure user logged in, redirect to login if not */
function require_login(string $redirect = '/public/login.php'): void {
    if (empty($_SESSION['user_id'])) {
        header('Location: ' . $redirect);
        exit;
    }
}

/** Check role */
function check_role(string $role): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

/** Logout */
function logout(): void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
