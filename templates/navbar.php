<?php
require_once __DIR__ . '/../includes/auth.php';
$user = getLoggedUser();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="/public/index.php">
      <img src="/assets/images/logo.png" alt="Logo" height="30" class="me-2">
      Job Portal
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="/public/jobs.php" class="nav-link">Jobs</a></li>

        <?php if ($user): ?>
          <?php if ($user['role'] === 'employer'): ?>
            <li class="nav-item"><a href="/employer/dashboard.php" class="nav-link">Dashboard</a></li>
          <?php elseif ($user['role'] === 'user'): ?>
            <li class="nav-item"><a href="/user/dashboard.php" class="nav-link">My Profile</a></li>
          <?php elseif ($user['role'] === 'admin'): ?>
            <li class="nav-item"><a href="/admin/index.php" class="nav-link">Admin</a></li>
          <?php endif; ?>

          <li class="nav-item"><a href="/public/logout.php" class="nav-link">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a href="/public/login.php" class="nav-link">Login</a></li>
          <li class="nav-item"><a href="/public/register.php" class="nav-link">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
