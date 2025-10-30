<?php
require_once "../includes/auth.php";
require_once "../includes/db.php";
requireRole('admin'); // only admins can access
$page_title = "Admin Dashboard";
require_once "../templates/header.php";
require_once "../templates/navbar.php";

$total_users = $pdo->query("SELECT COUNT(*) FROM users WHERE role='user'")->fetchColumn();
$total_employers = $pdo->query("SELECT COUNT(*) FROM users WHERE role='employer'")->fetchColumn();
$total_jobs = $pdo->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
$total_applications = $pdo->query("SELECT COUNT(*) FROM applications")->fetchColumn();
?>

<main class="container py-4">
  <h2>Admin Dashboard</h2>

  <div class="row mt-4">
    <div class="col-md-3">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Users</h5>
          <p class="card-text"><?= $total_users ?></p>
          <a href="users.php" class="btn btn-light btn-sm">Manage</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-success mb-3">
        <div class="card-body">
          <h5 class="card-title">Employers</h5>
          <p class="card-text"><?= $total_employers ?></p>
          <a href="users.php" class="btn btn-light btn-sm">Manage</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-warning mb-3">
        <div class="card-body">
          <h5 class="card-title">Jobs</h5>
          <p class="card-text"><?= $total_jobs ?></p>
          <a href="jobs.php" class="btn btn-light btn-sm">Manage</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-danger mb-3">
        <div class="card-body">
          <h5 class="card-title">Applications</h5>
          <p class="card-text"><?= $total_applications ?></p>
          <a href="jobs.php" class="btn btn-light btn-sm">View</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require_once "../templates/footer.php"; ?>
