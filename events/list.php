<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
require_once('../DBconfig.php');

$query = "SELECT eventid, hostuserid, eventNo, theme, datetime_start, datetime_end, venueid FROM events";  //
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
  $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <h2>Event</h2>
    <form action="<?=$url?>/events/manage.php" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse;">
        <tr>
          <th>ID</th>
          <th>Event</th>
          <th>Theme</th>
          <th>Start Date/Time</th>
          <th>End Date/Time</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($events??[] as $event): extract($event); ?>
        <tr>
          <th><?=$eventid?></th>
          <th><?=$eventNo?></th>
          <td><?=$theme?></td>
          <td><?=$datetime_start?></td>
          <td><?=$datetime_end?></td>
          <th><input type="radio" name="eventid" value="u-<?=$eventid?>"></th>
          <th><input type="radio" name="eventid" value="d-<?=$eventid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit/Delete">
    </form>
    <ul>
      <li><a href="<?=$url?>/events/add.php"><b>Add event</b></a></li>
    </ul>
  </body>
</html>
