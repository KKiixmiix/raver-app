<?php
require_once '../_common.php';
login();

### REQ-2: three-table join
$query = <<<SQL
SELECT e.eventid, hostuserid, eventNo, theme, datetime_start, datetime_end, IF(datetime_end<NOW(),1,0) ended,
       getNumUsers(e.eventid) attendees, v.name, u.first_name, u.last_name, a.userid
  FROM      events          e
       JOIN venues          v USING (venueid)
       JOIN users           u ON (u.userid = hostuserid)
  LEFT JOIN event_attendees a ON (a.eventid = e.eventid AND a.userid=?)
 ORDER BY last_name, first_name, datetime_start DESC, eventNo DESC
SQL;

# Events found
$events = sql($query, 'i', $loggedIn);
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
<?php include_once 'list-template.php'; ?>
  </body>
</html>
