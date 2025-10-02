<?php
// details.php
$active = 'Details';
$page_title = 'Skill Details';

require __DIR__ . '/includes/db_connect.inc';
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$sql = "SELECT skill_id, title, image_path, category, level, rate_per_hr, description
        FROM skills
        WHERE skill_id = $id";
$res = $conn->query($sql);
$skill = $res && $res->num_rows > 0 ? $res->fetch_assoc() : null;
?>
<main class="container">
  <?php if ($skill): ?>
    <h1><?= htmlspecialchars($skill['title']) ?></h1>

    <div class="details-layout">
      <div class="details-thumb">
        <img
          src="assets/images/skills/<?= htmlspecialchars($skill['image_path']) ?>"
          alt="<?= htmlspecialchars($skill['title']) ?>"
          data-full="assets/images/skills/<?= htmlspecialchars($skill['image_path']) ?>"
        />
      </div>
      <div>
        <p><strong>Category:</strong> <?= htmlspecialchars($skill['category']) ?></p>
        <p><strong>Level:</strong> <?= htmlspecialchars($skill['level']) ?></p>
        <p><strong>Rate:</strong> $<?= number_format((float)$skill['rate_per_hr'], 2) ?>/hr</p>
        <p><strong>Description:</strong></p>
        <p><?= nl2br(htmlspecialchars($skill['description'])) ?></p>
      </div>
    </div>
  <?php else: ?>
    <p>Skill not found.</p>
  <?php endif; ?>

  <!-- Modal (IDs must match scripts.js) -->
  <div id="imgModal" class="modal" role="dialog" aria-modal="true" aria-label="Image preview">
    <button id="modalClose" class="modal-close" aria-label="Close preview">✕</button>
    <img id="modalImg" src="" alt="">
  </div>
</main>

<?php require __DIR__ . '/includes/footer.inc'; ?>
