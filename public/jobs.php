<?php
$page_title = "Job Listings";
include '../templates/header.php';
include '../templates/navbar.php';
?>
<div class="container py-4">
  <h2 class="mb-4">Available Jobs</h2>

  <form class="row g-2 mb-3" method="get">
    <div class="col-md-4">
      <input type="text" class="form-control" name="keyword" placeholder="Keyword...">
    </div>
    <div class="col-md-3">
      <select name="category" class="form-select">
        <option value="">All Categories</option>
        <!-- Categories from DB -->
      </select>
    </div>
    <div class="col-md-3">
      <select name="location" class="form-select">
        <option value="">Any Location</option>
        <!-- Distinct locations -->
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">Filter</button>
    </div>
  </form>

  <div class="list-group shadow-sm">
    <!-- Loop jobs from DB -->
    <a href="/public/job.php?id=1" class="list-group-item list-group-item-action">
      <div class="d-flex justify-content-between">
        <h5 class="mb-1">Frontend Developer</h5>
        <small>Remote</small>
      </div>
      <p class="mb-1 text-muted">TechNova Ltd</p>
    </a>
  </div>
</div>
<?php include '../templates/footer.php'; ?>
