<?php
require_once "../includes/auth.php";
require_once "../includes/db.php";
requireRole('admin');
$page_title = "Manage Jobs";
require_once "../templates/header.php";
require_once "../templates/navbar.php";

$jobs = $pdo->query("SELECT j.id, j.title, j.created_at, u.email AS employer
                     FROM jobs j
                     JOIN users u ON j.employer_id = u.id
                     ORDER BY j.id DESC")->fetchAll();
?>

<main class="container py-4">
  <h2>Jobs</h2>
  <table class="table table-bordered table-striped mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Employer</th>
        <th>Posted At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($jobs as $job): ?>
      <tr>
        <td><?= $job['id'] ?></td>
        <td><?= htmlspecialchars($job['title']) ?></td>
        <td><?= htmlspecialchars($job['employer']) ?></td>
        <td><?= $job['created_at'] ?></td>
        <td>
          <a href="jobs.php?delete=<?= $job['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>

<?php
// Handle deletion
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM jobs WHERE id=?")->execute([$id]);
    header("Location: jobs.php");
    exit;
}
require_once "../templates/footer.php";
?>
