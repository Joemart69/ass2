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
    <input type="text" value="Skills collage banner" readonly />
  </aside>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Category</th>
          <th>Level</th>
          <th>Rate ($/hr)</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $q = "SELECT skill_id, title, category, level, rate_per_hr FROM skills ORDER BY title ASC";
          if ($res = $conn->query($q)) {
            while ($row = $res->fetch_assoc()) {
              $id = (int)$row['skill_id'];
              $rate = number_format((float)$row['rate_per_hr'], 2);
              echo '<tr>';
              echo '<td><a href="details.php?id='.$id.'">'.htmlspecialchars($row['title']).'</a></td>';
              echo '<td>'.htmlspecialchars($row['category']).'</td>';
              echo '<td>'.htmlspecialchars($row['level']).'</td>';
              echo '<td>$'.$rate.'</td>';
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
