<?php
require_once __DIR__.'/../_common.php';
global $loggedIn;

$server = strtolower(explode(' via ', db()->host_info, 2)[0]);
$who = $loggedIn ? "User #$loggedIn" : 'No user';

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
    <link rel="stylesheet" href="<?=url('styles.css?'.time())?>">
  </head>
  <body>
    <menu>
<?php foreach ($links as $text => $link): ?>
      <menuitem><a href="<?=url($link)?>"><?=$text?></a></menuitem>
<?php endforeach; ?>
      <div style="float:right"><?=$who?> is logged in • <?=$server?></div>
    </menu>
