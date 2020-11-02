<?php
require_once '_common.php';
#
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver Party App</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2>Raver! Where they will rave about your party!</h2>
    <h3>Links to queries:</h3>
    <ul>
<?php if ($loggedIn): ?>
      <li><a href="<?=$url?>/songs/add.php">Add a song!</a></li>
      <li><a href="<?=$url?>/songs/list.php">List my music</a></li>
<?php else: ?>
      <li><a href="<?=$url?>/raver_login.php">Welcome Login Page</a></li>
<?php endif; ?>
    </ul>
  </body>
</html>
