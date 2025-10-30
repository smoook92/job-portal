<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

require_login('/public/login.php');

$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

try {
    if (!csrf_check($_POST['_csrf'] ?? '')) {
        throw new RuntimeException('Invalid CSRF token.');
    }

    $job_id = (int)($_POST['job_id'] ?? 0);
    if ($job_id <= 0) {
        throw new RuntimeException('Invalid job.');
    }

    $resume_id = null;
    if (!empty($_FILES['resume']) && $_FILES['resume']['error'] !== UPLOAD_ERR_NO_FILE) {
        $res = storeResume($_FILES['resume']);

        $stmt = $pdo->prepare("INSERT INTO resumes (user_id, filename, original_name, mime_type, size) VALUES (:uid, :filename, :orig, :mime, :size)");
        $stmt->execute([
            ':uid' => $_SESSION['user_id'],
            ':filename' => $res['filename'],
            ':orig' => $res['original_name'],
            ':mime' => $res['mime'],
            ':size' => $res['size']
        ]);
        $resume_id = (int)$pdo->lastInsertId();
    } else {
        
        $stmt = $pdo->prepare("SELECT id FROM resumes WHERE user_id = :uid ORDER BY is_primary DESC, created_at DESC LIMIT 1");
        $stmt->execute([':uid' => $_SESSION['user_id']]);
        $row = $stmt->fetch();
        if ($row) $resume_id = (int)$row['id'];
    }

    $stmt = $pdo->prepare("SELECT id FROM applications WHERE job_id = :job AND user_id = :uid LIMIT 1");
    $stmt->execute([':job' => $job_id, ':uid' => $_SESSION['user_id']]);
    if ($stmt->fetch()) {
        throw new RuntimeException('You have already applied to this job.');
    }

    $stmt = $pdo->prepare("INSERT INTO applications (job_id, user_id, resume_id, cover_letter, status) VALUES (:job, :uid, :rid, :cover, 'applied')");
    $stmt->execute([
        ':job' => $job_id,
        ':uid' => $_SESSION['user_id'],
        ':rid' => $resume_id,
        ':cover' => $_POST['cover_letter'] ?? null
    ]);

    $stmt = $pdo->prepare("
        SELECT u.email AS employer_email
        FROM jobs j
        JOIN employers e ON j.employer_id = e.id
        JOIN users u ON e.user_id = u.id
        WHERE j.id = :job LIMIT 1
    ");
    $stmt->execute([':job' => $job_id]);
    $emp = $stmt->fetch();
    if ($emp && filter_var($emp['employer_email'], FILTER_VALIDATE_EMAIL)) {
        require_once __DIR__ . '/../includes/mailer.php';
        $subject = "New application for job #{$job_id}";
        $body = "A new application was submitted. Visit employer panel to view.";
        @send_email($emp['employer_email'], $subject, $body);
    }

    flash('success', 'Application submitted.');
    header('Location: /user/applications.php');
    exit;

} catch (Throwable $e) {
    flash('danger', $e->getMessage());
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/public/jobs.php'));
    exit;
}
