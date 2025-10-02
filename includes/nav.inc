<?php
if (!isset($active)) { $active = ''; }
function a($name, $file, $active) {
  $cls = ($active === $name) ? 'class="active"' : '';
  echo "<li><a $cls href=\"$file\">" . htmlspecialchars($name) . "</a></li>";
}
?>
<header class="site-header">
  <div class="container nav-wrap">
    <h1 class="logo"><a href="index.php">SkillSwap</a></h1>
    <nav>
      <ul>
        <?php a('Home', 'index.php', $active); ?>
        <?php a('All Skills', 'skills.php', $active); ?>
        <?php a('Gallery', 'gallery.php', $active); ?>
        <?php a('Add More', 'add.php', $active); ?>
      </ul>
    </nav>
  </div>
</header>
<main class="container">
