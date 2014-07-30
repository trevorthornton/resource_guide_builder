<?php
include '../includes/common.php';
$admin = TRUE;
$action = 'add';

if ($_GET['type']):

  $type = $_GET['type'];

  switch($type) {
  case 'subject':
    $page_title = 'Add Subject';
    $table = 'subjects';
    break;
  case 'source':
    $page_title = 'Add Source';
    $table = 'sources';
    break;
  case 'resource_type':
    $page_title = 'Add Resource Type';
    $table = 'resource_types';
    break;
  }

  $head_title = head_title();
  
  include '../includes/partials/top.php';
  
  include '../includes/partials/page_head.php';

  if (isset ($_POST['add'])) {
    $attributes = $_POST['record'];
    $attributes = check_slug($attributes);
    $record = $attributes;
    $label = $type == 'source' ? $attributes['title'] : $attributes['label'];

    if (verify_unique($table,$attributes)) {
      if (insert_record($table, $attributes)) {
        echo '<div class="row alert-box success">';
        echo "$type <strong>$label</strong> successfully created!";
        echo '</div>';
      }
    }
    else {
      echo '<div class="row alert-box error">';
      echo "$type <strong>$label</strong> already exists";
      echo '</div>';
      echo '<div class="row">';
      include '../includes/partials/generic_record_form.php';
      echo '</div>';
    }
    
  } else {
    echo '<div class="row">';
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