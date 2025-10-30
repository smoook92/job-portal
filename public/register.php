<?php
$page_title = "Register";
require_once "../templates/header.php";
require_once "../templates/navbar.php";
require_once "../includes/auth.php";
require_once "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'] ?? null;
    $role = $_POST['role'] ?? 'user';

    if (!$password) {
        flash('danger', 'Password cannot be empty.');
    } else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO users (email, password_hash, role) VALUES (?, ?, ?)");
        $stmt->execute([$email, $password_hash, $role]);

        flash('success', 'Registration successful. Please login.');
        header("Location: login.php");
        exit;
    }
}


?>

<main class="container py-4">
  <h2>Create Account</h2>
  <?php include "../templates/alerts.php"; ?>

  <form method="POST" class="mt-3" style="max-width: 400px;">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Account Type</label>
      <select name="role" class="form-select" required>
        <option value="user">Job Seeker</option>
        <option value="employer">Employer</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</main>

<?php include "../templates/footer.php"; ?>
