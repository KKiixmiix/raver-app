<?php
require_once '../_common.php';
login();

# Get required parameters, quit if they are missing or emtpy:
quit_unless($musicid = sanitize('musicid'), 'No music ID was passed for processing.');
quit_unless($title   = sanitize('title'),   'Title is required.');
quit_unless($artist  = sanitize('artist'),  'Artist is required.');
quit_unless($userid  = sanitize('userid'),  'Added By is required.');
quit_unless($minutes = sanitize('minutes'), 'Playtime is required.');

# UPDATE
$query = 'UPDATE songs SET title=?, artist=?, userid=?, minutes=? WHERE musicid=?';
update('song', $query, 'ssiii', $musicid, $title, $artist, $userid, $minutes, $musicid);
