<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "skillswap";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("DB connection failed: " . $conn->connect_error);
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Collect fields
  $title       = trim($_POST['title'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $category    = trim($_POST['category'] ?? '');
  $rate        = trim($_POST['rate'] ?? '');
  $level       = trim($_POST['level'] ?? '');

  // Validate fields
  if ($title === '')        $errors[] = "Title is required.";
  if ($description === '')  $errors[] = "Description is required.";
  if ($category === '')     $errors[] = "Category is required.";
  if ($rate === '' || !is_numeric($rate) || $rate < 0) $errors[] = "Rate must be a positive number.";
  if (!in_array($level, ['Beginner','Intermediate','Expert'])) $errors[] = "Invalid level.";

  // Handle image upload
  $imageName = null;
  if (!empty($_FILES['image']['name'])) {
    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
      $errors[] = "Image must be JPG, JPEG, PNG, GIF, or WEBP.";
    } elseif ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
      $errors[] = "Image upload error.";
    } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
      $errors[] = "Image must be under 2MB.";
    } else {
      $safeBase = preg_replace('/[^a-z0-9\-_.]/i', '_', pathinfo($_FILES['image']['name'], PATHINFO_FILENAME));
      $imageName = $safeBase . '_' . time() . '.' . $ext;
      $dest = __DIR__ . '/assets/images/' . $imageName;
      if (!move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
        $errors[] = "Failed to save image.";
      }
    }
  }

  // If valid, insert row
  if (!$errors) {
    $stmt = $conn->prepare("INSERT INTO skills (title, description, category, rate_per_hr, level, image_path) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("sssiss", $title, $description, $category, $rate, $level, $imageName);
    if ($stmt->execute()) {
      $success = true;
      // reset fields
      $title = $description = $category = $rate = $level = '';
    } else {
      $errors[] = "DB error: " . $conn->error;
    }
    $stmt->close();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SkillSwap - Add Skill</title>
  <link href="https://fonts.googleapis.com/css2?family=Ysabeau+SC&family=Libre+Baskerville&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    .form-wrap { padding: 2rem; max-width: 900px; margin: 0 auto; }
    form .row { margin-bottom: 1rem; }
    label { display:block; font-weight:700; margin-bottom:.35rem; }
    input[type="text"], input[type="number"], textarea, select {
      width:100%; padding:.7rem .85rem; border:1px solid #ddd; border-radius:8px; font: inherit;
    }
    textarea { min-height: 140px; }
    .help { font-size:.9rem; color:#666; }
    .btn { border:0; padding:.65rem 1.1rem; border-radius:8px; font-weight:700; cursor:pointer; }
    .btn-primary { background:#cd4f07; color:#fff; }
    .alert { padding:.75rem 1rem; border-radius:8px; margin-bottom:1rem; }
    .alert-success { background:#e7f7ec; color:#16753e; border:1px solid #cbead5; }
    .alert-error { background:#fdecec; color:#9b1b1b; border:1px solid #f6c7c7; }
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

<main class="form-wrap">
  <h2>Add New Skill</h2>

  <?php if ($success): ?>
    <div class="alert alert-success">Skill added! View it on <a href="skills.php"><strong>All Skills</strong></a>.</div>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="alert alert-error">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?php echo htmlspecialchars($e); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="" method="post" enctype="multipart/form-data" id="skillForm" novalidate>
    <div class="row">
      <label for="title">Title *</label>
      <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title ?? ''); ?>" placeholder="Enter skill title" required />
    </div>
    <div class="row">
      <label for="description">Description *</label>
      <textarea id="description" name="description" placeholder="Enter description" required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
    </div>
    <div class="row">
      <label for="category">Category *</label>
      <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($category ?? ''); ?>" placeholder="e.g., Music, Art, Cooking" required />
    </div>
    <div class="row">
      <label for="rate">Rate per Hour ($) *</label>
      <input type="number" min="0" step="0.01" id="rate" name="rate" value="<?php echo htmlspecialchars($rate ?? ''); ?>" placeholder="e.g., 30" required />
    </div>
    <div class="row">
      <label for="level">Level *</label>
      <select id="level" name="level" required>
        <?php
          $levels = ['Beginner','Intermediate','Expert'];
          $current = $level ?? '';
          foreach ($levels as $lv) {
            $sel = ($current === $lv) ? 'selected' : '';
            echo "<option value=\"$lv\" $sel>$lv</option>";
          }
        ?>
      </select>
    </div>
    <div class="row">
      <label for="image">Skill Image (JPG/PNG/GIF/WEBP, &lt; 2 MB)</label>
      <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif,.webp" />
      <p class="help">If omitted, a placeholder can be used.</p>
    </div>

    <button class="btn btn-primary" type="submit">Submit</button>
  </form>
</main>

<footer>
  <p>&copy; 2025 SkillSwap. All rights reserved.</p>
</footer>

<script>
// Client-side quick checks (complements PHP validation)
document.getElementById('skillForm').addEventListener('submit', function (e) {
  const file = document.getElementById('image').files[0];
  if (file) {
    const ok = ['image/jpeg','image/png','image/gif','image/webp'];
    if (!ok.includes(file.type)) {
      e.preventDefault();
      alert('Image must be JPG, PNG, GIF or WEBP.');
      return;
    }
    if (file.size > 2 * 1024 * 1024) {
      e.preventDefault();
      alert('Image must be under 2MB.');
      return;
    }
  }
});
</script>
</body>
</html>
<?php $conn->close(); ?>
