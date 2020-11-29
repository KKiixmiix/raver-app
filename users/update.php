<?php
require_once '../_common.php';
login();

# Get user id, quit if none was given:
quit_unless($userid = sanitize('userid'), 'No user ID was passed for processing.');
# Get the rest of the passed values:
$last_name  = sanitize('last_name');
$first_name = sanitize('first_name');
$email      = sanitize('email');
$phone      = sanitize('phone')     ?: null;
$password   = sanitize('password')  ?: null;
$invitedby  = sanitize('invitedby') ?: null;

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
