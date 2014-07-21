<table>
  <thead>
    <tr>
      <th>Title</th>
      <th>Source</th>
      <th>Author</th>
      <th>Subject</th>
      <?php if (isset($admin)) {
        echo '<th>Actions</th>';
      }
      ?>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($resources as $r) { ?>
    <tr>
    
      <td>
      <?php
      if (isset($r['url'])) {
        echo '<a href="' . $r['url'] . '">' . $r['title'] . '</a>';
      }
      else {
        echo $r['title'];
      }
      ?>
      </td>
      
      <td></td>
      <td></td>
      
      <td>
      <?php
        if (isset($r['subjects'])) {
          foreach ($r['subjects'] as $s) {
            echo $s['label'];
            echo ($s != end($r['subjects'])) ? ', ' : '';
          }
        }
      ?>
      </td>

      <?php
        if (isset($admin)) {
          echo '<td><a href="/admin/edit_resource?id=' . $r['id'] . '">Edit</a></td>';
        }
        echo '</tr>';
      }
      ?>
  </tbody>
</table>