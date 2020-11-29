<?php
require_once '../_common.php';
login();

# Get event id, quit if none was given:
quit_unless($eventid = sanitize('eventid'), 'No event ID was passed for processing.');
# Get the rest of the passed values:
$theme          = sanitize('theme');
$venueid        = sanitize('venueid');
$datetime_end   = sanitize('datetime_end')   ?: null;
$datetime_start = sanitize('datetime_start') ?: null;

# UPDATE
$query = 'UPDATE events SET theme=?, datetime_start=?, datetime_end=?, venueid=? WHERE eventid=?';
update('event', $query, 'sssii', $eventid, $theme, $datetime_start, $datetime_end, $venueid, $eventid);
