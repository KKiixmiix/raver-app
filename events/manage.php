<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $eventid] = getTypeAndId(sanitize('eventid'), $entity = 'event', ['u', 'd', 'a']);

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'events', 'eventid', $eventid);
}

# Perform INSERT to add logged-in user as an attendee, exit with corresponding message:
if ($type == 'a') {
  insert('event attendee', 'event_attendees', 'eventid,userid', 'ii', $eventid, $loggedIn);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT theme, datetime_start, datetime_end, venueid FROM events WHERE eventid=?';
  extract(manage($entity, $query, 'i', $eventid));
}

# Get a list of all venues for list of venues:
$venues = sql('SELECT venueid vid, name FROM venues ORDER BY venueid');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver App</title>
    <meta charset="utf-8">
    <style>
      table th{text-align:right;vertical-align:top}
      table td{min-width:20em}
      table td select{width:100%}
      table td input{width:calc(100% - 8px)}
    </style>
  </head>
  <body>
    <?php main(); ?>
    <h2>Edit Event (ID <?=$eventid?>):</h2>
    <form action="<?=url('events/update.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr><th>Theme:</th>
            <td><input type="text" name="theme" value="<?=$theme?>"></td></tr>
        <tr><th>Start Date/Time:</th>
            <td><input type="text" name="datetime_start" value="<?=$datetime_start?>"></td></tr>
        <tr><th>End Date/Time:</th>
            <td><input type="text" name="datetime_end" value="<?=$datetime_end?>"></td></tr>
        <tr><th>Location:</th>
            <td>
              <select name="venueid">
<?php foreach ($venues as $venue): extract($venue); ?>
                <option value="<?=$vid?>"<?=selected($venueid==$vid)?>><?=$name?></option>
<?php endforeach; ?>
              </select>
            </td></tr>
      </table>
      <input type="hidden" name="eventid" value="<?=$eventid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
