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
    <form action="<?=$url?>/activities/insert.php" method="post">
      <h3>Activity:  <input type="text" name="act_name"></h3>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
