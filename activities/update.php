<?php
require_once '../_common.php';
login();

# Get activity id, quit if none was given:
quit_unless($actid    = sanitize('actid'),    'No activity ID was passed for processing.');
quit_unless($act_name = sanitize('act_name'), 'Activity Name is required.');

# UPDATE
$query = 'UPDATE activities SET act_name=? WHERE actid=?';
update('activity', $query, 'si', $actid, $act_name, $actid);
