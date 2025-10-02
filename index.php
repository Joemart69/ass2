<?php
$page_title = 'SkillSwap - Home';
$active = 'Home';
require 'includes/header.inc';
require 'includes/nav.inc';
require 'includes/db_connect.inc';
?>

<!-- Static carousel -->
<div id="heroCarousel" class="carousel slide mb-3" data-bs-ride="false">
  <div class="carousel-inner">
    <?php
      $slides = [
        'assets/images/skills_banner.png',
        'assets/images/skills_banner.png',
        'assets/images/skills_banner.png'
      ];
      foreach ($slides as $i => $src) {
        $activeClass = $i === 0 ? 'active' : '';
        echo '<div class="carousel-item '.$activeClass.'">';
        echo '<img src="'.htmlspecialchars($src).'" class="d-block w-100" alt="Slide '.($i+1).'" style="height:320px;object-fit:cover">';
        echo '</div>';
      }
    ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

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
                <img src="<?= 'assets/images/skills/' . htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
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

<!-- Shared modal -->
<div id="modal" class="modal"><img id="modalImg" alt=""><button id="modalClose" class="modal-close">Close</button></div>

<?php
require 'includes/footer.inc';
$conn->close();
