<?php
require_once '_common.php';
home();
?>
    <h1>Welcome to Raver!</h1>
    <h2>Where your party will get rave reviews!</h2>
    <h3>Please login below:</h3>
    <div style="margin-top:-1em">(user: <u>test@test.com</u>, pass: <u>test</u> — entered by default)</div>
    <br>
    <form action="<?=url('login.php')?>" method="post">
      <table border=1 edit>
        <tr><th><label for="u">Username (email):</label></th>
            <td><input id="u" type="email" name="username" maxlength="50" autocomplete="username" required value="test@test.com"></td></tr>
        <tr><th><label for="w">Password:</label></th>
            <td><input id="w" type="password" name="password" minlength="8" autocomplete="current-password" required value="test">
      </table>
      <input type="submit" value="Login">
    </form>
