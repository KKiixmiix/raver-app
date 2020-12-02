<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $itemid] = getTypeAndId(sanitize('itemid'), $entity = 'item');

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'items', 'itemid', $itemid);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT item_name, catid FROM items WHERE itemid=?';
  extract(manage($entity, $query, 'i', $itemid));
}

$action = 'update';
require_once 'add.php';
