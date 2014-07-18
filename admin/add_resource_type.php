<?php

$page_title = 'EPCOT History | Admin | Add Resource Type';
include '../includes/partials/top.php';

if (isset ($_POST['add'])):
  var_dump($_POST['resource_type']);




else:
?>

    <div class="row">
      <div class="small-12 columns">
        <h1>Add a resource type</h1>
      </div>
    </div>
    
    <div class="row">
      
      <form action="add_resource_type.php" method="post">


          <div class="row">
            <div class="small-12 columns">
              <label>Name</label>
              <input type="text" placeholder="" name="resource_type[name]" />
            </div>
          </div>



          <div class="row">
            <div class="small-12 columns">
              <label>Description</label>
              <textarea placeholder="" name="resource_type[description]"></textarea>
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

endif;

include '../includes/partials/bottom.php';

?>