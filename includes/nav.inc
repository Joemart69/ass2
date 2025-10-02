<?php
if (!isset($active)) { $active = ''; }
function nav_item($label, $href, $active) {
  $cls = ($active === $label) ? 'class="active"' : '';
  echo "<li><a $cls href=\"$href\">" . htmlspecialchars($label) . "</a></li>";
}
?>
<header class="site-header">
  <div class="container nav-wrap">
    <h1 class="logo"><a href="index.php">SkillSwap</a></h1>
    <nav>
      <ul>
        <?php nav_item('Home', 'index.php', $active); ?>
        <?php nav_item('All Skills', 'skills.php', $active); ?>
        <?php nav_item('Gallery', 'gallery.php', $active); ?>
        <?php nav_item('Add More', 'add.php', $active); ?>
      </ul>
    </nav>
  </div>
</header>
<main class="container">
