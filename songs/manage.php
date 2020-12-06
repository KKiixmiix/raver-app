<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $musicid] = getTypeAndId(sanitize('musicid'), $entity = 'song');

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'songs', 'musicid', $musicid);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT title, artist, minutes, userid FROM songs WHERE musicid=?';
  extract(manage($entity, $query, 'i', $musicid));
}

$action = 'update';
require_once 'add.php';
