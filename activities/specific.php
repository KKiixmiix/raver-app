<?php
require_once '../_common.php';
login();
$activity_name = $_GET["activity_name"];

$query = "SELECT actid, act_name FROM activities WHERE act_name LIKE '%$activity_name%'";
$activities = sql($query);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2>Activitiesy</h2>
    <form action="<?=url('activities/specific.php')?>" method="get">
      <label for="activity_name">Search activities: &nbsp;&nbsp;</label>
      <input type="text" name="activity_name" id="activity_name" autofocus>
      <input type="submit" id="submit" value="Search"><br><br>
    </form>
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
