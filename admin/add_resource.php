<?php
include '../includes/common.php';
$page_title = $project_name . ' | Admin | Add Resource';
include '../includes/partials/top.php';
include '../includes/partials/admin_nav.php';

if (isset ($_POST['add'])):
  $attributes = $_POST['resource'];
  
  
else:

  $resource_types = get_records('resource_types');
  $publishers = get_records('publishers');
?>


<div class="row">
  <h1>Add a resource</h1>
</div>

<div class="row">
  
  <form action="add_resource.php" method="post">
      
      <div class="row">
        <div class="small-6 columns">
          <label>Resource type</label>
          <select name="resource_type_id">
            <?php
            foreach ($resource_types as $r) {
              echo '<option value="' . $r['id'] . '">' . $r['name'] . "</option>\n";
            }
            ?>

          </select>
        </div>
      </div>

      <div class="row">
        <div class="small-12 columns">
          <label>Title</label>
          <input type="text" placeholder="" name="resource[title]" />
        </div>
      </div>

      <div class="row">
        <div class="small-12 columns">
          <label>URL</label>
          <input type="text" placeholder="" name="resource[url]" />
        </div>
      </div>


      <div class="row">
        <div class="small-12 columns">
          <label>Description</label>
          <textarea placeholder="" name="resource[description]"></textarea>
        </div>
      </div>


      <div class="row">
        <div class="small-6 columns">
          <label>Publisher</label>
          <select name="resource[publisher_id]">
            <option></option>
            <option value="husker">Husker</option>
            <option value="starbuck">Starbuck</option>
            <option value="hotdog">Hot Dog</option>
            <option value="apollo">Apollo</option>
          </select>
        </div>
        
        <div class="small-6 columns">
          <label>Add publisher</label>
          <input type="text" placeholder="Name of publisher to add..." name="resource[publisher_new]" />
        </div>

      </div>


      <div class="row">
        <div class="small-6 columns">
          <label>Creator</label>
          <select name="resource[creator_id]" multiple="multiple" size="3">
            <option></option>
            <option value="husker">Husker</option>
            <option value="starbuck">Starbuck</option>
            <option value="hotdog">Hot Dog</option>
            <option value="apollo">Apollo</option>
          </select>
        </div>
        
        <div class="small-6 columns">
          <label>Add creator</label>
          <input type="text" placeholder="Name of creator to add..." name="resource[creator_new]" />
        </div>

      </div>


      <div class="row">
        <div class="small-4 columns">
          <label>ISBN</label>
          <input type="text" placeholder="For books" name="resource[isbn]" />
        </div>
        <div class="small-4 columns end">
          <label>ISSN</label>
          <input type="text" placeholder="For serials" name="resource[issn]" />
        </div>
      </div>


      <div class="row">
        <div class="small-12 columns">
          <label>Subjects</label>
          <select multiple size="8" name="resource[subject_id]">
            <option value="husker">Husker</option>
            <option value="starbuck">Starbuck</option>
            <option value="hotdog">Hot Dog</option>
            <option value="apollo">Apollo</option>
          </select>
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