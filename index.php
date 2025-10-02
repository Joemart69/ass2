<?php
$page_title = 'SkillSwap - Home';
$active = 'Home';
require 'includes/header.inc';
require 'includes/nav.inc';
require 'includes/db_connect.inc';
?>

<section class="hero">
  <img src="assets/images/skills_banner.png" alt="Skills banner" />
  <div class="hero-overlay">
    <h2>Browse the latest skills shared by our community.</h2>
  </div>
</section>

<section class="cards">
  <h2 class="section-title">Latest Skills</h2>
  <div class="grid">
    <?php
      $q = "SELECT skill_id, title, description, category, rate_per_hr, level, image_path
            FROM skills ORDER BY created_at DESC LIMIT 4";
      if ($res = $conn->query($q)) {
        while ($row = $res->fetch_assoc()) {
          $id   = (int)$row['skill_id'];
          $img  = $row['image_path'] ?: 'placeholder.png';
          $rate = number_format((float)$row['rate_per_hr'], 2);
          ?>
            <article class="card">
              <div class="thumb" data-full="<?= 'assets/images/skills/' . htmlspecialchars($img) ?>" data-title="<?= htmlspecialchars($row['title']) ?>">
                <img src="<?= 'assets/images/skills/' . htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($row['title']) ?>" />
              </div>
              <div class="card-body">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p class="meta"><?= htmlspecialchars($row['category']) ?> • <?= htmlspecialchars($row['level']) ?> • $<?= $rate ?>/hr</p>
                <a class="btn" href="details.php?id=<?= $id ?>">View Details</a>
              </div>
            </article>
          <?php
        }
        $res->free();
      }
    ?>
  </div>
</section>

<div id="modal" class="modal"><img id="modalImg" alt=""><button id="modalClose" class="modal-close">Close</button></div>

<?php
require 'includes/footer.inc';
$conn->close();
