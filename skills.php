<?php
$page_title = 'All Skills';
$active = 'All Skills';
require 'includes/header.inc';
require 'includes/nav.inc';
require 'includes/db_connect.inc';
?>

<h2>All Skills</h2>

<div class="skills-layout">
  <aside class="skills-banner">
    <img src="assets/images/skills_banner.png" alt="Skills banner">
  </aside>

  <div class="table-wrap table-responsive">
    <table class="table table-borderless mb-0">
      <thead>
        <tr>
          <th>Title</th>
          <th>Category</th>
          <th>Level</th>
          <th class="text-end">Rate ($/hr)</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $q = "SELECT skill_id, title, category, level, rate_per_hr
                FROM skills ORDER BY created_at DESC, title ASC";
          if ($res = $conn->query($q)) {
            while ($row = $res->fetch_assoc()) {
              $id = (int)$row['skill_id'];
              $rate = number_format((float)$row['rate_per_hr'], 2);
              echo '<tr>';
              echo '<td><a href="details.php?id='.$id.'">'.htmlspecialchars($row['title']).'</a></td>';
              echo '<td>'.htmlspecialchars($row['category']).'</td>';
              echo '<td>'.htmlspecialchars($row['level']).'</td>';
              echo '<td class="text-end">$'.$rate.'</td>';
              echo '</tr>';
            }
            $res->free();
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php
require 'includes/footer.inc';
$conn->close();
