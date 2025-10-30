<?php
require_once "../includes/auth.php";
require_once "../includes/db.php";
requireRole('admin');
$page_title = "Site Settings";
require_once "../templates/header.php";
require_once "../templates/navbar.php";

// Load settings
$settings = $pdo->query("SELECT * FROM settings LIMIT 1")->fetch();

// Update settings
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $site_name = $_POST['site_name'] ?? '';
    $contact_email = $_POST['contact_email'] ?? '';
    $logo_url = $_POST['logo_url'] ?? '';
    $pdo->prepare("UPDATE settings SET site_name=?, contact_email=?, logo_url=? WHERE id=1")
        ->execute([$site_name, $contact_email, $logo_url]);
    flash('success','Settings updated.');
    header("Location: settings.php");
    exit;
}
?>

<main class="container py-4">
  <h2>Site Settings</h2>
  <?php include "../templates/alerts.php"; ?>

  <form method="POST" class="mt-3" style="max-width: 600px;">
    <div class="mb-3">
      <label>Site Name</label>
      <input type="text" name="site_name" class="form-control" value="<?= htmlspecialchars($settings['site_name']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Contact Email</label>
      <input type="email" name="contact_email" class="form-control" value="<?= htmlspecialchars($settings['contact_email']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Logo URL</label>
      <input type="text" name="logo_url" class="form-control" value="<?= htmlspecialchars($settings['logo_url']) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Save Settings</button>
  </form>
</main>

<?php require_once "../templates/footer.php"; ?>
