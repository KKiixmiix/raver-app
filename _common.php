<?php

error_reporting(E_ERROR | E_PARSE);

session_start();

$loggedIn = $_SESSION['userid'] ?? 0;

$url = '';

$mysqli = null;

$mainPrinted = false;

define_env_vars();

function define_env_vars() {
  global $url;
  $abs = dirname(__FILE__) . '/';
  $vars = $path = '';
  foreach (['.env', '../', '../'] as $part) {
    if (file_exists($abs . ($path = $part.$path))) {
      $vars = file_get_contents($abs . $path);
      break;
    }
  }
  $vars or exit('Config file not found.');
  foreach (explode("\n", $vars) as $var) {
    if (2 == count($var = explode('=', $var, 2))) {
      [$name, $value] = [trim($var[0]), trim($var[1])];
      $name && ('#' !== substr($name, 0, 1)) && !defined($name) && define($name, $value);
    }
  }
  if (defined('URL_DIR')) {
    $url = rtrim(URL_DIR, '/');
  }
}

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
  $div = '<div style="float:right">%s</div>';
  if ($loggedIn) {
    printf($div, "User #$loggedIn is logged in");
  } else {
    printf($div, 'No user is logged in');
  }
}

function main() {
  global $url, $loggedIn, $mainPrinted;
  if ($mainPrinted) {
    return;
  }
  user();
  $links = ['HOME' => ''] + ($loggedIn ? [
    'Users'      => 'users/list.php',
    'Events'     => 'events/list.php',
    'Venues'     => 'venues/list.php',
    'Songs'      => 'songs/list.php',
    'Activities' => 'activities/list.php',
    'Items'      => 'items/list.php',
    'LOG OUT'    => 'logout.php',
  ] : []);
  foreach ($links as $text => $link) {
    $a[] = "<a href=\"$url/$link\"><b>$text</b></a>";
  }
  echo join('&nbsp; • &nbsp;', $a);
  $mainPrinted = true;
}

function url(string $path) {
  global $url;
  $path = ltrim($path, '/');
  return "$url/$path";
}

function quit_if($condition, ?string $message = null) {
  if ($condition) {
    quit($message ?: 'You have reached this page in error');
  }
}

function quit_unless($condition, ?string $message = null) {
  quit_if(!$condition, $message);
}

function redirect_unless($condition, string $path = '') {
  if (!$condition) {
    redirect($path);
  }
}

function sanitize($param) {
  return filter_var($_POST[$param] ?? $_GET[$param] ?? '', FILTER_SANITIZE_STRING);
}

function getTypeAndId(string $id, string $entity, array $types = ['u', 'd']): array {
  # Get entity id, quit if none was given:
  quit_unless($id, "No $entity ID was passed for processing.");
  # Break up the entity id value into type and actual numeric entity id:
  [$type, $id] = explode('-', $id, 2) + [null, null];
  # Check that the type values are in expected range, quit otherwise:
  quit_unless(in_array($type, $types) && is_numeric($id) && $id, "Bad parameters passed for $entity ID.");
  # Return cleaned-up values:
  return [$type, intval($id)];
}

function fullName(?string ...$parts) {
  return join(', ', array_filter($parts));
}

function quit(?string $message = null) {
  main();
  $message = $message ?? 'Oh no! Something went wrong!';
  $error = [];
  if ($db = db(false)) {
    $error[] = $db->error ?? '';
  }
  exit("<h3>$message</h3>" . join('<br>', $error));
}

function delete(string $entity, string $table, string $xid, int $id) {
  # Deletion SQL:
  $query = "DELETE FROM $table WHERE $xid=?";
  # Attempt to perform "delete" and see if exactly one entity was deleted:
  quit_if(1 === sql($query, 'i', $id), "The $entity with ID=$id was successfully deleted.");
  # Otherwise inform of an error:
  quit("Error trying to delete the $entity with ID=$id.");
}

function insert(string $entity, string $table, string $columns, string $types, ...$params) {
  # Check number of parameters:
  quit_unless($cnt = count($params), 'Insert statement has to have at least one parameter, but 0 given.');
  # Make a proper values part for a prepared statement:
  $questions = '?' . str_repeat(',?', count($params) - 1);
  # Insertion SQL:
  $query = "INSERT INTO $table ($columns) VALUES ($questions)";
  # Attempt to perform "insert" and see if exactly one entity was inserted:
  quit_if(1 === sql($query, $types, ...$params), "A new $entity was successfully inserted.");
  # Otherwise inform of an error:
  quit("Error trying to insert a new $entity.");
}

function update(string $entity, string $query, string $types = null, int $id, ...$params) {
  # Attempt to perform "update" and see if exactly one entity was updated:
  quit_if(1 === sql($query, $types, ...$params), "The $entity with ID=$id was successfully updated.");
  # Otherwise inform of an error:
  quit("Error trying to update the $entity with ID=$id.");
}

function manage(string $entity, string $query, string $types = null, ...$params) {
  # Get associated data for editing:
  quit_unless($data = reset(sql($query, $types, ...$params)), "The $entity with passed parameters not found.");
  # Return found data for extraction:
  return $data;
}

function sql(string $query, ?string $types = null, ...$params) {
  $db = db();
  if (!($stmt = $db->prepare($query))) {
    quit('Error in sql(): statement is null.');
  }
  if ($types && $params) {
    $elems = strlen($types);
    if ($elems != count($params)) {
      quit('Error in sql(): number of types differs from number of passed params.');
    }
    if ($elems != substr_count($query, '?')) {
      quit('Error in sql(): number of types differs from number of parameters (?) in statement to prepare.');
    }
    $stmt->bind_param($types, ...$params);
  }
  if (!$stmt->execute()) {
    quit('Error in sql(): statement execution failed.');
  }
  if (!($result = $stmt->get_result()) && $db->errno) {
    quit('Error in sql(): failed to get a result of statement.');
  }
  $num = $stmt->affected_rows;
  $stmt->close();
  if ($result instanceof mysqli_result) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
    return $rows;
  }
  return $num;
}

function db($newIfNull = true, $charset = 'utf8') {
  global $mysqli;
  if (is_null($mysqli) && $newIfNull) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_error) {
      quit("MySQL Connect Error ($mysqli->connect_errno): $mysqli->connect_error.");
    }
    $mysqli->set_charset($charset);
  }
  return $mysqli;
}

function disabled($condition) {
  return $condition ? '' : ' disabled';
}

function selected($condition) {
  return $condition ? ' selected' : '';
}
