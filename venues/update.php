<?php
require_once '../_common.php';
login();

# Get venue id, quit if none was given:
quit_unless($venueid = sanitize('venueid'), 'No venue ID was passed for processing.');
# Get the rest of the passed values:
$name    = sanitize('name');
$address = sanitize('address');
$contact = sanitize('contact');

# UPDATE
$query = 'UPDATE venues SET name=?, address=?, contact=? WHERE venueid=?';
update('venue', $query, 'sssi', $venueid, $name, $address, $contact, $venueid);
