<?php
if (!empty($_SESSION['flash'])):
  foreach ($_SESSION['flash'] as $type => $message):
?>
  <div class="alert alert-<?= htmlspecialchars($type) ?> alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($message) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php
  endforeach;
  unset($_SESSION['flash']);
endif;
?>
