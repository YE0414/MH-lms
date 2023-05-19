<?php

include_once '../db/db_conn.php';
include_once '../db/config.php';

// 승인할 과목의 ID
$id = $_POST['apply_ID'];
$verify = $_POST['verify'];

// 승인
if(!$id == "" && !$verify == ""){
  $sql = "UPDATE learn_apply SET apply = 1 WHERE apply_id = '$id'";
  $result = mysqli_query($conn, $sql);
  
  // 다시 불러와서 아래 작업을 위해 변수에 저장
  $sql = "SELECT * FROM learn_apply WHERE apply_id = '$id'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  // 학생 테이블의 learn_list에 해당 과목 추가
  $user_insert = "UPDATE user_table
  SET learn_list = (
    SELECT GROUP_CONCAT(learn_title)
    FROM learn_apply
    WHERE user_table.user_id = learn_apply.user_id
  )";
  $result = mysqli_query($conn, $user_insert);
  $learn_title = $row['learn_title'];

  // 정원 한명 추가
  $sql = "UPDATE learn_table
  SET student_person = student_person + 1
  WHERE learn_title = '$learn_title'";
  $result = mysqli_query($conn, $sql);


echo('
<script>
  alert("승인되었습니다.");
  location.href = "./master_apply.php";
</script>
');



} else {
  echo('
  <script>
    alert("오류가 발생했습니다.");
    location.href = "./master_apply.php";
  </script>
  ');
}

?>
