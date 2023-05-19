<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>명지대학교 lms</title>
    <!-- 베이스css(리셋 포함) -->
    <link rel="stylesheet" href="./css/base.css" type="text/css">
    <!-- 헤더푸터 -->
    <link rel="stylesheet" href="./css/common.css" type="text/css" />

    <!-- 모듈 CSS -->
    <link rel="stylesheet" href="./css/index.css" type="text/css" />
    <link rel="stylesheet" href="./css/m_index.css" type="text/css" />

    <!-- 우측메뉴css -->
    <link rel="stylesheet" href="./module/right/css/notice.css" type="text/css" />
    <link rel="stylesheet" href="./module/right/css/todo.css" type="text/css" />

    <!-- 폰트어썸 -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    />
    <!-- 제이쿼리 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="./script/common.js" defer></script>
</head>
<body>
  <?php
  include_once './db/db_conn.php'; // DB 연결
  include_once './db/config.php'; // 세션
  include_once './header.php'; //헤더
  ?>

<?php
if($userType == 1){ // 마스터 계정일 경우 master.php로 이동
  echo'
  <script>
  location.href = "./module/master.php";
  </script>
  ';
}

// 로그인 세션 시작
if(isset($_SESSION['lms_logon'])){ // 로그인이 되어있을 경우
$mySession = $_SESSION['lms_logon'] ?? '';
$userSQL = "SELECT * FROM user_table WHERE user_id = '$mySession'";
$userQuery = mysqli_query($conn, $userSQL);
$userRow = mysqli_fetch_array($userQuery);
} else { // 비로그인은 메인페이지가 로그인
echo'
<script>
location.href = "./module/login.php";
</script>
';
}
if($userRow['learn_list']== null){
  $userRow['learn_list'] = "";
}

$learn_list = explode(',', $userRow['learn_list']);
?>

  <?php
  if($userType == 1){ // 마스터 계정일 경우 master.php로 이동
    echo'
    <script>
    location.href = "./module/master.php";
    </script>
    ';
  }
  if($userRow['learn_list']== null){
    $userRow['learn_list'] = "";
  }
  
  $learn_list = explode(',', $userRow['learn_list']);
  ?>
  
  <div class="m-page-nav">
    <div class="m-page-nav-banner">
      <a href="./module/notice.php?id=56" title="취업특강 바로가기">
        <span class="nav-banner-bg">&nbsp</span>
        <span class="nav-banner-font">취업특강 <strong>바로가기</strong></span>
      </a>
    </div>

    <p class="page-nav__desc">
      <span><?=$userRow['user_major']?>, <?=$userRow['user_grade']?>학년</span>
      <span><?php echo date("Y년 m월 d일"); ?></span>
    </p>
  </div>
  
  <!-- 캘린더 -->
  <div class="m-module">
    <div class="calendar">
    <?php 
      // GET으로 넘겨 받은 year값이 있다면 넘겨 받은걸 year변수에 적용하고 없다면 현재 년도
      $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
      // GET으로 넘겨 받은 month값이 있다면 넘겨 받은걸 month변수에 적용하고 없다면 현재 월
      $month = isset($_GET['month']) ? $_GET['month'] : date('m');

      $date = "$year-$month-01"; // 현재 날짜
      $time = strtotime($date); // 현재 날짜의 타임스탬프
      $start_week = date('w', $time); // 1. 시작 요일
      $total_day = date('t', $time); // 2. 현재 달의 총 날짜
      $total_week = ceil(($total_day + $start_week) / 7);  // 3. 현재 달의 총 주차

    ?>
  <div class="calendar-year-month">
	<!-- 현재가 1월이라 이전 달이 작년 12월인경우 -->
	<?php if ($month == 1): ?>
		<!-- 작년 12월 -->
		<a href="m_index.php?year=<?php echo $year-1 ?>&month=12"><img src="./img/learning/more.svg" alt="이전달" class="calendar-prev"></a>
	<?php else: ?>
		<!-- 이번 년 이전 월 -->
		<a href="m_index.php?year=<?php echo $year ?>&month=<?php echo $month-1 ?>"><img src="./img/learning/more.svg" alt="이전달" class="calendar-prev"></a>
	<?php endif ?>

  <p><?php echo "$year 년 $month 월" ?></p>

	<!-- 현재가 12월이라 다음 달이 내년 1월인경우 -->
	<?php if ($month == 12): ?>
		<!-- 내년 1월 -->
		<a href="m_index.php?year=<?php echo $year+1 ?>&month=1"><img src="./img/learning/more.svg" alt="다음달"></a>
	<?php else: ?>
		<!-- 이번 년 다음 월 -->
		<a href="m_index.php?year=<?php echo $year ?>&month=<?php echo $month+1 ?>"><img src="./img/learning/more.svg" alt="다음달"></a>
	<?php endif ?>
  </div>

	<ul class="calendar-main">
			<li>일</li> 
			<li>월</li> 
			<li>화</li> 
			<li>수</li> 
			<li>목</li> 
			<li>금</li> 
			<li>토</li> 

<!-- 총 주차를 반복합니다. -->
  <?php for ($n = 1, $i = 0; $i < $total_week; $i++): ?> 
    <!-- 1일부터 7일 (한 주) -->
    <?php for ($k = 0; $k < 7; $k++): ?> 
      <?php $class = ($n == date('j') && $month == date('m') && $year == date('Y')) ? 'today' : ''; ?>
      <li class="<?php echo $class; ?>">
        <span>
          <?php if ( ($n > 1 || $k >= $start_week) && ($total_day >= $n) ): ?>
            <?php echo $n++; ?>
          <?php endif; ?>
        </span>
      </li> 
    <?php endfor; ?> 
  <?php endfor; ?> 
  </ul>


    </div>
  <!-- todolist -->
    <div class="calendar-todo-bg">
    <div class="calendar-todo">
      <h3><?php echo date("m 월 d 일") ?></h3>
      <ul>
        <li>12:00 밥먹기</li>
        <li>14:00 숨쉬기 강의</li>
      </ul>
    </div>
  </div>

    <!-- 수강과목 -->

    <div class="m-notice-wrap">
    <span class="r-notice-title">수강과목</span>
    <span class="r-notice-more"></span>
  </div>

<div class="learn_list-wrap">

<?php
if($userRow['user_type'] == 0){
  echo '<p>가입대기중인 계정입니다. 관리자의 승인이 필요합니다.</p>';
}

if($userRow['learn_list'] == "" && $userRow['user_type'] == 1){
  echo '<p class="learn_list-none">수강중인 강의가 없습니다.</p>';
  echo '<p class="learn_list-none">강의를 수강하려면 <a href="./module/user_apply.php">수강신청</a>에서 수강신청을 해주세요.</p>';
} else {

foreach($learn_list as $value){
  $learnSQL = "SELECT * FROM learn_table WHERE learn_title = '$value'";
  $learnQuery = mysqli_query($conn, $learnSQL);
  while($learnRow = mysqli_fetch_array($learnQuery)){
    if($learnRow['learn_major'] == '교양과목'){
      $learnRow['learn_major'] = '교양과목';
    } else {  
      $learnRow['learn_major'] = '전공과목';
    }      
    ?>
    <div class="index-class-wrap">
      <a href="./module/learn.php?id=<?=$learnRow['learn_num']?>" title="<?=$learnRow['learn_title']?>">
      <img src="./module/img/learn_thumb/<?=$learnRow['learn_thumb']?>" alt="<?=$learnRow['learn_title']?>" class="class-thumb">

      
      <div class="title-wrap">
      <h3 class = "class-title">
        <?=$learnRow['learn_title']?>
        <img src="./img/learning/more.svg" alt="더보기" class="more_btn">
      </h3>
      <p class = "class-info">
        <span class="class-major">
          <?=$learnRow['learn_major']?>
        </span>
        <span>
          <?=$learnRow['teacher_name']?>
        </span>
        <span class="class-date">
          <?=$learnRow['learn_date']?>
        </span>
      </p>
      </div>
      </a>
    </div>
  <?php
      }
    }}
  ?>
    <input type="button" value="나의 강의 더보기" class="learn_major_more">
  </div>



<!-- 공지사항 -->

<div class="m-user-bg">
  <div class="m-notice-wrap">
    <span class="r-notice-title">공지사항</span>
    <span class="r-notice-more"><a href="http://na980414@na980414.dothome.co.kr/lms/module/notice_list.php" title="공지사항 "><span>더보기</span><i class="fa-solid fa-angle-right"></i></a></span>
  </div>

  <ul class="notice-list">
    <?php
      $query = 'select * from notice_list order by num desc limit 0,3'; //가장 최신글을 위로 올라오게 조회하여 변수에 저장

      $result = mysqli_query($conn, $query);
      while($data = mysqli_fetch_array($result)){

    ?>
    <li>
      <a href="notice.php?id=<?=$data['num']?>" title="">
      <?=$data['notice_title']?>
      </a>

      <span><?php
        $date = $data['notice_date'];
        $new_date = date('y년 m월 d일', strtotime($date));
        echo $new_date;
        ?>
      </span>
  </li>
  <?php } ?>
  </ul>
</div>
<script defer>
    $(function(){
      $(window).resize(function() {

      if($(window).width() <= 768) {

        location.href = "./m_index.php";
        
      }else{
        location.href = "./index.php";
      }

      });
    });
  </script>
</body>
</html>