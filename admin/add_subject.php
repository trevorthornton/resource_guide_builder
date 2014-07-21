<?php
include '../includes/common.php';
$page_title = 'EPCOT History | Admin | Add Subject';
include '../includes/partials/top.php';
include '../includes/partials/admin_nav.php';

if (isset ($_POST['add'])) {
  $attributes = $_POST['subject'];
  $attributes = check_slug($attributes);
  
  // var_dump($attributes);
  
  if (insert_record('subjects', $attributes)) {
  ?>
    <div class="alert-box success">
      The subject <strong><?php echo $attributes['label']; ?> was successfully created.
    </div>
  <?php
  }

} else {

?>


<div class="row">
  <h1>Add a subject</h1>
</div>

<div class="row">
  
  <form action="add_subject.php" method="post">
      
      <div class="row">
        <div class="small-12 columns">
          <label>Label</label>
          <input type="text" placeholder="" name="subject[label]" />
        </div>
      </div>

      <div class="row">
        <div class="small-12 columns">
          <label>Wikiedia URI</label>
          <input type="text" placeholder="" name="subject[wikipedia_uri]" />
        </div>
      </div>

      <div class="row">
        <div class="small-12 columns">
          <input name="add" type="submit" value="Create" class="button" />
        </div>
      </div>


    </form>

</div>

<?php

}

include '../includes/partials/bottom.php';

?>