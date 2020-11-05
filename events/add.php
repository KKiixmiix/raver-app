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
    <form action="insert.php" method="post"> <!--?=$url?>/events/ "get"-->
      <h3>Theme:  <input type="text" name="theme"></h3>
      <h3>Host:  <input type="text" name="hostuserid"></h3>
      <h3>Event Number:  <input type="text" name="eventNo"></h3>
      <h3>Date Start Time:  <input type="text" name="datetime_start"></h3>
      <h3>Date End Time:  <input type="text" name="datetime_end"></h3>
      <h3>Venue:  <input type="text" name="venueid"></h3>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
