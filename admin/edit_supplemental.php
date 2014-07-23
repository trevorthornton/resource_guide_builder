<?php
include '../includes/common.php';
$admin = TRUE;
$action = 'edit';

if ($_GET['type'] && $_GET['id']):

  $type = $_GET['type'];
  $id = $_GET['id'];

  switch($type) {
  case 'subject':
    $page_title = 'Edit Subject';
    $table = 'subjects';
  case 'source':
    $page_title = 'Edit Source';
    $table = 'sources';
  case 'resource_type':
    $page_title = 'Edit Resource Type';
    $table = 'resource_types';
  }

  $record = get_record_by_id($table, $id);
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