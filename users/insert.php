<?php
require_once '../_common.php';
login($loggedIn);

# Get required parameters, quit if they are missing or emtpy:
quit_unless($password   = sanitize('password'),   'Password is required.');
quit_unless($first_name = sanitize('first_name'), 'First name is required.');
quit_unless($last_name  = sanitize('last_name'),  'Last name is required.');
quit_unless($email      = sanitize('email'),      'Email is required.');
# Get the rest of the passed values:
$phone     = sanitize('phone')     ?: null;
$invitedby = sanitize('invitedby') ?: null;
$password  = md5($password);

$columns = 'invitedby,  last_name,  first_name,  email,  phone,  password';
$values = [$invitedby, $last_name, $first_name, $email, $phone, $password];

insert('user', 'users', $columns, 'isssss', ...$values);
