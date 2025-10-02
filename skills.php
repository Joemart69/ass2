<?php
// skills.php
$active = 'All Skills';
$page_title = 'All Skills';

require __DIR__ . '/includes/db_connect.inc';
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';

// Skills
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
  SELECT skill_id, title, category, level, rate_per_hr
  FROM skills
  WHERE title IN ($list_for_in)
  ORDER BY FIELD(title, $list_for_order)
";
$res = $conn->query($sql);
?>
<main class="container">
  <h1>All Skills</h1>

  <div class="skills-layout">
    <!-- Banner (left) -->
    <div class="skills-banner">
      <img src="assets/images/skills_banner.png" alt="Skills collage banner">
    </div>

    <!-- Table (right) -->
    <div class="table-wrap">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th style="width:42%">Title</th>
            <th style="width:20%">Category</th>
            <th style="width:18%">Level</th>
            <th style="width:20%; text-align:right">Rate ($/hr)</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($row = $res->fetch_assoc()): ?>
              <tr>
                <td>
                  <a href="details.php?id=<?= (int)$row['skill_id'] ?>">
                    <?= htmlspecialchars($row['title']) ?>
                  </a>
                </td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= htmlspecialchars($row['level']) ?></td>
                <td style="text-align:right">$<?= number_format((float)$row['rate_per_hr'], 2) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4">No skills found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<?php require __DIR__ . '/includes/footer.inc'; ?>
