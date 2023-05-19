<?php

// 데이터베이스와 세션 연결
include_once '../db/db_conn.php';
include_once '../db/config.php';

// 값을 받아오기
$user_num = $_POST['user_num'];
$user_name = $_POST['user_name'];
$learn_ID = $_POST['learn_num'];
$learn_name = $_POST['learn_title'];
$verify = $_POST['verify'];
$date = date("Y-m-d");

// 기존 값 불러오기
$sql = "SELECT * FROM learn_apply";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$usersql = "SELECT * FROM user_table WHERE user_num = '$user_num'";
$user_result = mysqli_query($conn, $usersql);
$user_row = mysqli_fetch_array($user_result);
$user_id = $user_row['user_id'];

// 정원 체크
$limit_sql = "SELECT * FROM learn_table WHERE learn_num = '$learn_ID'";
$limit_result = mysqli_query($conn, $limit_sql);
$limit_row = mysqli_fetch_array($limit_result);
$now_person = $limit_row['student_person'];
$limit = $limit_row['student_total'];

// 정원 초과시
if($now_person >= $limit){
  echo('
  <script>
    alert("정원이 초과되었습니다.");
    location.href = "./user_apply.php";
  </script>
  ');
  exit;
}

// 승인
  if ($verify == 'ok'){
    $stmt = mysqli_prepare($conn, "insert into learn_apply set user_id = ?, user_name = ?, learn_title = ?, apply_date = ?");
    mysqli_stmt_bind_param($stmt, "ssss", $user_id, $user_name, $learn_name, $date);
    $stmt->execute();
    
    // 승인결과 출력
    if ($stmt->affected_rows == 1) {
      echo('
      <script>
        alert("신청되었습니다.");
        location.href = "./user_apply.php";
      </script>
      ');
    } else {
      echo('
      <script>
        alert("오류가 발생했습니다.");
        location.href = "./user_apply.php";
      </script>
      ');
    }} else {
      echo('
      <script>
        alert("오류가 발생했습니다.");
        location.href = "./user_apply.php";
      </script>
      ');
    }
?>