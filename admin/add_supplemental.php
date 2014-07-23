<?php
include '../includes/common.php';
$admin = TRUE;
$action = 'add';

if ($_GET['type']):

  $type = $_GET['type'];

  switch($type) {
  case 'subject':
    $page_title = 'Edit Subject';
    $table = 'subjects';
    break;
  case 'source':
    $page_title = 'Edit Source';
    $table = 'sources';
    break;
  case 'resource_type':
    $page_title = 'Edit Resource Type';
    $table = 'resource_types';
    break;
  }

  $head_title = head_title();
  
  include '../includes/partials/top.php';

  ?>

  <?php include '../includes/partials/page_head.php'; ?>


  <div class="row">
    <?php include '../includes/partials/generic_record_form.php'; ?>
  </div>


<?php else: ?>

<?php include '../includes/partials/top.php'; ?>

<div class="row">
  <h1>Cannot edit - no type/ID provided</h1>
</div>

<?php
endif;
include '../includes/partials/bottom.php';
?>