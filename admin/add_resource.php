<?php
include '../includes/common.php';
$page_title = 'Add Resource';
$head_title = head_title();
$admin = TRUE;
$action = 'add';
include '../includes/partials/top.php';

if (isset ($_POST['add'])):
  $attributes = $_POST['resource'];
  var_dump($attributes);
else:
?>

<?php include '../includes/partials/page_head.php'; ?>


<div class="row">
  <?php include '../includes/partials/resource_form.php'; ?>
</div>


<?php
endif;
include '../includes/partials/bottom.php';
?>