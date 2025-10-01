<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "skillswap";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("DB connection failed: " . $conn->connect_error);
}

$sql = "SELECT skill_id, title, description, category, level, rate_per_hr, image_path 
        FROM skills ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SkillSwap - Gallery</title>
  <link href="https://fonts.googleapis.com/css2?family=Ysabeau+SC&family=Libre+Baskerville&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    .gallery-wrap { padding: 2rem; }
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: 1.25rem;
      margin-top: 1rem;
    }
    .card {
      background: #fff;
      border: 1px solid #eee;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0,0,0,.06);
      transition: transform .15s ease, box-shadow .15s ease;
      cursor: pointer;
    }
    .card:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,.08); }
    .card img { display:block; width:100%; height:180px; object-fit:cover; }
    .card .card-body { padding: .85rem 1rem; }
    .card .title { font-family: 'Libre Baskerville', serif; font-size: 1.05rem; margin: 0 0 .25rem; color:#2b2b2b; }
    .card .meta { font-size:.9rem; color:#666; }

    /* Modal */
    .modal-backdrop {
      position: fixed; inset: 0; background: rgba(0,0,0,.6);
      display: none; align-items: center; justify-content: center; z-index: 999;
      padding: 1rem;
    }
    .modal {
      background:#fff; border-radius: 12px; max-width: 920px; width:100%;
      overflow: hidden; box-shadow: 0 16px 40px rgba(0,0,0,.25);
      animation: pop .12s ease-out;
    }
    @keyframes pop { from { transform: scale(.96); opacity:.6 } to { transform: scale(1); opacity:1 } }
    .modal img { display:block; width:100%; height:auto; }
    .modal .modal-footer {
      padding:.75rem 1rem; display:flex; justify-content:flex-end; gap:.5rem;
      background:#fafafa; border-top:1px solid #eee;
    }
    .btn { border:0; padding:.55rem .9rem; border-radius:8px; font-weight:600; cursor:pointer; }
    .btn-close { background:#e9ecef; }
    .btn-view { background:#cd4f07; color:#fff; }
  </style>
</head>
<body>
<header>
  <h1>SkillSwap</h1>
  <nav>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="skills.php">All Skills</a></li>
      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="add.php">Add More</a></li>
    </ul>
  </nav>
</header>

<main class="gallery-wrap">
  <h2>Skill Gallery</h2>

  <section class="gallery-grid" id="gallery">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <article class="card" data-full="assets/images/<?php echo htmlspecialchars($row['image_path']); ?>">
          <img src="assets/images/<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
          <div class="card-body">
            <p class="title"><?php echo htmlspecialchars($row['title']); ?></p>
            <p class="meta">
              <?php echo htmlspecialchars($row['category']); ?> •
              <?php echo htmlspecialchars($row['level']); ?> •
              $<?php echo number_format((float)$row['rate_per_hr'], 2); ?>/hr
            </p>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No skills yet. Add one!</p>
    <?php endif; ?>
  </section>
</main>

<footer>
  <p>&copy; 2025 SkillSwap. All rights reserved.</p>
</footer>

<!-- Modal -->
<div class="modal-backdrop" id="backdrop">
  <div class="modal" role="dialog" aria-modal="true">
    <img id="modalImg" src="" alt="Preview">
    <div class="modal-footer">
      <a id="viewLink" href="#" class="btn btn-view">View Details</a>
      <button class="btn btn-close" id="closeBtn">Close</button>
    </div>
  </div>
</div>

<script>
  const backdrop = document.getElementById('backdrop');
  const modalImg = document.getElementById('modalImg');
  const viewLink = document.getElementById('viewLink');

  document.getElementById('gallery').addEventListener('click', (e) => {
    const card = e.target.closest('.card');
    if (!card) return;
    const full = card.dataset.full;
    modalImg.src = full;
    viewLink.href = 'skills.php';
    backdrop.style.display = 'flex';
  });

  document.getElementById('closeBtn').addEventListener('click', () => {
    backdrop.style.display = 'none';
    modalImg.src = '';
  });

  backdrop.addEventListener('click', (e) => {
    if (e.target === backdrop) {
      backdrop.style.display = 'none';
      modalImg.src = '';
    }
  });
</script>
</body>
</html>
<?php $conn->close(); ?>
