<?php
$page_title = 'SkillSwap';
$active = 'Home';
include 'includes/header.inc';
include 'includes/nav.inc';
include 'includes/db_connect.inc';
?>

<main class="container">

  <!-- Carousel -->
  <div id="homeHero" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#homeHero" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#homeHero" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#homeHero" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#homeHero" data-bs-slide-to="3"></button>
    </div>
    <div class="carousel-inner rounded-3 overflow-hidden">
      <div class="carousel-item active">
        <img src="assets/images/skills/photo1.png" class="d-block w-100 hero-img" alt="Beginner Guitar Lessons">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="mb-0">Beginner Guitar Lessons</h2>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/skills/photo2.png" class="d-block w-100 hero-img" alt="Intermediate Fingerstyle">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="mb-0">Intermediate Fingerstyle</h2>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/skills/photo3.png" class="d-block w-100 hero-img" alt="Artisan Bread Baking">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="mb-0">Artisan Bread Baking</h2>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/skills/photo4.png" class="d-block w-100 hero-img" alt="French Pastry Making">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="mb-0">French Pastry Making</h2>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeHero" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeHero" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Latest Skills -->
  <div class="container mb-5 latest-skills">
    <h2 class="mb-3">Latest Skills</h2>
    <div class="row g-4">
      <?php
      $ids_sql = "SELECT * FROM skills
                  WHERE title IN ('Intro to PHP & MySQL','Intermediate Fingerstyle','Artisan Bread Baking','French Pastry Making')
                  ORDER BY FIELD(title,
                    'Intro to PHP & MySQL',
                    'Intermediate Fingerstyle',
                    'Artisan Bread Baking',
                    'French Pastry Making')";
      $res = $conn->query($ids_sql);
      while ($row = $res->fetch_assoc()):
      ?>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card h-100">
            <div class="card-body">
              <h3 class="card-title"><a href="details.php?id=<?= (int)$row['skill_id'] ?>">
                <?= htmlspecialchars($row['title']) ?></a>
              </h3>
              <p class="mb-2">Rate: $<?= number_format($row['rate_per_hr'], 2) ?>/hr</p>
              <a href="details.php?id=<?= (int)$row['skill_id'] ?>" class="btn btn-primary">View Details</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

</main>

<?php include 'includes/footer.inc'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
