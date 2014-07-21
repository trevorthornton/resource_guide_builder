<?php
  $subjects = get_records('subjects');
?>

<a href="#" data-dropdown="drop2"><i class="fa fa-th"></i> Browse subjects</a>
  
<div id="drop2" data-dropdown-content class="f-dropdown content">
  <ul>
    <?php
    foreach ($subjects as $s) {
      $li = '<li><a href="/resources.php?subject=' . $s['slug'] . '">' . $s['label'] . "</a></li>\n";
      echo $li;
    }
    ?>
  </ul>
</div>