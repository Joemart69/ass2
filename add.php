<?php
$page_title = 'Add New Skill';
$active = 'Add More';
require 'includes/header.inc';
require 'includes/nav.inc';
require 'includes/db_connect.inc';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title       = trim($_POST['title'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $category    = trim($_POST['category'] ?? '');
  $rate        = trim($_POST['rate'] ?? '');
  $level       = trim($_POST['level'] ?? 'Beginner');

  if ($title === '')       $errors[] = 'Title is required.';
  if ($description === '') $errors[] = 'Description is required.';
  if ($category === '')    $errors[] = 'Category is required.';
  if ($rate === '' || !is_numeric($rate)) $errors[] = 'Rate must be a number.';
  if (!in_array($level, ['Beginner','Intermediate','Expert'], true)) $errors[] = 'Invalid level.';

  $imageName = null;
  if (!empty($_FILES['image']['name'])) {
    $file = $_FILES['image'];
    if ($file['error'] === UPLOAD_ERR_OK) {
      $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
        'image/svg+xml' => 'svg'
      ];
      $type = mime_content_type($file['tmp_name']);
      if (!isset($allowed[$type])) {
        $errors[] = 'Image must be JPG, PNG, GIF, WEBP or SVG.';
      } elseif ($file['size'] > 2 * 1024 * 1024) {
        $errors[] = 'Image must be under 2MB.';
      } else {
        $base = preg_replace('/[^a-z0-9\-]+/i', '-', strtolower($title));
        $imageName = time().'_'.$base.'.'.$allowed[$type];
        $dest = __DIR__ . '/assets/images/skills/' . $imageName;
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
          $errors[] = 'Could not save uploaded file.';
          $imageName = null;
        }
      }
    } elseif ($file['error'] !== UPLOAD_ERR_NO_FILE) {
      $errors[] = 'Image upload failed.';
    }
  }

  if (!$errors) {
    $stmt = $conn->prepare("INSERT INTO skills (title, description, category, rate_per_hr, level, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssiss', $title, $description, $category, $rate, $level, $imageName);
    if ($stmt->execute()) {
      header('Location: skills.php');
      exit;
    } else {
      $errors[] = 'Database insert failed.';
    }
    $stmt->close();
  }
}
?>

<h2>Add New Skill</h2>

<?php if ($errors): ?>
  <div class="alert alert-danger">
    <ul class="mb-0"><?php foreach ($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul>
  </div>
<?php endif; ?>

<form id="skillForm" class="form" action="" method="post" enctype="multipart/form-data" novalidate>
  <label>Title *<input type="text" name="title" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"></label>
  <label>Description *<textarea name="description" rows="6" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea></label>
  <label>Category *<input type="text" name="category" required value="<?= htmlspecialchars($_POST['category'] ?? '') ?>"></label>
  <label>Rate per Hour ($) *<input type="number" name="rate" step="0.01" min="0" required value="<?= htmlspecialchars($_POST['rate'] ?? '') ?>"></label>
  <label>Level *
    <select name="level" required>
      <?php
        $levels = ['Beginner','Intermediate','Expert'];
        $sel = $_POST['level'] ?? 'Beginner';
        foreach ($levels as $lv) {
          $s = $sel === $lv ? 'selected' : '';
          echo "<option $s>$lv</option>";
        }
      ?>
    </select>
  </label>
  <label>Skill Image <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.gif,.webp,.svg"></label>
  <button type="submit" class="btn">Submit</button>
</form>

<?php
require 'includes/footer.inc';
$conn->close();
