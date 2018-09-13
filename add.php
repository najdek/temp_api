<?php
include("config.php");

$room = $_GET['room'];
$temp = $_GET['temp'];
if ($_GET['key'] == $addkey) {
} else {
  exit();
}
if (!isset($room)) {
exit();
}
if (!isset($temp)) {
exit();
}
if (ctype_alnum($room)) {
} else {
exit();
}
if (ctype_alnum(str_replace('.', '', $temp))) {
} else {
exit();
}
$datetime = date('Y-m-d H:i:s');
$sql = "INSERT INTO room_" . $room . " (datetime,temperature) VALUES ('" . $datetime . "','" . $temp . "')";

//echo $sql;

if(mysqli_query($link, $sql)) {
  echo "ADDED: " . $room . "_" . $datetime . "_" . $temp;
} else {
  echo "ERROR: " . $room . "_" . $datetime . "_" . $temp . "_" . mysqli_error($link);
}


?>
