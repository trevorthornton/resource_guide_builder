<?php
include '../includes/common.php';
$page_title = $project_name . ' | Admin | Add Resource';
$admin = TRUE;
$action = 'edit';

include '../includes/partials/top.php';


if (isset ($_POST['edit'])):
  
  $attributes = $_POST['resource'];
  $id = $attributes['id'];
  update_record('resources', $id, $attributes);

  $subject_ids = array_keys($attributes['subject_id']);
  $old_subject_ids = resource_subject_ids($id);
  


  echo '<br>';
  var_dump($subject_ids);
  echo '<br>';

  echo '<br>';
  var_dump($old_subject_ids);
  echo '<br>';



  foreach ($subject_ids as $sid) {
    if (!in_array($sid, $old_subject_ids)) {
      insert_record('resources_subjects', ['subject_id' => $sid, 'resource_id' => $id]);
    }
  }

  $delete_subject_ids = [];
  foreach ($old_subject_ids as $sid) {
    if (!in_array($sid, $subject_ids)) {
      $delete_subject_ids[] = $sid;
    }
  }

  echo '<br>';
  var_dump($delete_subject_ids);
  echo '<br>';


  if (!empty($delete_subject_ids)) {
    remove_resource_subjects($id, $delete_subject_ids, $connection=null);
  }
?>

<div class="row">
  <h1>Resource updated!</h1>
</div>

<div class="row">
<dl>
<?php
  foreach ($attributes as $key => $value) {
    echo "<dt>$key</dt>";
    echo "<dd>$value</dd>";
  }
?>
</dl>
</div>





<?php
elseif (isset($_GET['id'])):
  $resource = get_record_by_id('resources', $_GET['id']);
  $subject_ids = resource_subject_ids($_GET['id']);
?>

<div class="row">
  <h1>Edit resource</h1>
</div>


<div class="row">
  <?php include '../includes/partials/resource_form.php'; ?>
</div>


<?php else: ?>

<div class="row">
  <h1>Resource not found</h1>
</div>

<?php
endif;
include '../includes/partials/bottom.php';
?>