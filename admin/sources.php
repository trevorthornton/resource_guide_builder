<?php
include '../includes/common.php';
$page_title = 'Sources';
$head_title = head_title();
$admin = TRUE;
$type = 'source';
include '../includes/partials/top.php';
?>


<?php include '../includes/partials/page_head.php'; ?>


<div class="row">  
<?php
  $records = get_records('sources');
  include '../includes/partials/records_table.php';
?>
</div>


<?php
include '../includes/partials/bottom.php';
?>