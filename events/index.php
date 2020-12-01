<?php
require_once '../_common.php';
login();

# Get event id, redirect to the list if no event id was given:
redirect_unless($eventid = sanitize('id'), 'events/list.php');

sql("CALL update_activities");
### REQ-2: three-table join
# Prepare main query for this event:

$query = <<<SQL
SELECT e.eventid, hostuserid, eventNo, theme, datetime_start, datetime_end,
       getNumUsers(e.eventid) attendees, v.name, u.first_name, u.last_name, a.userid
  FROM      events          e
       JOIN venues          v USING (venueid)
       JOIN users           u ON (u.userid = e.hostuserid)
  LEFT JOIN event_attendees a ON (a.eventid = e.eventid AND a.userid = ?)
 WHERE e.eventid = ?
 LIMIT 1
SQL;

# Extract data from the database for the query above:
$event = reset(sql($query, 'ii', $loggedIn, $eventid));
quit_unless($event, "Event #$eventid does not exist");
extract($event);

### REQ-1: two-table join
# Find associated event attendees:
$query = <<<SQL
SELECT u.userid, first_name, last_name
  FROM event_attendees ea
  JOIN           users  u USING (userid)
 WHERE eventid = ?
 ORDER BY u.userid
SQL;
$event_attendees = sql($query, 'i', $eventid);

### REQ-1: two-table join
# Find associated event activities:
$query = <<<SQL
SELECT ea.id eaid, act_name, signedUp(ea.id) signedup, minusers, maxusers
  FROM event_activities ea
  JOIN       activities  a USING (actid)
 WHERE eventid = ?
 ORDER BY ea.id
SQL;
$event_activities = sql($query, 'i', $eventid);

### REQ-2: three-table join
# Find associated event activity attendees:
$query = <<<SQL
SELECT ea.id, u.userid, first_name, last_name
  FROM event_activities ea
  JOIN event_act_users  eau ON (eau.eventactid = ea.id)
  JOIN           users    u USING (userid)
 WHERE eventid = ?
 ORDER BY ea.id, u.userid
SQL;
$event_activity_attendees = sql($query, 'i', $eventid);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver</title>
    <meta charset="utf-8">
    <style>
      td>ol{margin:0 auto}
      th[emoticon]{font-family:'Apple Color Emoji'}
    </style>
  </head>
  <body>
    <?php main(); ?>
    <h2>Event ID: <?=$eventid?></h2>
<?php include_once 'list-template.php'; ?>

    <h2>Event Attendees</h2>
    <form action="<?=url('events/x.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse;">
        <tr>
          <th>User ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <!-- <th>Edit</th> -->
          <!-- <th>Delete</th> -->
        </tr>
<?php foreach ($event_attendees as $user): extract($user); ?>
        <tr>
          <th><?=$userid?></th>
          <td><?=$first_name?></td>
          <td><?=$last_name?></td>
          <!-- <th><input type="radio" name="id" value="u-<?=$userid?>"></th> -->
          <!-- <th><input type="radio" name="id" value="d-<?=$userid?>"></th> -->
        </tr>
<?php endforeach; ?>
      </table>
      <!-- <input type="submit" value="Edit / Delete"> -->
      <!-- <button formaction="<?=url('events/add.php')?>">Add new attendee</button> -->
    </form>

    <h2>Event Activities and their Attendees</h2>
    <form action="<?=url('events/x.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse;">
        <tr>
          <th>ID</th>
          <th>Activity</th>
          <th>Signed Up</th>
          <th>Min</th>
          <th>Max</th>
          <th>On?</th>
          <!-- <th>Edit</th> -->
          <!-- <th>Delete</th> -->
        </tr>
<?php foreach ($event_activities as $act): extract($act); ?>
        <tr>
          <th><?=$eaid?></th>
          <td><?=$act_name?></td>
          <th><?=$signedup?></th>
          <th><?=$minusers?></th>
          <th><?=$maxusers?></th>
          <th emoticon><?=$signedup>=$minusers ? '✅' : '❌️'?></th>
          <!-- <th><input type="radio" name="id" value="u-<?=$eaid?>"></th> -->
          <!-- <th><input type="radio" name="id" value="d-<?=$eaid?>"></th> -->
        </tr>
        <tr>
          <td colspan="6">
<?php if ($signedup): ?>
            <ol>
<?php foreach ($event_activity_attendees as $attendee): extract($attendee); ?>
<?php if ($id == $eaid): ?>
              <li>User [<?=$userid?>]: <?=$first_name?> <?=$last_name?></li>
<?php endif; ?>
<?php endforeach; ?>
            </ol>
<?php else: ?>
            <div style="margin-left:3.5ex">Nobody signed up yet for this activity.</div>
<?php endif; ?>
          </td>
        </tr>
<?php endforeach; ?>
      </table>
      <!-- <input type="submit" value="Edit / Delete"> -->
      <!-- <button formaction="<?=url('events/add.php')?>">Add new activity</button> -->
    </form>
  </body>
</html>
