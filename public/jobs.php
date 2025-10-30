<?php
$page_title = "Job Listings";
include_once "../templates/header.php";
include_once "../templates/navbar.php";
include_once "../includes/db.php";

$stmt = $pdo->query("SELECT jobs.*, employers.company_name FROM jobs
                     JOIN employers ON jobs.employer_id = employers.id
                     ORDER BY jobs.created_at DESC LIMIT 10");
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container py-4">
  <h2 class="mb-4">Latest Jobs</h2>
  <div class="row">
    <?php foreach ($jobs as $job): ?>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($job['title']); ?></h5>
            <p class="card-text text-muted"><?= htmlspecialchars($job['company_name']); ?></p>
            <a href="/public/job.php?id=<?= $job['id']; ?>" class="btn btn-outline-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<?php include_once "../templates/footer.php"; ?>
