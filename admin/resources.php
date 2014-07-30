<?php
include '../includes/common.php';
$page_title = 'Add Resource';
$head_title = head_title();
$admin = TRUE;
include '../includes/partials/top.php';

if (isset ($_POST['add'])):
  $attributes = $_POST['resource'];
  var_dump($attributes);
else:
?>

<?php include '../includes/partials/page_head.php'; ?>


<div class="row">
  
  <?php include '../includes/partials/resources_table.php'; ?>

</div>


<?php
endif;
include '../includes/partials/bottom.php';
?>