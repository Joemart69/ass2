<?php
$page_title = 'Skill Details';
$active = 'All Skills';
require 'includes/header.inc';
require 'includes/nav.inc';
require 'includes/db_connect.inc';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$skill = null;
if ($id > 0) {
  $stmt = $conn->prepare("SELECT title, description, category, rate_per_hr, level, image_path FROM skills WHERE skill_id = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $res = $stmt->get_result();
  $skill = $res->fetch_assoc();
  $stmt->close();
}
?>

<?php if ($skill): ?>
  <h2><?= htmlspecialchars($skill['title']) ?></h2>
  <div class="details-layout">
    <div class="details-thumb" data-full="<?= 'assets/images/skills/' . htmlspecialchars($skill['image_path'] ?: 'placeholder.png') ?>" data-title="<?= htmlspecialchars($skill['title']) ?>">
      <img src="<?= 'assets/images/skills/' . htmlspecialchars($skill['image_path'] ?: 'placeholder.png') ?>" alt="<?= htmlspecialchars($skill['title']) ?>">
    </div>
    <div class="details-body">
      <p><?= nl2br(htmlspecialchars($skill['description'])) ?></p>
      <p><strong>Category:</strong> <?= htmlspecialchars($skill['category']) ?></p>
      <p><strong>Level:</strong> <?= htmlspecialchars($skill['level']) ?></p>
      <p><strong>Rate:</strong> $<?= number_format((float)$skill['rate_per_hr'], 2) ?>/hr</p>
    </div>
  </div>
<?php else: ?>
  <p>Skill not found.</p>
<?php endif; ?>

<!-- Shared modal -->
<div id="modal" class="modal"><img id="modalImg" alt=""><button id="modalClose" class="modal-close">Close</button></div>

<?php
require 'includes/footer.inc';
$conn->close();
