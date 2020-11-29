<?php
require_once '../_common.php';
login();

# Get music id, quit if none was given:
quit_unless($musicid = sanitize('musicid'), 'No music ID was passed for processing.');
# Get the rest of the passed values:
$title  = sanitize('title');
$artist = sanitize('artist');

# UPDATE
$query = 'UPDATE songs SET title=?, artist=? WHERE musicid=?';
update('song', $query, 'ssi', $musicid, $title, $artist, $musicid);
