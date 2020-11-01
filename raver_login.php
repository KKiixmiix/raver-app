<?php
require_once '_common.php';
home();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Welcome to Raver!</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h1>Welcome to Raver!</h1>
    <h2>Where your party will get rave reviews!</h2>
    <h3>Please login below:</h3>
    <form action="<?=$url?>/login.php" method="post">
      <h3>Username: <input name="username" type="text"></h3>
      <h3>Password: <input name="password" type="password"></h3>
      <input type="submit" value="Login">
    </form>
  </body>
</html>
