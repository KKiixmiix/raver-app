<?php
require_once '../_common.php';
login();

# Get required parameters, quit if they are missing or emtpy:
quit_unless($act_name = sanitize('act_name'), 'No activity name was passed to create it.');

insert('activity', 'activities', 'act_name', 's', $act_name);
