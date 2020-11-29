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
    <div style="margin-top:-1em">(user: <u>test@test.com</u>, pass: <u>test</u> — entered by default)</div>
    <form action="<?=url('login.php')?>" method="post">
      <h3>Username(email): <input name="username" type="text" value="test@test.com"></h3>
      <h3>Password: <input name="password" type="password" value="test"></h3>
      <input type="submit" value="Login">
    </form>
  </body>
</html>
