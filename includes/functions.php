<?php
declare(strict_types=1);

$config = require __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_name($config->session->name);
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ]);
}

/**
 * Flash helper - set message: flash('success','Saved.')
 * Retrieve via flash() or render in templates.
 */
function flash(string $type, string $message): void {
    if (!isset($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }
    $_SESSION['flash'][$type] = $message;
}

function getFlash(): array {
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

/** Basic sanitize for output */
function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Slugify function for friendly URLs */
function slugify(string $text): string {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) {
        return bin2hex(random_bytes(6));
    }
    return $text;
}

/**
 * Securely move uploaded resume and return filename or throw Exception.
 * - $file is $_FILES['resume']
 */
function storeResume(array $file): array {
    global $config;
    $allowed = $config->site->allowed_resume_types;
    $maxSize = $config->site->max_resume_size;
    $uploadsDir = rtrim($config->site->uploads_path, '/\\') . '/resumes';

    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('File upload error code: ' . $file['error']);
    }

    if ($file['size'] > $maxSize) {
        throw new RuntimeException('File too large (max ' . ($maxSize / 1024 / 1024) . ' MB).');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!in_array($mime, $allowed, true)) {
        throw new RuntimeException('Invalid file type: ' . $mime);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safeName = sprintf('%s_%s.%s', time(), bin2hex(random_bytes(6)), $ext);
    $destination = $uploadsDir . '/' . $safeName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    return [
        'filename' => 'resumes/' . $safeName,
        'original_name' => $file['name'],
        'mime' => $mime,
        'size' => (int)$file['size']
    ];
}

/** Simple CSRF token generation and check */
function csrf_token(): string {
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}
function csrf_check(?string $token): bool {
    return is_string($token) && isset($_SESSION['_csrf_token']) && hash_equals($_SESSION['_csrf_token'], $token);
}
