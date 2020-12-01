<?php
require_once '../_common.php';
login();
$venues = sql('SELECT venueID, name, address, contact FROM venues');
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
      <h3>Theme: <input type="text" name="theme" placeholder="RAVE!"></h3>
      <h3>Host: <input type="text" name="hostuserid" value="<?=$loggedIn?>" readonly></h3>
      <h3>Start Date/Time "2020-02-20 02:20:02": <input type="text" name="datetime_start" placeholder="2020-02-20 02:20:02"></h3>
      <h3>End Date/Time "2020-02-20 02:20:02": <input type="text" name="datetime_end" placeholder="2020-02-20 02:20:03"></h3>
      <!--<h3>Venue:  <input type="text" name="venueid"></h3>-->
      <h3>Choose Venue:</h3>

      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr>
          <th>Venue Name</th>
          <th>Address</th>
          <th>Contact</th>
          <th>Choose Venue</th>
        </tr>
        <?php foreach ($venues as $venue): extract($venue); ?>
        <tr>
          <td><?=$name?></td>
          <td><?=$address?></td>
          <td><?=$contact?></td>
          <th><input type="radio" name="venueid" value="<?=$venueID?>"></th>
        </tr>
        <?php endforeach; ?>
        </table>
      <input type="submit" value="Submit">
      <button formaction="<?=url('venues/add.php')?>">Add new venue</button>
    </form>
  </body>
</html>
