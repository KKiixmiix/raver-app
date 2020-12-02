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
  $query = 'SELECT hostuserid, theme, datetime_start, datetime_end, venueid FROM events WHERE eventid=?';
  extract(manage($entity, $query, 'i', $eventid));
}

$action = 'update';
require_once 'add.php';
