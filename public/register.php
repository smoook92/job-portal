<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'Register';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!csrf_check($_POST['_csrf'] ?? '')) {
            throw new RuntimeException('Invalid CSRF token.');
        }

        $data = [
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'role' => $_POST['role'] ?? 'job_seeker',
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'phone' => $_POST['phone'] ?? ''
        ];
        $userId = registerUser($data);

        flash('success', 'Registration successful. You can log in now.');
        header('Location: /public/login.php');
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
  <h2>Register</h2>
  <?php foreach ($flash as $type => $msg): ?>
    <div class="alert alert-<?= e($type) ?>"><?= e($msg) ?></div>
  <?php endforeach; ?>

  <form method="post">
    <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input name="email" required type="email" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input name="password" required type="password" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Role</label>
      <select name="role" class="form-select">
        <option value="job_seeker" selected>Job Seeker</option>
        <option value="employer">Employer</option>
      </select>
    </div>
    <button class="btn btn-primary" type="submit">Register</button>
  </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
