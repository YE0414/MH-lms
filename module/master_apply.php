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
    <link rel="stylesheet" href="./css/master_apply.css" type="text/css" />

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

include_once '../db/db_conn.php';
include_once '../db/config.php';
include_once '../header.php';
include_once './right/master_btn-apply.php';

$id = $_SESSION['lms_logon'];

$verify_sql = "SELECT user_type FROM user_table WHERE user_id = '$id'";
$result = mysqli_query($conn, $verify_sql);
$row = mysqli_fetch_array($result);
$master = $row['user_type'];

// 관리자가 아닐 경우
if($master != 3){
  echo('
  <script>
    alert("관리자만 접근할 수 있습니다.");
    location.href = "./index.php";
  </script>
  ');
} else {

$sql = "SELECT * FROM learn_apply order by apply asc";
$result = mysqli_query($conn, $sql);
?>

<div class="page-nav">
  <h2>수강신청 관리페이지</h2>

  <p class="page-nav__desc">
    <a href="http://na980414.dothome.co.kr/lms/module/master.php" title="메인페이지(유저관리페이지) 이동"><i class="fas fa-home"></i></a> > <a href="http://na980414.dothome.co.kr/lms/module/master_apply.php" title="수강신청 관리 페이지">수강신청 관리</a>
  </p>
</div>

<div class="module">

<table class="table">
    <tr>
      <th>신청번호</th>
      <th>신청과목</th>
      <th>신청자</th>
      <th>신청날짜</th>
      <th>신청여부</th>
    </tr>
    <?php
    while($rows = mysqli_fetch_array($result)){
      echo '<tr>';
      echo '<td>'.$rows['apply_ID'].'</td>';
      echo '<td>'.$rows['learn_title'].'</td>';
      echo '<td>'.$rows['user_name'].'</td>';
      echo '<td>'.$rows['apply_date'].'</td>';
      if($rows['apply'] == 0){ ?>
        <td>
          <form action="./master_apply_confirm.php" method="post">
          <input type="hidden" name="apply_ID" value="<?=$rows['apply_ID']?>">
          <input type="hidden" name="verify" value="ok">
          <button type="submit" name="approve" class="btn btn-confirm1">승인</button>
          </form>
        </td>
      <?php }
      else{
      echo '<td> <span  class="btn btn-apply">승인됨</span></td>';
      }
      echo '</tr>';
    }
    }
    ?>

  </table>
</div>
</body>
</html>