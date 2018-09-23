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
  if (($_GET['last'] > 0) && ($_GET['last'] < 10100) && (ctype_digit($_GET['last']))) {
    $sql = "SELECT * FROM room_" . $room . " ORDER BY datetime DESC LIMIT " . $_GET['last'];
  } else {
    $sql = "SELECT * FROM room_" . $room . " ORDER BY datetime DESC LIMIT 1";
  }
} else {
  if (isset($_GET['lastx'])) {
    if ($_GET['lastx'] == "day") {
      $datetimeto = date('Y-m-d H:i:s');
      $datetimefrom = date("Y-m-d H:i:s", strtotime("-24 hours"));
    }
    if ($_GET['lastx'] == "month") {
      $datetimeto = date('Y-m-d H:i:s');
      $datetimefrom = date("Y-m-d H:i:s", strtotime("-1 month"));
      $average = "hour";
    }
    if ($_GET['lastx'] == "6months") {
      $datetimeto = date('Y-m-d H:i:s');
      $datetimefrom = date("Y-m-d H:i:s", strtotime("-6 months"));
      $average = "day";
    }
    if ($_GET['lastx'] == "year") {
      $datetimeto = date('Y-m-d H:i:s');
      $datetimefrom = date("Y-m-d H:i:s", strtotime("-1 year"));
      $average = "day";
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
  if ($average == "hour" || $average == "day") {
    $outputaverage = array();
    foreach ($output as $datetime => $temperature) {
      if ($average == "day") {
        $date = explode(" ", $datetime)[0];
        $outputaverage[$date][] = $temperature;
      }
      if ($average == "hour") {
        $date = explode(":", $datetime)[0];
        $outputaverage[$date . ":00"][] = $temperature;
      }
    }
    foreach ($outputaverage as $date => &$temperatures) {
      $temperatures = array_sum($temperatures)/count($temperatures);
      $temperatures = round($temperatures, 2);
    }
    $output = json_encode($outputaverage);
  } else {
    $output = json_encode($output);
  }
  echo $output;
} else {
  echo "ERROR: " . mysqli_error($link);
}

?>
