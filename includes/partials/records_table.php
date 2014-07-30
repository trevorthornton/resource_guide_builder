<?php
if (empty($records)) {
  echo "No records found :(";
}
else {
?>
<table class="records-table">
  <thead>
    <tr>
      <?php
        foreach (current($records) as $key => $value) {
          echo '<th class="' . $key . '-column">' . $key . '</th>';
        }
      ?>
      <?php if (isset($admin)) {
        echo '<th class="actions-column">Actions</th>';
      }
      ?>
    </tr>
  </thead>

  <tbody>
    <?php
    foreach ($records as $r) {
      echo '<tr>';
      foreach ($r as $key => $value) {
        echo '<td class="' . $key . '-column">' . $value . '</td>';
      }
      
      $edit_path = "/admin/edit_supplemental.php?type=$type&id=" . $r['id'];

      echo '<td class="actions-column"><a href ="' . $edit_path  . '">Edit</a></td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>

<?php
}
?>