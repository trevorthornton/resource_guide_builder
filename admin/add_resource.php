<?php
include '../includes/common.php';
$page_title = $project_name . ' | Admin | Add Resource';
$admin = TRUE;
$action = 'add';

include '../includes/partials/top.php';

if (isset ($_POST['add'])):
  $attributes = $_POST['resource'];
  var_dump($attributes);
else:
?>


<div class="row">
  <h1>Add a resource</h1>
</div>


<div class="row">
  <?php include '../includes/partials/resource_form.php'; ?>
</div>


<?php
endif;
include '../includes/partials/bottom.php';
?>