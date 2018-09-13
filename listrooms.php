<?php
include("config.php");

if ($_GET['key'] == $getkey) {
} else {
  exit();
}

$sql = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE'";
$output = array();
if($sql_result = mysqli_query($link, $sql)) {
  while ($sql_row = $sql_result->fetch_assoc()) {
    $tablename = $sql_row['TABLE_NAME'];
    if (substr($tablename, 0, 5) == "room_") {
      $output[] = explode("room_", $tablename)[1];
    }
  }
  $output = json_encode($output);
  echo $output;
} else {
  echo "ERROR: " . mysqli_error($link);
}

?>
