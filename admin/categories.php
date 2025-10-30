<?php
require_once "../includes/auth.php";
require_once "../includes/db.php";
requireRole('admin');
$page_title = "Manage Categories";
require_once "../templates/header.php";
require_once "../templates/navbar.php";

// Add new category
if ($_SERVER['REQUEST_METHOD']==='POST' && !empty($_POST['name'])) {
    $name = trim($_POST['name']);
    $pdo->prepare("INSERT INTO categories (name) VALUES (?)")->execute([$name]);
    header("Location: categories.php");
    exit;
}

// Fetch categories
$cats = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();
?>

<main class="container py-4">
  <h2>Categories</h2>

  <form method="POST" class="mb-4">
    <div class="input-group">
      <input type="text" name="name" class="form-control" placeholder="New category" required>
      <button type="submit" class="btn btn-success">Add</button>
    </div>
  </form>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($cats as $c): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td>
          <a href="categories.php?delete=<?= $c['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>

<?php
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM categories WHERE id=?")->execute([$id]);
    header("Location: categories.php");
    exit;
}
require_once "../templates/footer.php";
?>
