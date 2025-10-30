<?php
$page_title = "My Dashboard";
include '../templates/header.php';
include '../templates/navbar.php';
?>
<div class="container py-4">
  <h2 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['first_name'] ?? 'User'); ?>!</h2>
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <i class="fa fa-file-lines fa-2x text-primary mb-2"></i>
          <h5>My Applications</h5>
          <p class="text-muted mb-2">View all jobs you’ve applied for</p>
          <a href="/user/applications.php" class="btn btn-outline-primary btn-sm">View</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <i class="fa fa-heart fa-2x text-danger mb-2"></i>
          <h5>Saved Jobs</h5>
          <p class="text-muted mb-2">Your saved job listings</p>
          <a href="/user/saved.php" class="btn btn-outline-primary btn-sm">View</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../templates/footer.php'; ?>
