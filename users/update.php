<?php
require_once '../_common.php';
login();

# Get required parameters, quit if they are missing or emtpy:
quit_unless($userid     = sanitize('userid'),     'No user ID was passed for processing.');
quit_unless($first_name = sanitize('first_name'), 'First name is required.');
quit_unless($last_name  = sanitize('last_name'),  'Last name is required.');
quit_unless($email      = sanitize('email'),      'Email is required.');
# Get the rest of the passed values:
$phone     = sanitize('phone')     ?: null;
$invitedby = sanitize('invitedby') ?: null;
$password  = sanitize('password')  ?: null;

# UPDATE
$params = [$invitedby, $last_name, $first_name, $email, $phone];
[$qp, $types] = ['', 'issssi'];
# Update password if non-empty string was passed:
if ($password) {
  $params[] = md5($password);
  [$qp, $types] = [', password=?', 'isssssi'];
}
# Add user id to params:
$params[] = $userid;
# Modify the query string to include or omit the password:
$query = sprintf('UPDATE users SET invitedby=?, last_name=?, first_name=?, email=?, phone=?%s WHERE userid=?', $qp);
# Perform the update:
update('user', $query, $types, $userid, ...$params);
