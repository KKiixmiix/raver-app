<?php

define('DB_USER', '');
define('DB_PASS', '');
define('DB_HOST', '');
define('DB_NAME', '');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)
  or exit('Could not connect to MySQL: '.mysqli_connect_error());

mysqli_set_charset($dbc, 'utf8');
