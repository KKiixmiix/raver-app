<?php

session_start();

$loggedIn = $_SESSION['userid'] ?? 0;

$url = '';

function redirect($path, $xor = false) {
  global $loggedIn, $url;
  if ($loggedIn xor $xor) {
    header("Location: $url/$path");
  }
}

function home($xor = false) {
  redirect('', $xor);
}

function login($xor = true) {
  redirect('raver_login.php', $xor);
}

function user() {
  global $loggedIn;
  $div = '<div style="float:right"';
  if ($loggedIn) {
    echo "$div>User #$loggedIn is logged in</div>";
  } else {
    echo "$div>No user is logged in</div>";
  }
}

function main() {
  global $url, $loggedIn;
  user();
  $links = $loggedIn ? [
    'HOME'       => '',
    'LOG OUT'    => 'logout.php',
    'List Music' => 'list_music.php',
    'Add Music'  => 'add_music.php',
  ] : ['HOME' => ''];
  foreach ($links as $text => $link) {
    $a[] = "<a href=\"$url/$link\"><b>$text</b></a>";
  }
  echo join(' &nbsp; • &nbsp; ', $a);
}

function sanitize($param) {
  return filter_var($_POST[$param] ?? '', FILTER_SANITIZE_STRING);
}
