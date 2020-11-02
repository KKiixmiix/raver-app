<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
require_once('../DBconfig.php');

$query = "SELECT venueid, name, address, contact FROM venues";
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
  $venues = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <h2>Venue Location</h2>
    <form action="<?=$url?>/venue/manage.php" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse;">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Address</th>
          <th>Contact</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($venues??[] as $venue): extract($venue); ?>
        <tr>
          <th><?=$venueid?></th>
          <td><?=$name   ?></td>
          <td><?=$address?></td>
          <td><?=$contact?></td>
          <th><input type="radio" name="venueid" value="u-<?=$venueid?>"></th>
          <th><input type="radio" name="venueid" value="d-<?=$venueid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit/Delete">
    </form>
    <ul>
      <li><a href="/venue/add.php"><b>Add venue</b></a></li>
    </ul>
  </body>
</html>
