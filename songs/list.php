<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
require_once('../DBconfig.php');
$userid = $loggedIn;

### REQ-4: aggregate function
$query = "SELECT SUM(minutes) FROM songs WHERE userid = ?";
$stmt = mysqli_prepare($dbc, $query);
mysqli_stmt_bind_param($stmt, "i", $userid);
if(!mysqli_stmt_execute($stmt)) {
  echo "<h2>Oh no! Something went wrong!</h2>".mysqli_error($dbc);
  mysqli_close($dbc);
  exit;
}
$result = mysqli_stmt_get_result($stmt);
$total = mysqli_fetch_all($result)[0][0];

$query = "SELECT musicid, title, artist, minutes, userid FROM songs WHERE userid = ?";
$stmt = mysqli_prepare($dbc, $query);
mysqli_stmt_bind_param($stmt, "i", $userid);
if(!mysqli_stmt_execute($stmt)) {
  echo "<h2>Oh no! Something went wrong!</h2>".mysqli_error($dbc);
  mysqli_close($dbc);
  exit;
}
$result = mysqli_stmt_get_result($stmt);
# Songs found
if (mysqli_num_rows($result)) {
  $songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <h2>List my music</h2>
    <form action="<?=$url?>/songs/manage.php" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse;">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Artist</th>
          <th>Playtime</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($songs??[] as $song): extract($song); ?>
        <tr>
          <th><?=$musicid?></th>
          <td><?=$title  ?></td>
          <td><?=$artist ?></td>
          <td><?=$minutes?></td>
          <th><input type="radio" name="musicid" value="u-<?=$musicid?>"></th>
          <th><input type="radio" name="musicid" value="d-<?=$musicid?>"></th>
        </tr>
<?php endforeach; ?>
        <tfoot>
          <tr>
            <th colspan="3" align="right">Total Playtime (in minutes)</th>
            <th><?=$total?></th>
            <th colspan="2"></th>
          </tr>
        </tfoot>
      </table>
      <input type="submit" value="Edit/Delete">
    </form>
    <ul>
      <li><a href="<?=$url?>/songs/add.php"><b>Add song</b></a></li>
    </ul>
  </body>
</html>
