<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'job-portal');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Uploads
define('UPLOAD_DIR', __DIR__ . '/../public/uploads/');
define('UPLOAD_URL', '/public/uploads/');

// Site settings
define('SITE_NAME', 'JobPortal');
define('SITE_EMAIL', 'noreply@jobportal.local');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
