<?php
include 'includes/common.php';
// Page headers, etc.
$page_title = $project_name . ' | Resources';
include 'includes/partials/top.php';
  
if (isset($_GET)) {
  // var_dump($_GET);
  // generate options from $_GET
}

$resources = get_resources();

?>




<div class="row">
  <h1>Resources</h1>
</div>

<div class="row">
  <div>
  <?php include 'includes/partials/subject_browse_select.php'; ?>
  </div>
</div>


<div class="row">
  
  <?php include 'includes/partials/resources_table.php'; ?>

</div>


<?php // var_dump($resources); ?>


<?php
include 'includes/partials/bottom.php';
?>