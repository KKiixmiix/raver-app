<?php

foreach (['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'] as $var) {
  defined($var) or exit('Database Configuration not loaded.');
}

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)
  or exit('Could not connect to MySQL: '.mysqli_connect_error());

mysqli_set_charset($dbc, 'utf8');
