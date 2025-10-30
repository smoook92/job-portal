<?php
session_start();
$user_role = $_SESSION['role'] ?? null;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/public/index.php">
      <i class="fa-solid fa-briefcase"></i> JobPortal
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/public/jobs.php">Jobs</a></li>

        <?php if ($user_role === 'employer'): ?>
          <li class="nav-item"><a class="nav-link" href="/employer/dashboard.php">Employer Panel</a></li>
        <?php elseif ($user_role === 'job_seeker'): ?>
          <li class="nav-item"><a class="nav-link" href="/user/dashboard.php">My Account</a></li>
        <?php endif; ?>

        <?php if ($user_role): ?>
          <li class="nav-item"><a class="nav-link" href="/public/logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/public/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="/public/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
