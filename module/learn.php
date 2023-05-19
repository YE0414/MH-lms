<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>명지대학교 lms</title>
    <!-- 파비콘 -->
    <link rel="icon" href="./img/pavicon.ico" type="image/x-icon" sizes="16x16">
    <!-- 베이스css(리셋 포함) -->
    <link rel="stylesheet" href="../css/base.css" type="text/css">
    <!-- 헤더푸터 -->
    <link rel="stylesheet" href="../css/common.css" type="text/css">
    <!-- 모듈 CSS -->
    <link rel="stylesheet" href="./css/learn.css" type="text/css">
    <!-- 폰트어썸 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- 제이쿼리 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../script/common.js" defer></script>
  </head>
<body>

  <?php
    include_once '../db/db_conn.php'; //DB연결
    include_once '../db/config.php'; //DB세션
    include_once '../header.php'; //메뉴

    $id = $_GET['id'];
    $sql = "SELECT * FROM learn_table WHERE learn_num = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $thumb = $row['learn_thumb'];
    $title = $row['learn_title'];
    $teacher_name = $row['teacher_name'];
    $teacher_email = $row['teacher_email'];
    $major = $row['learn_major'];
    $date = $row['learn_date'];

    if($major == '교양과목'){
      $major_badge = '교양과목';
    } else if(strpos($major, ", 교양과목") !== false){ 
      $major_badge = '전공, 교양';
    } else {
      $major_badge = '전공과목';
    }
  ?>
  
  <div class="thumb-wrap">
    <img src="./img/learn_thumb/<?=$thumb?>" alt="강의 썸네일" class="title-wrap__image">
  </div>

  <div class="title-wrap">
    <p class="learn-title-wrap">
      <span class="learn-title">
        <?=$title?>
      </span>
      <span class="learn-badge"> 
        <?=$major_badge?>
      </span>
    </p>


    <ul class="learn-about">
      <li>
        <span class="learn-info">
          전공명
        </span>
        <span class="learn-item">
          <?=$major?>
        </span>
      </li>
      <li>
        <span class="learn-info">
          과목유형
        </span>
        <span class="learn-item">
          <?=$major_badge?>
        </span>
      </li>
      <li>
        <span class="learn-info">
          과목명
        </span>
        <span class="learn-item">
          <?=$title?>
        </span>
      </li>
      <li>
        <span class="learn-info">
          담당교수
        </span>
        <span class="learn-item">
          <?=$teacher_name?>
        </span>
      </li>
      <li>
        <span class="learn-info">
          강의기간
        </span>
        <span class="learn-item">
          <?=$date?>
        </span>
      </li>
    </ul>
    </div>



    <ul class="learn-tab_btn">
      <li class="act">강의목록</li>
      <li>수업자료</li>
      <li>과제제출</li>
      <li>진도율</li>
    </ul>

    <?php 
    include_once './learn_module_class.php';
    include_once './learn_module_files.php';
    include_once './learn_module_upload.php';
    ?>
    <div class="learn_class-list">
      <ul>
        <li class="learn_cass-date"> 
          <p class="learn-class-title list04">진도율</p>
          <div class="progress">
            <div class="progress-bar">
              <span class="progress-bar-inner">75%</span>
              <span class="progress-bar-bg">100</span>
              <span class="progress-bar-bg2">25</span>
              <span class="progress-bar-bg3">50</span>
              <span class="progress-bar-bg4">75</span>
            </div>
          </div>
          <p class="learn-class-title list04">강의 기간</p>
          <p class="learn-class-date">
            <?=$date?>
          </p>
        </li>
      </ul>
    </div>

  <script>
    const tabBtn = document.querySelectorAll('.learn-tab_btn li');
    const tabItem = document.querySelectorAll(
    ('.learn_class-list'))
    tabBtn.forEach((item, index) => {
      item.addEventListener('click', () => {
        tabBtn.forEach((item) => {
          item.classList.remove('act');
        })
        tabItem.forEach((item) => {
          item.classList.remove('act');
        })
        item.classList.add('act');
        tabItem[index].classList.add('act');
      })
    })
  </script>

  <p class="learn-class-title list04">
    공지사항
  </p>
  <?php include_once 'notice_list_mobile_module.php' ?>

</body>
</html>