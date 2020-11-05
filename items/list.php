<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
require_once('../DBconfig.php');

$query = "SELECT itemid, item_name, catid FROM items";
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
  $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <form action="<?=$url?>/items/manage.php" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse;">
        <tr>
          <th>ID</th>
          <th>Item</th>
          <th>Catid</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($items??[] as $item): extract($item); ?>
        <tr>
          <th><?=$itemid?></th>
          <td><?=$item_name?></td>
          <td><?=$catid?></td>
          <th><input type="radio" name="itemid" value="u-<?=$itemid?>"></th>
          <th><input type="radio" name="itemid" value="d-<?=$itemid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit/Delete">
    </form>
    <ul>
      <li><a href="<?=$url?>/items/add.php"><b>Add item</b></a></li>
    </ul>
  </body>
</html>
