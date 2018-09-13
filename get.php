<?php
include("config.php");

$room = $_GET['room'];
if ($_GET['key'] == $getkey) {
} else {
  exit();
}
if (!isset($room)) {
exit();
}
if (ctype_alnum($room)) {
} else {
exit();
}

if (isset($_GET['last'])) {
  if (($_GET['last'] > 0) && ($_GET['last'] < 100) && (ctype_digit($_GET['last']))) {
    $sql = "SELECT * FROM room_" . $room . " ORDER BY datetime DESC LIMIT " . $_GET['last'];
  } else {
    $sql = "SELECT * FROM room_" . $room . " ORDER BY datetime DESC LIMIT 1";
  }
} else {
  $datetimefrom = $_GET['from'];  //format "2018.09.08-18:26:00"
  $datetimeto = $_GET['to'];
  if (ctype_alnum(str_replace(array(".", "-", ":"), '', $datetimefrom))) {
  } else {
    exit();
  }
  if (ctype_alnum(str_replace(array(".", "-", ":"), '', $datetimeto))) {
  } else {
    exit();
  }
  $datefrom = explode("-", $datetimefrom)[0];
  $datefrom = str_replace(".", "-", $datefrom);
  $datefrom = strtotime($datefrom);
  $dateto = explode("-", $datetimeto)[0];
  $dateto = str_replace(".", "-", $dateto);
  $dateto = strtotime($dateto);
  if ($datefrom > $dateto) {
    exit();
  }
  $datediff = $dateto - $datefrom;
  $datediff = $datediff / (60*60*24);
  if ($datediff > 31) {
    exit();
  }
  $sql = "SELECT * FROM room_" . $room . " WHERE datetime between '" . $datetimefrom . "' and '" . $datetimeto . "'";
}

$output = array();
if($sql_result = mysqli_query($link, $sql)) {
  while ($sql_row = $sql_result->fetch_assoc()) {
    $output[$sql_row['datetime']] = $sql_row['temperature'];
  }
  $output = json_encode($output);
  echo $output;

} else {
  echo "ERROR: " . mysqli_error($link);
}

?>
