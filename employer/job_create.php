<?php
require_once "../includes/auth.php";
requireRole('employer');
require_once "../includes/db.php";
require_once "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $description = sanitize($_POST['description']);
    $category_id = (int)$_POST['category_id'];
    $employer_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO jobs (title, description, category_id, employer_id, created_at)
                           VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$title, $description, $category_id, $employer_id]);

    flash('success', 'Job posted successfully.');
    header("Location: /employer/jobs.php");
    exit;
}
?>

<?php include "../templates/header.php"; include "../templates/navbar.php"; ?>
<main class="container py-4">
  <h2>Post a New Job</h2>
  <?php include "../templates/alerts.php"; ?>

  <form method="POST">
    <div class="mb-3">
      <label>Job Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" rows="5" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
      <label>Category</label>
      <select name="category_id" class="form-select" required>
        <option value="1">IT</option>
        <option value="2">Marketing</option>
        <option value="3">Finance</option>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Publish Job</button>
  </form>
</main>
<?php include "../templates/footer.php"; ?>
