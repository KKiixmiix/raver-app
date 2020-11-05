<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
require_once('../DBconfig.php');

$query = "SELECT actid, act_name FROM activities";
$stmt = mysqli_prepare($dbc, $query);

// mysqli_stmt_bind_param($stmt);

if(!mysqli_stmt_execute($stmt)) {
  echo "<h2>Oh no! Something went wrong!</h2>".mysqli_error($dbc);
  mysqli_close($dbc);
  exit;
}
$result = mysqli_stmt_get_result($stmt);
# Songs found
if (mysqli_num_rows($result)) {
  $activities = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
mysqli_close($dbc);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2>Activity</h2>
    <form action="<?=$url?>/activities/manage.php" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse;">
        <tr>
          <th>ID</th>
          <th>Activity</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($activities??[] as $activity): extract($activity); ?>
        <tr>
          <th><?=$actid?></th>
          <td><?=$act_name?></td>
          <th><input type="radio" name="actid" value="u-<?=$actid?>"></th>
          <th><input type="radio" name="actid" value="d-<?=$actid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit/Delete">
    </form>
    <ul>
      <li><a href="<?=$url?>/activities/add.php"><b>Add activity</b></a></li>
    </ul>
  </body>
</html>
