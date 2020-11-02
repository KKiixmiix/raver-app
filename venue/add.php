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
    <h2>Event location:</h2>
    <form action="<?=$url?>/venue/insert.php" method="post">
      <h3>Name:  <input type="text" name="name"></h3>
      <h3>Address: <input type="text" name="address"></h3>
      <h3>Contact: <input type="text" name="contact"></h3>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
