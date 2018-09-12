<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$addkey = "ADDKEY";
$getkey = "GETKEY";
$servername = "localhost";
$username = "USERNAME";
$password = "PASSWORD";
$dbname = "DATABASENAME";

if (!isset($link)) {
  $link = mysqli_connect($servername, $username, $password, $dbname);
  if ($link === false) {
    echo "db error";
    echo mysqli_connect_error();
    exit();
  } else {
    //db connected
  }
}

?>