<?php

include_once '../db/config.php';
include_once '../db/db_conn.php';

$ID = $_POST['user_id'];
$major = $_POST['major'];
$major = (int)$major; // 전공밸류를 정수로 변환

$verify = $_POST['verify']; // 승인버튼을 눌렀는지 거절버튼을 눌렀는지 확인

if($verify == 'no'){ // 거절버튼을 눌렀을 경우 (삭제 우선적으로)

  // 먼저 외래키 무시하는 옵션 설정
  mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");

  // learn_apply에서 해당 아이디를 삭제
  $sql_child = "DELETE FROM learn_apply WHERE user_id = '$ID'";
  $result_child = mysqli_query($conn, $sql_child);

  // user_table에서 해당 아이디를 삭제
  $sql_parent = "DELETE FROM user_table WHERE user_id = '$ID'";
  $result_parent = mysqli_query($conn, $sql_parent);

  // 외래키 옵션 다시 설정
  mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");

  if($result_parent){ // 삭제 성공시
    echo('
    <script>
      alert("거절되었습니다.");
      location.href = "./master.php";
    </script>
    ');
    exit;
  } else { // 삭제 실패시
    echo('
    <script>
      alert("오류가 발생했습니다.");
      location.href = "./master.php";
    </script>
    ');
    exit;
  }
} else {

// 학과를 선택하지 않았을 경우나 전공선택, 학생, 교직원 탭으로 선택할 경우
if($major == 0){ 
  echo '
  <script>
    alert("학과를 선택해주세요.");
    location.href = "./master.php";
  </script>
  ';
  exit;
}

// 전공밸류가 5이상이면 교직원 아니면 학생
if($major < 5){ 
  $user_type = 1;
} else {
  $user_type = 2;
}

if($major == 1){
  $major = '컴퓨터공학과';
} 
if($major == 2){
  $major = '전자공학과';
} 
if($major == 3){
  $major = '정보통신공학과';
} 
if($major == 4){
  $major = '소프트웨어학과';
}
if($major == 5){
  $major = '컴퓨터공학과';
} 
if($major == 6){
  $major = '전자공학과';
} 
if($major == 7){
  $major = '정보통신공학과';
} 
if($major == 8){
  $major = '소프트웨어학과';
}


if($verify == 'ok'){ // 승인버튼을 눌렀을 경우
  // user_type을 1로 바꾸고, user_major를 선택한 학과로 바꾸고, user_type을 학생이면 1, 교직원이면 2로 바꿈
  $sql = "UPDATE user_table SET user_type = 1, user_major = '$major', user_type = $user_type WHERE user_id = '$ID'";
  $result = mysqli_query($conn, $sql);
  echo('
  <script>
    alert("승인되었습니다.");
    location.href = "./master.php";
  </script>
  ');
}
}
?>