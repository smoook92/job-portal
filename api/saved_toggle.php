<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

require_login('/public/login.php');

$pdo = getPDO();

$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;

$job_id = (int)($input['job_id'] ?? 0);
if ($job_id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid job id']);
    exit;
}

try {
    
    $stmt = $pdo->prepare("SELECT 1 FROM saved_jobs WHERE user_id = :uid AND job_id = :job LIMIT 1");
    $stmt->execute([':uid' => $_SESSION['user_id'], ':job' => $job_id]);
    if ($stmt->fetch()) {
        $stmt = $pdo->prepare("DELETE FROM saved_jobs WHERE user_id = :uid AND job_id = :job");
        $stmt->execute([':uid' => $_SESSION['user_id'], ':job' => $job_id]);
        echo json_encode(['status' => 'removed']);
    } else {
        $stmt = $pdo->prepare("INSERT INTO saved_jobs (user_id, job_id) VALUES (:uid, :job)");
        $stmt->execute([':uid' => $_SESSION['user_id'], ':job' => $job_id]);
        echo json_encode(['status' => 'saved']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
