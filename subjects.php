<?php
$page_title = 'EPCOT History | Subjects';
include 'includes/partials/top.php';
?>

<?php
include 'includes/models.php';

if (isset ($_GET['id'])):



// Show
  $subject = get_record_by_id('subjects', $_GET['id']);
?>

<div class="row">
  <h1><?php echo $subject['label']; ?></h1>
</div>

<div class="row">
  <h1><?php echo $subject['wikipedia_uri']; ?></h1>
</div>


<?php
else:



// List
$subjects = get_records('subjects',['order' => 'label ASC']);
foreach ($subjects as $s) {
?>

<div class="row">
  <div class="small-6 columns"><?php echo $s['label']; ?></div>
  <div class="small-6 columns"><?php echo $s['wikipedia_uri']; ?></div>
</div>

<?php

}

endif;


include 'includes/partials/bottom.php';

?>