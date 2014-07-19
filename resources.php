<?php
$page_title = 'EPCOT History | Resources';
include 'includes/partials/top.php';
?>

<?php
include 'includes/models.php';
  
if (isset($_GET)) {
  var_dump($_GET);

  // generate options from $_GET

}

$resources = get_resources();
var_dump($resources);

?>

<div class="row">
  <h1>Resources</h1>
</div>

<div class="row">
<?php
  include 'includes/partials/subject_browse_select.php';
?>


</div>

<div class="row">
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Publisher</th>
        <th>Author</th>
        <th>Subject</th>
      </tr>
    </thead>

    <tbody>
      <?php
      foreach ($resources as $r) {
      ?>
      <tr>
      <td><?php echo $r['title']; ?></td>
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
      }
      ?>
    </tbody>
  </table>
</div>

<?php
include 'includes/partials/bottom.php';
?>