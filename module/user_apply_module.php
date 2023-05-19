<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>명지대학교 lms</title>
    <!-- 파비콘 -->
    <link rel="icon" href="./img/pavicon.ico" type="image/x-icon" sizes="16x16">
    <!-- 베이스css(리셋 포함) -->
    <link rel="stylesheet" href="../css/base.css" type="text/css">
    <!-- 헤더푸터 -->
    <link rel="stylesheet" href="../css/common.css" type="text/css" />
    <!-- 모듈 CSS -->
    <link rel="stylesheet" href="./css/user_apply_module.css" type="text/css" />
    <link rel="stylesheet" href="./right/css/notice.css" type="text/css" />
    <link rel="stylesheet" href="./right/css/todo.css" type="text/css" />
    <!-- 폰트어썸 -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    />
    <!-- 제이쿼리 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="../script/common.js" defer></script>
  </head>
<body>
<?php

include_once '../db/db_conn.php'; //DB연결
include_once '../db/config.php'; //DB세션
include_once '../header.php'; //메뉴
if($userType == 1){
  include_once './right/master_btn-notice.php'; //우측메뉴
} else {
  include_once './right/notice_btn.php'; //우측메뉴
}
$id = $_GET['id']; // 주소창에서 받아오는 값
$id = (int)$id;
$id = mysqli_real_escape_string($conn, $id); // SQL 인젝션 방지용
$query = "select * from learn_table where learn_num= $id "; // 쿼리문
$result = mysqli_query($conn, $query); // DB에 쿼리문을 실행하게 한다
$row = mysqli_fetch_array($result); // 결과값을 불러온다
//각 사용할 내용


$thumb = $row['learn_thumb'];
$title = $row['learn_title'];
$about = $row['learn_about'];
$major = $row['learn_major'];
$date = $row['learn_date'];
$teacher = $row['teacher_name'];
$person = $row['student_person'];
$total = $row['student_total'];
$assignment = $row['lean_assignment'];
$learn_file = $row['learn_file']
?>

<div class="user_apply-class-wrap">
        <img src="./img/learn_thumb/<?=$thumb?>" alt="<?=$title?>" class="class-thumb">
        <div class="title-wrap">
        <h3 class = "class-title">
          <?=$title?>
        </h3>
        <div class = "class-info">
          <p>전공 : <?=$major?></p>
          <p>교수명 : <?=$teacher?></p>
          <p>수강기간 : <?=$date?></p>
          <?php
            if($about == null){
              echo '<p>주차별 과목 : 등록 내용 없음</p>';
            }else{
              echo'<p>주차별 과목 : '.$about.'</p>';
            }
          ?>
          <p>수강생 : <?=$person?>/<?=$total?></p>
          <?php
            if($assignment == null){
              echo '<p>과제 : 과제 없음</p>';
            }else{
              echo'<p>과제 : '.$assignment.'</p>';
            }
          ?>
          <?php
            if($learn_file == null){
              echo '<p>학습자료 : 학습자료 없음</p>';
            }else{
              echo'<p>학습자료 : '.$learn_file.'</p>';
            }
          ?>
          <div class="module_button_div">
          <a href="./user_apply.php" title="돌아가기" class="user_module_button">돌아가기</a>
          </div>
        </div>
      </div>
    </div>
<?php
include_once './right/notice.php'; //우측메뉴
?>
</body>
</html>