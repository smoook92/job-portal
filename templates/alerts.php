<?php if (!empty($_SESSION['flash'])): ?>
  <?php foreach ($_SESSION['flash'] as $type => $message): ?>
    <div class="alert alert-<?= htmlspecialchars($type) ?> alert-dismissible fade show mt-3" role="alert">
      <?= htmlspecialchars($message) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endforeach; ?>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
