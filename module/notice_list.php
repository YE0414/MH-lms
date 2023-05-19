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
    <link rel="stylesheet" href="./css/notice_list.css" type="text/css" />
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
// PHP 모듈 
include_once '../db/db_conn.php'; // DB 연결
include_once '../db/config.php'; // 세션
include_once '../header.php'; // 헤더
if($userType == 1){
  include_once './right/master_btn-notice.php'; //우측메뉴
} else {
  include_once './right/notice_btn.php'; //우측메뉴
}
?>

<div class="page-nav">
  <h2>공지사항</h2>
  <p class="page-nav__desc">
    <a href="http://na980414.dothome.co.kr/lms/index.php" title="메인페이지 이동"><i class="fas fa-home"></i></a> > <a href="http://na980414.dothome.co.kr/lms/module/notice_list.php" title="공지사항 이동">공지사항</a>
  </p>
</div>

<div class="module">
<?php include_once './notice_list_module.php'?>
</div>
</body>
</html>