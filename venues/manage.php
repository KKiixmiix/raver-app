<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $venueid] = getTypeAndId(sanitize('venueid'), $entity = 'venue');

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'venues', 'venueid', $venueid);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT name, address, contact FROM venues WHERE venueid=?';
  extract(manage($entity, $query, 'i', $venueid));
}

$action = 'update';
require_once 'add.php';
