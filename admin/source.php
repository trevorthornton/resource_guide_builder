<?php
include '../includes/common.php';
// Page headers, etc.
$page_title = $project_name . ' | Admin | Publishers';
include '../includes/partials/top.php';
$admin = true;
include '../includes/partials/admin_nav.php';
?>


<div class="row">
  <h1>Publishers</h1>
</div>


<div class="row">  
<?php
  $records = get_records('publishers');
  $edit_path = '/admin/edit_publisher.php';
  include '../includes/partials/records_table.php';
?>
</div>


<?php
include '../includes/partials/bottom.php';
?>