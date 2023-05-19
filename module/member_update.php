<?php

include_once('../db/db_conn.php');
include_once('../db/config.php');
  
$id = $_POST['user_id'];
$pass = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
$name = $_POST['user_name'];
$info = $_POST['user_info'];
$email  = $_POST['user_email'];
$phone = $_POST['user_phone'];
$sql = "UPDATE user_table SET user_password = '$pass', user_name ='$name', user_info = '$info', user_email = '$email', user_phone = '$phone' WHERE user_id='$id'";

mysqli_query($conn, $sql);  // $sql 에 저장된 명령 실행
  mysqli_close($conn);   //db종료
  
  echo "
    <script>
      alert('회원정보가 수정되었습니다.');
      location.href = './logout.php';
    </script>
  ";

?>