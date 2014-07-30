<?php
include '../includes/common.php';
$page_title = 'Subjects';
$head_title = head_title();
$admin = TRUE;
$type = 'subject';
include '../includes/partials/top.php';
?>


<?php include '../includes/partials/page_head.php'; ?>


<div class="row">  
<?php
  $records = get_records('subjects');
  include '../includes/partials/records_table.php';
?>
</div>


<?php
include '../includes/partials/bottom.php';
?>