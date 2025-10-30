<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'Login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!csrf_check($_POST['_csrf'] ?? '')) {
            throw new RuntimeException('Invalid CSRF token.');
        }

        $user = loginUser($_POST['email'] ?? '', $_POST['password'] ?? '');
        if ($user === false) {
            flash('danger', 'Invalid credentials.');
        } else {
            
            if ($_SESSION['role'] === 'employer') {
                header('Location: /employer/dashboard.php');
            } elseif ($_SESSION['role'] === 'admin') {
                header('Location: /admin/index.php');
            } else {
                header('Location: /user/dashboard.php');
            }
            exit;
        }
    } catch (Throwable $e) {
        flash('danger', $e->getMessage());
    }
}

include __DIR__ . '/../templates/header.php';
include __DIR__ . '/../templates/navbar.php';
$flash = getFlash();
?>
<div class="container py-4">
  <h2>Login</h2>
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
    <button class="btn btn-primary" type="submit">Login</button>
  </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
