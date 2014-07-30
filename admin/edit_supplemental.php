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
  
  include '../includes/partials/page_head.php';

  if (isset($_POST['update'])) {
    $attributes = $_POST['record'];
    $attributes = check_slug($attributes);
    $record = $attributes;
    $label = $type == 'source' ? $attributes['title'] : $attributes['label'];

    if (update_record($table, $id, $attributes)) {
      echo '<div class="row">';
        echo '<div class="alert-box success">';
        echo "$type <strong>$label</strong> successfully updated!";
        echo '</div>';
      $records = get_records($table);
      include '../includes/partials/records_table.php';
      echo '</div>';
    }
    
  } else {
    echo '<div class="row">';
    $record = get_record_by_id($table, $id);
    include '../includes/partials/generic_record_form.php';
    echo '</div>';
  }

else:

  include '../includes/partials/top.php';

  echo '<div class="row">';
  echo '<h1>Cannot edit - no type/ID provided</h1>';
  echo '</div>';

endif;

include '../includes/partials/bottom.php';

?>