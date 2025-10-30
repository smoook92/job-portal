<?php
$page_title = "Home";
include '../templates/header.php';
include '../templates/navbar.php';
?>
<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="fw-bold">Find Your Dream Job</h1>
    <p class="text-muted">Browse thousands of jobs from top employers</p>
    <form class="row justify-content-center" method="get" action="/public/jobs.php">
      <div class="col-md-6 col-sm-8 mb-2">
        <input type="text" name="q" class="form-control form-control-lg" placeholder="Search job title or keyword...">
      </div>
      <div class="col-md-2 col-sm-4 mb-2">
        <button class="btn btn-primary btn-lg w-100" type="submit"><i class="fa fa-search"></i> Search</button>
      </div>
    </form>
  </div>

  <h2 class="h4 mb-4">Featured Jobs</h2>
  <div class="row g-3">
    <!-- Sample static cards (replace with DB query later) -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <h5 class="card-title">PHP Developer</h5>
          <p class="card-text text-muted">AwesomeTech Inc. – Remote</p>
          <a href="/public/job.php?id=1" class="btn btn-outline-primary btn-sm">View Details</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../templates/footer.php'; ?>
