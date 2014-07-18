<?php
  
  if (isset($_GET) {
    var_dump($_GET);
  }

  $subjects = get_records('publishers');
?>

<div class="row">
  <h1>Add a resource</h1>
</div>

<div class="row">
  
  <a href="#" data-dropdown="drop2">Has Content Dropdown</a>
  
  <div id="drop2" data-dropdown-content class="f-dropdown content">
    <ul>
      <?php
      foreach ($subjects as $s) {
        echo '<li><a href="/resources?subject=' . $s['name'] . "</li>\n";
      }
      ?>
    </ul>
  </div>

</div>