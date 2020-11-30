<?php
require_once '../_common.php';
login();

require_once('../DBconfig.php');
$query = "SELECT catid, name FROM item_categories";
$stmt = mysqli_prepare($dbc, $query);
if (!mysqli_stmt_execute($stmt)) {
  mysqli_close($dbc);
  main();
  exit('<h2>Oh no! Something went wrong!</h2>' . mysqli_error($dbc));
}
$result = mysqli_stmt_get_result($stmt);
$items = mysqli_fetch_assoc($result);
extract($items);
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
    <h2>Item:</h2>
    <form action="<?=url('items/insert.php')?>" method="post">
      <h3>Name:  <input type="text" name="item_name"></h3>
      <h3>Category: <input type="text" name="catid"></h3>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
