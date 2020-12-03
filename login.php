<?php
require_once '_common.php';
home();

# Get required parameters, quit if they are missing or emtpy:
quit_unless($username = sanitize('username'), 'Username is required.');
quit_unless($password = sanitize('password'), 'Password is required.');

# Prepare data for query:
$password = md5($password); # hash the password
$query = 'SELECT userid FROM users WHERE email=? AND password=? LIMIT 1';

# Attempt to check credentials:
quit_unless($result = head(sql($query, 'ss', $username, $password)), 'No user found for the passed credentials.');

# Log in:
home($_SESSION['userid'] = $result['userid'] ?? 0);
