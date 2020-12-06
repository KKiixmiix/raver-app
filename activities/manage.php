<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $actid] = getTypeAndId(sanitize('actid'), $entity = 'activity');

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'activities', 'actid', $actid);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT act_name FROM activities WHERE actid=?';
  extract(manage($entity, $query, 'i', $actid));
}

$action = 'update';
require_once 'add.php';
