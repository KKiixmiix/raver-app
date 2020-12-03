<?php
require_once __DIR__.'/../_common.php';
global $loggedIn, $debug;

$server = $debug ? ($checkDB ? strtolower(explode(' via ', db()->host_info, 2)[0]) : 'MySQL server not connected') : '';
$server = $server ? " • $server" : '';

$who = $loggedIn ? "User #$loggedIn" : 'No user';

$md5 = md5_file(__DIR__.'/../styles.css');

$links = ['HOME' => ''] + ($loggedIn ? [
  'Users'      => 'users/list.php',
  'Events'     => 'events/list.php',
  'Venues'     => 'venues/list.php',
  'Songs'      => 'songs/list.php',
  'Activities' => 'activities/list.php',
  'Items'      => 'items/list.php',
  'LOG OUT'    => 'logout.php',
] : [
  'Log in'     => 'raver_login.php',
  'Sign up'    => 'users/add_newuser.php',
]);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?=url("styles.css?$md5")?>">
  </head>
  <body>
    <menu>
<?php foreach ($links as $text => $link): ?>
      <menuitem><a href="<?=url($link)?>"><?=$text?></a></menuitem>
<?php endforeach; ?>
      <div style="float:right"><?=$who?> is logged in<?=$server?></div>
    </menu>
