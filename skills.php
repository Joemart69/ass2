<?php
// ---- DB CONNECT ----
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'skillswap';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die('Database connection failed: ' . $conn->connect_error);
}

$sql = "SELECT skill_id, title, category, level, rate_per_hr FROM skills ORDER BY created_at DESC, title ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SkillSwap – All Skills</title>

  <!-- Google Fonts + Material Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Ysabeau+SC&family=Libre+Baskerville:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Your site styles -->
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body { background:#fff5f8; }
    header.navbar { background:#cd4f07; }
    header .navbar-brand { font-family:"Libre Baskerville", serif; font-weight:700; color:#fff; }
    header .nav-link { color:#fff; font-weight:700; }
    header .nav-link:hover { text-decoration:underline; }

    .page-title { 
      font-family:"Libre Baskerville", serif; 
      color:#893a14; 
      font-size:2.1rem; 
      margin: 1.25rem 0 1rem;
    }

    .skills-banner {
      border-radius: 8px;
      overflow:hidden;
      border:1px solid #f0e1db;
      background:#fff;
    }
    .skills-banner img { width:100%; display:block; }

    .skills-table {
      background:#fff;
      border:1px solid #f0e1db;
      border-radius:8px;
      overflow:hidden;
      font-family: 'Ysabeau SC', sans-serif;
    }
    .skills-table thead th {
      background:#f7eee9;
      color:#5b2d16;
      font-weight:700;
    }
    .skills-table tbody tr:nth-child(even){ background:#fffaf8; }
    .skills-table td, .skills-table th { vertical-align: middle; }
    .skills-table a { color:#2a5caa; text-decoration:none; }
    .skills-table a:hover { text-decoration:underline; }

    footer {
      background:#6b5b95;
      color:#fff;
      text-align:center;
      padding: 1rem 0;
      margin-top: 3rem;
      font-family: 'Ysabeau SC', sans-serif;
    }
  </style>
</head>
<body>

<header class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="index.html">SkillSwap</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="material-icons" style="color:#fff;">menu</span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="skills.php">All Skills</a></li>
        <li class="nav-item"><a class="nav-link" href="gallery.html">Gallery</a></li>
        <li class="nav-item"><a class="nav-link" href="add.html">Add Skill</a></li>
      </ul>
    </div>
  </div>
</header>

<main class="container">
  <h1 class="page-title">All Skills</h1>

  <div class="row g-4 align-items-start">
    <!-- Left column: banner image -->
    <div class="col-12 col-lg-5">
      <div class="skills-banner">
        <img src="assets/images/skills_banner.png" alt="Skills collage banner">
      </div>
    </div>

    <!-- Right column: skills table -->
    <div class="col-12 col-lg-7">
      <div class="table-responsive skills-table">
        <table class="table table-borderless mb-0">
          <thead>
          <tr>
            <th scope="col" style="width:45%;">Title</th>
            <th scope="col" style="width:20%;">Category</th>
            <th scope="col" style="width:20%;">Level</th>
            <th scope="col" class="text-end" style="width:15%;">Rate ($/hr)</th>
          </tr>
          </thead>
          <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td>
                  <a href="details.php?id=<?php echo (int)$row['skill_id']; ?>">
                    <?php echo htmlspecialchars($row['title']); ?>
                  </a>
                </td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['level']); ?></td>
                <td class="text-end"><?php echo '$' . number_format((float)$row['rate_per_hr'], 2); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
              <tr><td colspan="4">No skills found.</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<footer>
  <div class="container">
    &copy; 2025 SkillSwap. All rights reserved.
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn?->close();
?>
