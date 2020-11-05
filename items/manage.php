<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['itemid'] ?? '')) {
  $itemid = sanitize('itemid');
  [$type, $itemid] = explode('-', $itemid) + [null, null];
  if (!(in_array($type, ['u', 'd']) && is_numeric($itemid))) {
    main();
    exit('<h2>Something is not right</h2>');
  }

  require_once('../DBconfig.php');

  # Perform DELETE and exit
  if ($type == 'd') {
    main();
    $query = "DELETE FROM items WHERE itemid = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "i", $itemid);
    if (!mysqli_stmt_execute($stmt)) {
      $echo = '<h2>We were unable to delete the item at this time.</h2>';
    } else {
      $echo = '<h2>The item was successfully deleted.</h2>';
    }
    mysqli_close($dbc);
    exit($echo);
  }

  # Prepare UPDATE
  $query = "SELECT item_name, catid FROM items WHERE itemid=?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "i", $itemid);
  if (!mysqli_stmt_execute($stmt)) {
    mysqli_close($dbc);
    main();
    exit('<h2>Oh no! Something went wrong!</h2>' . mysqli_error($dbc));
  }
  $result = mysqli_stmt_get_result($stmt);
  $items = mysqli_fetch_assoc($result);
  extract($items);
  mysqli_close($dbc);
}
else {
  main();
  exit('<h2>You have reached this page in error</h2>');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver App</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2>Edit your item (ID <?=$itemid?>):</h2>
    <form action="<?=$url?>/items/update.php" method="post">
      <h3>Item:  <input type="text" name="item_name" value="<?=$item_name?>"></h3>
      <h3>Category: <input type="text" name="catid" value="<?=$catid?>"></h3>
      <input type="hidden" name="itemid" value="<?=$itemid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
