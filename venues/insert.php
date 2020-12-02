<?php
require_once '../_common.php';
login();

# Get required parameters, quit if they are missing or emtpy:
quit_unless($name = sanitize('name'), 'Venue name is required.');
# Get the rest of the passed values:
$address = sanitize('address');
$contact = sanitize('contact');

insert('venue', 'venues', 'name, address, contact', 'sss', $name, $address, $contact);
