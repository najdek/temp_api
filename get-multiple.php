<?php
include("config.php");
header("Access-Control-Allow-Origin: *");

$rooms = $_GET['rooms'];
if ($_GET['key'] == $getkey) {
} else {
  exit();
}
if (!isset($rooms)) {
exit();
}
if (ctype_alnum(str_replace(",", "", $rooms))) {
} else {
exit();
}

$rooms = explode(",", $rooms);

$output = array();
foreach ($rooms as $room) {
  $sql = "SELECT * FROM room_" . $room . " ORDER BY datetime DESC LIMIT 1";
  if($sql_result = mysqli_query($link, $sql)) {
    while ($sql_row = $sql_result->fetch_assoc()) {
      $output[$room]["date"] = [$sql_row['datetime']];
      $output[$room]["temp"] = $sql_row['temperature'];
      if(strtotime($sql_row['datetime']) < strtotime('-5 minutes')) {
        $output[$room]["temp"] = '-';
      }
    }
  }
}

echo json_encode($output);
?>


