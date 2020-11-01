<?php
require_once '_common.php';
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
    <h2>Add your music:</h2>
    <form action="<?=$url?>/insert_music.php" method="post">
      <h3>Title:  <input type="text" name="title"></h3>
      <h3>Artist: <input type="text" name="artist"></h3>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
