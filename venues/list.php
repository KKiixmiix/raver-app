<?php
require_once '../_common.php';
login();

# Venues found:
$venues = sql('SELECT venueid, name, address, contact FROM venues');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2>Venues</h2>
    <form action="<?=url('venues/manage.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr>
          <th>Venue Name</th>
          <th>Address</th>
          <th>Contact</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($venues as $venue): extract($venue); ?>
        <tr>
          <td><?=$name?></td>
          <td><?=$address?></td>
          <td><?=$contact?></td>
          <th><input type="radio" name="venueid" value="u-<?=$venueid?>"></th>
          <th><input type="radio" name="venueid" value="d-<?=$venueid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit / Delete">
      <button formaction="<?=url('venues/add.php')?>">Add new venue</button>
    </form>
  </body>
</html>
