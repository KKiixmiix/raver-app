<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
require_once('../DBconfig.php');

$query = "SELECT userid, last_name, first_name, email, phone, password FROM users";
$stmt = mysqli_prepare($dbc, $query);

// mysqli_stmt_bind_param($stmt);

if(!mysqli_stmt_execute($stmt)) {
  echo "<h2>Oh no! Something went wrong!</h2>".mysqli_error($dbc);
  mysqli_close($dbc);
  exit;
}
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result)) {
  $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <h2>Item</h2>
    <form action="<?=$url?>/users/manage.php" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse;">
        <tr>
          <th>ID</th>
          <th>Raver Patron</th>
          <th>Last Name</th>
          <th>Contact Email</th>
          <th>Contact Number</th>
          <th>Password</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($users??[] as $user): extract($user); ?>
        <tr>
          <th><?=$userid?></th>
          <td><?=$last_name?></td>
          <td><?=$first_name?></td>
          <td><?=$email?></td>
          <td><?=$phone?></td>
          <td><?=$password?></td>
          <th><input type="radio" name="userid" value="u-<?=$userid?>"></th>
          <th><input type="radio" name="userid" value="d-<?=$userid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit/Delete">
    </form>
    <ul>
      <li><a href="<?=$url?>/users/add.php"><b>Sign up!</b></a></li>
    </ul>
  </body>
</html>
