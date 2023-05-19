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


$id = $_SESSION['lms_logon'];

$sql = "SELECT user_num, user_major, user_id, user_name, learn_list, user_type FROM user_table WHERE user_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$major = $row['user_major'];
$learn_list = $row['learn_list'];
$learn_list = explode(',', $learn_list);

$learnsql = "SELECT * FROM learn_table where learn_major like '%$major%' or learn_major like '%교양과목%'";
$learn_result = mysqli_query($conn, $learnsql);

if($row['user_type'] == 0){
  echo '<script>alert("등록 대기중인 ID입니다.");</script>';
  echo '<script>location.href="../index.php";</script>';
  exit;
} else if($row['user_type'] == 2){
  echo '<script>alert("교직원 ID입니다. 강의등록을 이용해주세요");</script>';
  echo '<script>location.href="../index.php";</script>';
  exit;
}

?>

<div class="page-nav">
  <h2>수강신청 페이지</h2>

  <p class="page-nav__desc">
    <a href="http://na980414.dothome.co.kr/lms/index.php" title="메인페이지 이동"><i class="fas fa-home"></i></a> > <a href="http://na980414.dothome.co.kr/lms/module/user_apply.php" title="수강신청페이지 이동">수강신청</a>
  </p>
</div>

<div class="module">

<table class="table">
    <tr>
      <th>과목번호</th>
      <th>과목명</th>
      <th>담당교수</th>
      <th>수강현황</th>
      <th>수강신청</th>
    </tr>

    <?php

  while($rows = mysqli_fetch_array($learn_result)){

  // 만약 이미 신청한 과목이라면 신청완료 버튼을 띄워준다.
  $applysql = "SELECT * FROM learn_apply WHERE user_id = '{$row['user_id']}' AND learn_title = '{$rows['learn_title']}'";
  $apply_result = mysqli_query($conn, $applysql);
  $apply_row = mysqli_fetch_array($apply_result);

  echo '<tr>';
  echo '<td>'.$rows['learn_num'].'</td>';
  echo '<td>'.$rows['learn_title'].'</td>';
  echo '<td>'.$rows['teacher_name'].'</td>';
  echo '<td>'.$rows['student_person']. '/' .$rows['student_total'].'</td>';
  echo '<td>';

  if($apply_row) {  // 만약에 존재한다면
    // 신청완료로 표시한다.
    echo '<span class="btn btn-done">신청완료</span>';
  } else { // 존재하지 않는다면
    // 신청버튼을 띄워준다.
    if(!in_array($rows['learn_title'], $learn_list)){?>
      <form action="./user_apply_confirm.php" method="post" class="user_apply_form">
        <input type="hidden" name="user_num" value="<?=$row['user_num']?>">
        <input type="hidden" name="user_name" value="<?=$row['user_name']?>">
        <input type="hidden" name="learn_num" value="<?=$rows['learn_num']?>">
        <input type="hidden" name="learn_title" value="<?=$rows['learn_title']?>">
        <input type="hidden" name="verify" value="ok">
        <button type="submit" name="apply" class="btn btn-apply">신청</button><a href=""></a>
      </form>
    <?php }
  }
  echo '<a class="user_apply_detail" href="user_apply_module.php?id='.$rows['learn_num'].'">미리보기</a>';
  echo '</td>';
  echo '</tr>';
} ?>


</table>
</div>
<?php
include_once './right/notice.php'; //우측메뉴
?>
</body>
</html>