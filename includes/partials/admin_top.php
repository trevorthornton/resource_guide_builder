<?php
include '../common.php';
$display_title = 'Add Resource';
$page_title = "$project_name | $display_title";
$admin = TRUE;
$action = 'edit';

include '../includes/partials/top.php';
?>

<div class="row">
  <div class="right"><?php include 'admin_nav.php'; ?></div>
  <h1><?php echo $display_title; ?></h1>
</div>