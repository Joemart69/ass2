<?php
$page_title = 'Skill Gallery';
$active = 'Gallery';
require 'includes/header.inc';
require 'includes/nav.inc';
require 'includes/db_connect.inc';
?>

<h2>Skill Gallery</h2>
<div class="grid gallery">
  <?php
    $q = "SELECT skill_id, title, category, level, rate_per_hr, image_path FROM skills ORDER BY created_at DESC";
    if ($res = $conn->query($q)) {
      while ($row = $res->fetch_assoc()) {
        $id = (int)$row['skill_id'];
        $img = $row['image_path'] ?: 'placeholder.png';
        $rate = number_format((float)$row['rate_per_hr'], 2);
        ?>
        <article class="card image-card" data-full="<?= 'assets/images/skills/' . htmlspecialchars($img) ?>" data-title="<?= htmlspecialchars($row['title']) ?>">
          <div class="thumb">
            <img src="<?= 'assets/images/skills/' . htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($row['title']) ?>" />
          </div>
          <div class="card-body">
            <h3><a href="details.php?id=<?= $id ?>"><?= htmlspecialchars($row['title']) ?></a></h3>
            <p class="meta"><?= htmlspecialchars($row['category']) ?> • <?= htmlspecialchars($row['level']) ?> • $<?= $rate ?>/hr</p>
          </div>
        </article>
        <?php
      }
      $res->free();
    }
  ?>
</div>

<div id="modal" class="modal"><img id="modalImg" alt=""><button id="modalClose" class="modal-close">Close</button></div>

<?php
require 'includes/footer.inc';
$conn->close();
