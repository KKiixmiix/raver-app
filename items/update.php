<?php
require_once '../_common.php';
login();

# Get item id, quit if none was given:
quit_unless($itemid    = sanitize('itemid'),    'No item ID was passed for processing.');
quit_unless($item_name = sanitize('item_name'), 'Item Name is required.');
quit_unless($catid     = sanitize('catid'),     'Category is required.');

# UPDATE
$query = 'UPDATE items SET item_name=?, catid=? WHERE itemid=?';
update('item', $query, 'sii', $itemid, $item_name, $catid, $itemid);
