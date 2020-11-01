<?php
require_once '_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
require_once('DBconfig.php');
$userid = $loggedIn;

$query = "SELECT musicid, title, artist FROM songs WHERE userid = ?";
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
    <form action="<?=$url?>/manage_music.php" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse;">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Artist</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($songs??[] as $song): extract($song); ?>
        <tr>
          <th><?=$musicid?></th>
          <td><?=$title  ?></td>
          <td><?=$artist ?></td>
          <th><input type="radio" name="musicid" value="u-<?=$musicid?>"></th>
          <th><input type="radio" name="musicid" value="d-<?=$musicid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit/Delete">
    </form>
  </body>
</html>
