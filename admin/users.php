<?php
require_once "../includes/auth.php";
require_once "../includes/db.php";
requireRole('admin');
$page_title = "Manage Users";
require_once "../templates/header.php";
require_once "../templates/navbar.php";

// Fetch users
$users = $pdo->query("SELECT id, email, role, created_at FROM users ORDER BY id DESC")->fetchAll();
?>

<main class="container py-4">
  <h2>Users & Employers</h2>
  <table class="table table-bordered table-striped mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Role</th>
        <th>Registered At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= $u['role'] ?></td>
        <td><?= $u['created_at'] ?></td>
        <td>
          <a href="users.php?delete=<?= $u['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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
    $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$id]);
    header("Location: users.php");
    exit;
}
require_once "../templates/footer.php";
?>
