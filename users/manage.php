<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $userid] = getTypeAndId(sanitize('userid'), $entity = 'user');

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'users', 'userid', $userid);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT invitedby, last_name, first_name, email, phone, password FROM users WHERE userid=?';
  extract(manage($entity, $query, 'i', $userid));
}

$action = 'update';
require_once 'add.php';
