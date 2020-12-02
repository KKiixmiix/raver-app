<?php
require_once '../_common.php';
login();

# Get required parameters, quit if they are missing or emtpy:
quit_unless($title   = sanitize('title'),   'Title is required.');
quit_unless($artist  = sanitize('artist'),  'Artsit is required.');
quit_unless($minutes = sanitize('minutes'), 'Playtime is required.');
quit_unless($userid  = sanitize('userid'),  'Added By is required.');

insert('song', 'songs', 'title, artist, minutes, userid', 'ssii', $title, $artist, $minutes, $userid);
