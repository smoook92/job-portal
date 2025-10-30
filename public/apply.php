<?php
require_once "../includes/auth.php";
require_once "../includes/db.php";
requireRole('user');

$job_id = (int)$_GET['job_id'];
$user_id = $_SESSION['user_id'];

// Prevent duplicate applications
$stmt = $pdo->prepare("SELECT id FROM applications WHERE user_id=? AND job_id=?");
$stmt->execute([$user_id, $job_id]);

if ($stmt->fetch()) {
    flash('warning', 'You already applied for this job.');
} else {
    $stmt = $pdo->prepare("INSERT INTO applications (user_id, job_id, applied_at) VALUES (?, ?, NOW())");
    $stmt->execute([$user_id, $job_id]);
    flash('success', 'Application submitted successfully.');
}

header("Location: /public/job.php?id=$job_id");
exit;
