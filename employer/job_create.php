<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

require_login('/public/login.php');
if (!check_role('employer')) {
    http_response_code(403);
    echo "Forbidden";
    exit;
}

$page_title = 'Create Job';
$pdo = getPDO();

$stmt = $pdo->prepare("SELECT id FROM employers WHERE user_id = :uid LIMIT 1");
$stmt->execute([':uid' => $_SESSION['user_id']]);
$employer = $stmt->fetch();
if (!$employer) {
    flash('danger', 'Employer profile not found. Please complete your employer profile first.');
    header('Location: /employer/profile.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!csrf_check($_POST['_csrf'] ?? '')) {
            throw new RuntimeException('Invalid CSRF token.');
        }

        $title = trim($_POST['title'] ?? '');
        $slug = slugify($title);
        $description = trim($_POST['description'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $employment_type = $_POST['employment_type'] ?? 'full_time';

        if ($title === '' || $description === '') {
            throw new RuntimeException('Title and description required.');
        }

        $stmt = $pdo->prepare("
            INSERT INTO jobs (employer_id, title, slug, location, employment_type, description, responsibilities, requirements, benefits, status)
            VALUES (:employer_id, :title, :slug, :location, :employment_type, :description, :responsibilities, :requirements, :benefits, :status)
        ");
        $stmt->execute([
            ':employer_id' => $employer['id'],
            ':title' => $title,
            ':slug' => $slug,
            ':location' => $location,
            ':employment_type' => $employment_type,
            ':description' => $description,
            ':responsibilities' => $_POST['responsibilities'] ?? null,
            ':requirements' => $_POST['requirements'] ?? null,
            ':benefits' => $_POST['benefits'] ?? null,
            ':status' => $_POST['status'] ?? 'published'
        ]);

        flash('success', 'Job created.');
        header('Location: /employer/jobs.php');
        exit;
    } catch (Throwable $e) {
        flash('danger', $e->getMessage());
    }
}

include __DIR__ . '/../templates/header.php';
include __DIR__ . '/../templates/navbar.php';
$flash = getFlash();
?>
<div class="container py-4">
  <h2>Create Job</h2>
  <?php foreach ($flash as $type => $msg): ?>
    <div class="alert alert-<?= e($type) ?>"><?= e($msg) ?></div>
  <?php endforeach; ?>

  <form method="post">
    <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input name="title" required class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Location</label>
      <input name="location" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Type</label>
      <select name="employment_type" class="form-select">
        <option value="full_time">Full time</option>
        <option value="part_time">Part time</option>
        <option value="contract">Contract</option>
        <option value="internship">Internship</option>
        <option value="remote">Remote</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" required class="form-control" rows="6"></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="draft">Draft</option>
        <option value="published" selected>Published</option>
        <option value="closed">Closed</option>
      </select>
    </div>
    <button class="btn btn-primary" type="submit">Create</button>
  </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
