<?php
// gallery.php
$active = 'Gallery';
$page_title = 'Skill Gallery';

require __DIR__ . '/includes/db_connect.inc';
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';

$must_have = [
  "Beginner Guitar Lessons",
  "Intermediate Fingerstyle",
  "Artisan Bread Baking",
  "French Pastry Making",
  "Watercolor Basics",
  "Digital Illustration with Procreate",
  "Morning Vinyasa Flow",
  "Intro to PHP & MySQL"
];

$quoted = array_map(fn($t) => "'" . $conn->real_escape_string($t) . "'", $must_have);
$list_for_in    = implode(',', $quoted);
$list_for_order = implode(',', $quoted);

$sql = "
  SELECT skill_id, title, image_path, category, level, rate_per_hr
  FROM skills
  WHERE title IN ($list_for_in)
  ORDER BY FIELD(title, $list_for_order)
";
$res = $conn->query($sql);
?>
<main class="container gallery">
  <h1>Skill Gallery</h1>

  <div class="gallery-grid">
    <?php if ($res && $res->num_rows > 0): ?>
      <?php while ($row = $res->fetch_assoc()): ?>
        <figure class="image-card">
          <img
            src="assets/images/skills/<?= htmlspecialchars($row['image_path']) ?>"
            alt="<?= htmlspecialchars($row['title']) ?>"
            data-full="assets/images/skills/<?= htmlspecialchars($row['image_path']) ?>"
          />
          <figcaption>
            <a href="details.php?id=<?= (int)$row['skill_id'] ?>">
              <?= htmlspecialchars($row['title']) ?>
            </a>
          </figcaption>
        </figure>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No skills found.</p>
    <?php endif; ?>
  </div>

  <!-- Modal -->
  <div id="imgModal" class="modal" role="dialog" aria-modal="true" aria-label="Image preview">
    <button id="modalClose" class="modal-close" aria-label="Close preview">✕</button>
    <img id="modalImg" src="" alt="">
  </div>
</main>

<?php require __DIR__ . '/includes/footer.inc'; ?>
