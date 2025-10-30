<?php
declare(strict_types=1);

/**
 * Very small mail wrapper.
 * In production, prefer PHPMailer or similar with SMTP and error handling.
 */

function send_email(string $to, string $subject, string $body, ?string $from = null): bool {
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: " . ($from ?? 'no-reply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost')) . "\r\n";
    
    return (bool)mail($to, $subject, $body, $headers);
}
