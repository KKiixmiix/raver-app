<?php
require_once '../_common.php';
login();

quit_unless(($eventid = sanitize('eventid')) xor ($eaid = sanitize('eaid')));

$actid = $minusers = $maxusers = '';

# Must be update or insert:
if ($actid = sanitize('actid')) {
  # Get the rest of the passed values:
  $minusers = sanitize('minusers');
  $maxusers = sanitize('maxusers');

  if ($id = sanitize('id')) {
    # Update existing event activity:
    $query = 'UPDATE event_activities SET eventid=?, actid=?, minusers=?, maxusers=? WHERE id=?';
    update('event activity', $query, 'iiiii', $id, $eventid, $actid, $minusers, $maxusers, $id);
  } else {
    # Insert new event activity:
    insert('event activity', 'event_activities', 'eventid,actid,minusers,maxusers', 'iiii', $eventid, $actid, $minusers, $maxusers);
  }
}

if ($eaid) {
  # Get type of action and entity id:
  [$type, $eaid] = getTypeAndId($eaid, $entity = 'event activity', ['u', 'd', 'a']);

  # Perform DELETE and exit with corresponding message:
  if ($type == 'd') {
    delete($entity, 'event_activities', 'id', $eaid);
  }

  # Perform INSERT to add logged-in user as an attendee, exit with corresponding message:
  if ($type == 'a') {
    insert('event activity attendee', 'event_act_users', 'eventactid,userid', 'ii', $eaid, $loggedIn);
  }

  # Prepare UPDATE
  if ($type == 'u') {
    $query = 'SELECT eventid, actid, minusers, maxusers FROM event_activities WHERE id=?';
    extract(manage($entity, $query, 'i', $eaid));
  }
}

# Determine if we're creating a new event activity or updating and existing one:
$isCreate = $eventid && !$eaid;

# Get a list of all events:
$events = sql('SELECT eventid eid, theme FROM events ORDER BY eventid');

# Get a list of all activities:
$activities = sql('SELECT actid aid, act_name FROM activities ORDER BY actid');
?>
    <h2><?=action($isCreate)?> Event Activity:</h2>
    <form action="<?=url('events/activity.php')?>" method="post">
      <table border=1 edit>
<?php if ($eaid): ?>
        <tr><th>ID:</th>
            <td><input type="text" name="id" value="<?=$eaid?>" readonly></td></tr>
<?php endif; ?>
        <tr><th>Event:</th>
            <td>
              <select name="eventid">
<?php foreach ($events as $event): extract($event); ?>
                <option value="<?=$eid?>"<?=selected($eventid==$eid)?>><?="$eid: $theme"?></option>
<?php endforeach; ?>
              </select>
            </td></tr>
        <tr><th>Activity:</th>
            <td>
              <select name="actid">
                <option value="" disabled<?=selected(!$actid)?>></option>
<?php foreach ($activities as $activity): extract($activity); ?>
                <option value="<?=$aid?>"<?=selected($actid==$aid)?>><?=$act_name?></option>
<?php endforeach; ?>
              </select>
            </td></tr>
        <tr><th>Min attendees:</th>
            <td><input type="text" name="minusers" value="<?=$minusers?>"></td></tr>
        <tr><th>Max attendees:</th>
            <td><input type="text" name="maxusers" value="<?=$maxusers?>"></td></tr>
      </table>
      <input type="submit" value="<?=submit($isCreate)?>">
    </form>
  </body>
</html>
