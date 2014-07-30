<?php
include '../includes/common.php';
$page_title = 'Resource types';
$head_title = head_title();
$admin = TRUE;
$type = 'resource_type';
include '../includes/partials/top.php';
?>


<?php include '../includes/partials/page_head.php'; ?>


<div class="row">  
<?php
  $records = get_records('resource_types');
  include '../includes/partials/records_table.php';
?>
</div>


<?php
include '../includes/partials/bottom.php';
?>