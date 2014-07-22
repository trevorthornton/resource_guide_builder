<?php if (!isset($resource)) {
  $resource = [];
}
?>
<form action="<?php echo $action; ?>_resource.php" method="post">
      
      <input type="hidden" name="resource[id]" value="<?php echo $resource['id']; ?>"/>
      
      <div class="row">
        <div class="small-6 columns">
          <label>Resource type</label>
          <select name="resource_type_id">
            <?php
            $resource_types = get_records('resource_types');
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
          <input type="text" placeholder="" name="resource[title]" value="<?php echo $resource['title']; ?>"/>
        </div>
      </div>

      <div class="row">
        <div class="small-12 columns">
          <label>URL</label>
          <input type="text" placeholder="" name="resource[url]" value="<?php echo $resource['url']; ?>"/>
        </div>
      </div>


      <div class="row">
        <div class="small-12 columns">
          <label>Creator</label>
          <input type="text" placeholder="" name="resource[creator]" value="<?php echo $resource['creator']; ?>"/>
        </div>
      </div>

      <div class="row">
        <div class="small-12 columns">
          <label>Description</label>
          <textarea placeholder="" name="resource[description]" rows="4"><?php echo $resource['description']; ?></textarea>
        </div>
      </div>

      <div class="row">
        <div class="small-12 columns">
          <label>Publication info</label>
          <textarea placeholder="" name="resource[description]" rows="4"><?php echo $resource['publication_info']; ?></textarea>
        </div>
      </div>

      <div class="row">
        <div class="small-8 columns end">
          <label>Source</label>
          <select name="resource[source_id]">
          <option></option>
          <?php
          $sources = get_records('sources');
          foreach ($sources as $source) {
            $selected = ($resource['source_id'] == $source['id']) ? ' selected="selected"' : '';
            echo '<option value="' . $source['id'] . '"' . $selected . '>' . $source['name'] . '</option>';
          }
          ?>
          </select>
        </div>
        

      </div>



      <div class="row">
        <div class="small-12 columns">
        <?php $subjects = get_records('subjects', ['order' => 'label ASC']); ?>
          <label>Subjects</label>
          <div class="scrollable">
            <ul class="small-block-grid-4">
            <?php
            foreach ($subjects as $s) {
              $checked = '';
              if (isset($subject_ids) && in_array($s['id'], $subject_ids)) {
                $checked = ' checked="checked"';
              }
              $input = '<input type="checkbox" name="resource[subject_id][' . $s['id'] . ']"' . $checked . '> ' . $s['label'] . "</input>\n";
              echo '<li>' . $input . '</li>';
            }
            ?>
            </ul>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="small-12 columns">
          <input name="<?php echo $action; ?>" type="submit" value="Create" class="button" />
        </div>
      </div>


    </form>