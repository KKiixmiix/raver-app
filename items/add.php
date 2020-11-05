<?php
require_once '../_common.php';
login();
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
    <form action="<?=$url?>/items/insert.php" method="post">
      <h3>Name:  <input type="text" name="item_name"></h3>
      <h3>Category: <input type="text" name="catid"></h3>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
