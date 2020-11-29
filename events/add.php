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
    <h2>Event:</h2>
    <form action="<?=url('events/insert.php')?>" method="post">
      <h3>Theme: <input type="text" name="theme" value="RAVE!"></h3>
      <h3>Host: <input type="text" name="hostuserid" value="<?=$loggedIn?>"></h3>
      <h3>Start Date/Time: <input type="text" name="datetime_start" value="2020-02-20 02:20:02"></h3>
      <h3>End Date/Time: <input type="text" name="datetime_end" value="2020-02-20 02:20:03"></h3>
      <h3>Venue: <input type="text" name="venueid" value="4"></h3>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
