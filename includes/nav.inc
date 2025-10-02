<?php
  // Pages set $active to: 'Home', 'All Skills', 'Gallery', 'Add More', 'Details'
  $is = fn($n) => (isset($active) && $active === $n) ? 'active' : '';
  // CASE-SENSITIVE path from your screenshot:
  $logo_path = 'assets/images/SkillSwap_logo.png';
?>
<header class="site-header">
  <div class="container nav-wrap">
    <!-- Left: logo + links -->
    <div class="d-flex align-items-center" style="gap: 1.25rem;">
      <a href="index.php" class="logo" aria-label="SkillSwap">
        <img src="<?= $logo_path ?>" alt="SkillSwap logo" style="height:40px; width:auto; display:block;">
      </a>

      <nav aria-label="Primary">
        <ul>
          <li><a class="<?= $is('Home') ?>" href="index.php">Home</a></li>
          <li><a class="<?= $is('All Skills') ?>" href="skills.php">All Skills</a></li>
          <li><a class="<?= $is('Gallery') ?>" href="gallery.php">Gallery</a></li>
          <li><a class="<?= $is('Add More') ?>" href="add.php">Add More</a></li>
        </ul>
      </nav>
    </div>

    <!-- Right: search -->
    <form class="search-form" action="skills.php" method="get" role="search">
      <label class="visually-hidden" for="q">Search skills</label>
      <input id="q" name="q" type="search" placeholder="Search skills..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
      <button type="submit" aria-label="Search">🔍</button>
    </form>
  </div>
</header>
