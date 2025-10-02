<?php
$page_title = 'Skill Details';
$active = 'All Skills';
require 'includes/header.inc';
require 'includes/nav.inc';
require 'includes/db_connect.inc';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT title, description, category, rate_per_hr, level, image_path FROM skills WHERE skill_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($title, $description, $category, $rate, $level, $image);
$found = $stmt->fetch();
$stmt->close();
?>

<?php if ($found): ?>
  <h2><?= htmlspecialchars($title) ?></h2>
  <div class="details-layout">
    <div class="details-thumb" data-full="<?= 'assets/images/skills/' . htmlspecialchars($image ?: 'placeholder.png') ?>" data-title="<?= htmlspecialchars($title) ?>">
      <img src="<?= 'assets/images/skills/' . htmlspecialchars($image ?: 'placeholder.png') ?>" alt="<?= htmlspecialchars($title) ?>" />
    </div>
    <div class="details-body">
      <p><?= nl2br(htmlspecialchars($description)) ?></p>
      <p><strong>Category:</strong> <?= htmlspecialchars($category) ?></p>
      <p><strong>Level:</strong> <?= htmlspecialchars($level) ?></p>
      <p><strong>Rate:</strong> $<?= number_format((float)$rate, 2) ?>/hr</p>
    </div>
  </div>
<?php else: ?>
  <p>Skill not found.</p>
<?php endif; ?>

<div id="modal" class="modal"><img id="modalImg" alt=""><button id="modalClose" class="modal-close">Close</button></div>

<?php
require 'includes/footer.inc';
$conn->close();
