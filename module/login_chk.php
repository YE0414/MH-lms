<?php

include_once('../db/db_conn.php');
include_once('../db/config.php');

  $id = $_POST['user_id'] ?? '';
  $pw = $_POST['user_password'] ?? '';


  $sql = "SELECT * FROM user_table WHERE user_id = '$id'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  
  if(isset($_SESSION['lms_logon'])){

    echo "
    <script>
      alert('이미 로그인 되어있습니다.'); 
      location.replace('../index.php');
    </script>";
  }

  if($row['user_id'] == $id){
    if(password_verify($pw, $row['user_password'])){
      $_SESSION['lms_logon'] = $row['user_id'];
      echo('
      <script>
        alert("로그인 되었습니다.");
        location.href = "../index.php";
      </script>
      ');
  } if(!$id || !$pw) {
    echo "<script>alert('아이디 또는 비밀번호를 입력해주세요.'); location.replace('./login.php');</script>";
    exit;
  }
  } if(!$row['user_id']) {
    echo "<script>alert('일치하는 아이디가 없습니다.'); location.replace('./login.php');</script>";
    exit;
  } else {
    // 비밀번호 확인
    //password_verify(입력값, DB값) : 입력값과 DB값이 일치하면 true, 아니면 false (복호화 기능도 포함)
    if (!password_verify($pw, $row['user_password'])) { // 로그인 실패
      echo "<script>alert('비밀번호가 일치하지 않습니다.'); location.replace('./login.php');</script>";
      exit;
    }
  }

?>