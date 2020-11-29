<?php
require_once '../_common.php';
login();

# Activities found:
$activities = sql('SELECT actid, act_name FROM activities');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2>Activities</h2>
    <form action="<?=url('activities/manage.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr>
          <th>ID</th>
          <th>Activity</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($activities as $activity): extract($activity); ?>
        <tr>
          <th><?=$actid?></th>
          <td><?=$act_name?></td>
          <th><input type="radio" name="actid" value="u-<?=$actid?>"></th>
          <th><input type="radio" name="actid" value="d-<?=$actid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit / Delete">
      <button formaction="<?=url('activities/add.php')?>">Add new activity</button>
    </form>
  </body>
</html>
