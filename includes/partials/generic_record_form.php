<?php
  $attributes = valid_attributes($table);
  if (!isset($record)) {
    $record = [];
  }
?>

<form action="<?php echo $action; ?>_supplemental.php?type=<?php echo $type; ?><?php echo ($action == 'edit') ? "&id=$id" : ''; ?>" method="post">

  <?php if (isset($attributes['label'])): ?>
    <div class="row">
      <div class="small-12 columns">
        <label>Label</label>
        <input type="text" placeholder="" name="record[label]" value="<?php echo $record['label']; ?>" />
      </div>
    </div>
  <?php endif; ?>


  <?php if (isset($attributes['title'])): ?>
    <div class="row">
      <div class="small-12 columns">
        <label>Title</label>
        <input type="text" placeholder="" name="record[title]" value="<?php echo $record['title']; ?>" />
      </div>
    </div>
  <?php endif; ?>


  <?php if (isset($attributes['wikipedia_uri'])): ?>
    <div class="row">
      <div class="small-12 columns">
        <label>Wikipedia URI</label>
        <input type="text" placeholder="" name="record[wikipedia_uri]" value="<?php echo $record['wikipedia_uri']; ?>" />
      </div>
    </div>
  <?php endif; ?>


  <?php if (isset($attributes['url'])): ?>
    <div class="row">
      <div class="small-12 columns">
        <label>URL</label>
        <input type="text" placeholder="" name="record[url]" value="<?php echo $record['url']; ?>" />
      </div>
    </div>
  <?php endif; ?>


  <?php if (isset($attributes['description'])): ?>
    <div class="row">
      <div class="small-12 columns">
        <label>Description</label>
        <textarea placeholder="" name="record[description]" rows="4"><?php echo $record['description']; ?></textarea>
      </div>
    </div>
  <?php endif; ?>


  <?php if (isset($attributes['slug'])): ?>
    <div class="row">
      <div class="small-12 columns">
        <label>Slug</label>
        <input type="text" placeholder="" name="record[slug]" value="<?php echo $record['slug']; ?>" />
      </div>
    </div>
  <?php endif; ?>


  <div class="row">
    <div class="small-12 columns">
      <input name="<?php echo ($action == 'edit') ? 'update' : 'add'; ?>" type="submit" value="<?php echo ($action == 'edit') ? 'update' : 'add'; ?>" class="button" />
    </div>
  </div>


</form>