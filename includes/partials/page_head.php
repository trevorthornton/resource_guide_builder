<div class="row">
  <?php
  if (isset($admin)) {
    echo '<div class="right">';
    include 'admin_nav.php';
    echo '</div>';
  }
  ?>
  <h1><?php echo $page_title; ?></h1>
</div>