<?php
require_once '../_common.php';
home();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2>Raver Patron:</h2>
    <form action="<?=$url?>/users/insert_newuser.php" method="post">
      <h3>Raver Patron:  <input type="text" name="first_name"></h3>
      <h3>Last Name:  <input type="text" name="last_name"></h3>
      <h3>Contact email: <input type="text" name="email"></h3>
      <h3>Contact number: <input type="text" name="phone"></h3>
      <h3>Password: <input type="password" name="password"></h3>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
