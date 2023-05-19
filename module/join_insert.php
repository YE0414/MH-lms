<?php

include_once('../db/db_conn.php');
include_once('../db/config.php');

$id = $_POST['user_id'];
$id = mysqli_real_escape_string($conn, $id);
$name = $_POST['user_name'];
$name = mysqli_real_escape_string($conn, $name);
$info = $_POST['user_info'];
$info = mysqli_real_escape_string($conn, $info);
$pw = $_POST['user_password'];
$pw = mysqli_real_escape_string($conn, $pw);
$email = $_POST['user-email'];
$email = mysqli_real_escape_string($conn, $email);
$phone = $_POST['user-phone'];
$phone = mysqli_real_escape_string($conn, $email);

$name_base = $name;
$i = 1;
while(mysqli_num_rows($result) > 0) {
    $sql = "SELECT * FROM user_table WHERE user_name = '$name'";
    $result = mysqli_query($conn, $sql);
    $i++;
    $name = $name_base . $i;
}

$pw = password_hash($pw, PASSWORD_DEFAULT);
$stmt = mysqli_prepare($conn, "INSERT INTO user_table (user_id, user_name, user_password, user_info, user_email, user_phone) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
  // handle error, such as logging it or displaying an error message
  die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ssssss", $id, $name, $pw, $info, $email, $phone);
$stmt->execute();

if ($stmt->affected_rows == 1) {
  echo('
  <script>
    alert("회원가입이 완료되었습니다.");
    location.href = "./login.php";
  </script>
  ');
} else {
  echo('
  <script>
    alert("회원가입에 실패하였습니다.");
    location.href = "./join.php";
  </script>
  ');
}

?>