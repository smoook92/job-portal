<?php
$page_title = "Login";
require_once "../templates/header.php";
require_once "../templates/navbar.php";
require_once "../includes/auth.php";
require_once "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    if (loginUser($email, $password)) {
        flash('success', 'Welcome back!');
        header("Location: /public/index.php");
        exit;
    } else {
        flash('danger', 'Invalid credentials.');
    }
}
?>

<main class="container py-4">
  <h2>Login</h2>
  <?php include "../templates/alerts.php"; ?>

  <form method="POST" style="max-width: 400px;">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</main>

<?php include "../templates/footer.php"; ?>
