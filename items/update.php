<?php
require_once '../_common.php';
login();

# Get item id, quit if none was given:
quit_unless($itemid = sanitize('itemid'), 'No item ID was passed for processing.');
# Get the rest of the passed values:
$catid     = sanitize('catid');
$item_name = sanitize('item_name');

# UPDATE
$query = 'UPDATE items SET item_name=?, catid=? WHERE itemid=?';
update('item', $query, 'sii', $itemid, $item_name, $catid, $itemid);
