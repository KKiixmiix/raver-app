<?php
require_once '../_common.php';
login();

# Get required parameters, quit if they are missing or emtpy:
quit_unless($item_name = sanitize('item_name'), 'Item name is required.');
quit_unless($catid     = sanitize('catid'),     'Category is required.');

insert('item', 'items', 'item_name, catid', 'si', $item_name, $catid);
