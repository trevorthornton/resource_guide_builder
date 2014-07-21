<?php
if (empty($records)) {
  echo "No records found :(";
}
else {
?>
<table>
  <thead>
    <tr>
      <?php
      var_dump($records);

        foreach (current($records) as $key => $value) {
          echo '<th>' . $key . '</th>';
        }
      ?>
      <?php if (isset($admin)) {
        echo '<th>Actions</th>';
      }
      ?>
    </tr>
  </thead>

  <tbody>
    <?php
    foreach ($records as $r) {
      echo '<tr>';
      foreach ($r as $key => $value) {
        echo '<td>' . $value . '</td>';
      }
      echo '<td><a href ="' . $edit_path  . "?id=" . $r['id'] . '">Edit</a></td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>

<?php
}
?>