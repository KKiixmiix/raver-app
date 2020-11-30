<?php
require_once '../_common.php';
login();

### REQ-2: three-table join
$number_attendees = $_GET["number_attendees"];
$query = "SELECT theme, hostuserid, datetime_start
  FROM events
  WHERE eventid IN (SELECT eventid FROM event_attendees GROUP BY eventid  HAVING COUNT(*) >= $number_attendees)";

# Events found
$events = sql($query);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver</title>
    <meta charset="utf-8">
    <style>
      th[emoticon]{font-family:'Apple Color Emoji'}
    </style>
  </head>
  <body>
    <?php main(); ?>
    <h2>Events</h2>
    <!-- BEGIN events/list-template.php (common for events/list.php and events/index.php) -->
    <p>More than <?=$number_attendees?> people will attend these events:</p>
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr>
          <th>Theme</th>
          <th>Host/th>
          <th>Start Date/Time</th>
        </tr>
<?php foreach ($events as $currentEvent): extract($currentEvent); ?>
        <tr>
          <td><?=$theme?></td>
          <td><?=$hostuserid?></th>
          <td><?=$datetime_start?></td>
        </tr>
<?php endforeach; ?>
      </table>

  </body>
</html>
