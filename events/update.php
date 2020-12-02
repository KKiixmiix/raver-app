<?php
require_once '../_common.php';
login();

# Get required parameters, quit if they are missing or emtpy:
quit_unless($eventid        = sanitize('eventid'),        'No event ID was passed for processing.');
quit_unless($hostuserid     = sanitize('hostuserid'),     'Event host is required.');
quit_unless($theme          = sanitize('theme'),          'Theme is required.');
quit_unless($venueid        = sanitize('venueid'),        'Venue is required.');
quit_unless($datetime_end   = sanitize('datetime_end'),   'Event start date/time is required.');
quit_unless($datetime_start = sanitize('datetime_start'), 'Event end date/time is required.');

# UPDATE
$query = 'UPDATE events SET hostuserid=?, theme=?, datetime_start=?, datetime_end=?, venueid=? WHERE eventid=?';
update('event', $query, 'isssii', $eventid, $hostuserid, $theme, $datetime_start, $datetime_end, $venueid, $eventid);
