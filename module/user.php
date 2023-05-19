<?php

$id = $_SESSION['lms_logon'];

$sql = "SELECT user_major, learn_list FROM user_table WHERE user_id = '$id'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
$major = $row['user_major'];
if ($major = null) {
  $major = "미인증 학생";
} else {
  $major = $row['user_major'];
}


$learnlist = $row['learn_list'];


echo "<br>" . $major . "<br>";

$course = explode(",", $learnlist);

foreach($course as $list){
  echo  $list . "<br>";
}

?>