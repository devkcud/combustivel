<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$con = new mysqli('localhost', 'root', '', 'Combustivel');

if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}
?>
