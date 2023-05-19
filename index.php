<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <script src="./script/common.js"></script>
  </head>
  <!-- <script defer>
    //배열객체를 사용하여 스마트폰의 종류별 명칭을 넣어준다.
    let mobile_keys = new Array('Android','iPhone','iPad','SAMSUNG','BlackBerry','Windows Phone','Windows CE','MOT','SonyEricsson','Nokia');

    //만약에 주소에 move_pc_screen값이 없다면..
    if(document.URL.match('move_pc_screen')) mobile_keys = null; 

    //위 배열값 개수만큼 반복하여 검사를 하고 모바일 사용자이면 아래 내용을 실행
    for(i in mobile_keys){ //in키워드 : 키값이 있으면 true 없으면 false
      if(navigator.userAgent.match(mobile_keys[i]) != null){
      location.href = "./m_index.php"; 	// 모바일 홈 연결 주소
        break;
    }
    }
    </script> -->
<body>
<?php
// PHP 모듈 
include_once './db/db_conn.php'; // DB 연결
include_once './db/config.php'; // 세션
include_once './header.php'; // 헤더
include_once './module/right/notice.php'; //우측메뉴
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



<!-- PC페이지 -->
<div class="pc_index">

  <!-- PC상단배너 -->
<div class="page-nav">
  <h2><span class="">환영합니다.</span> <?=$userRow['user_name']?><span class="">님</span></h2>
  <p class="page-nav__desc">
    <span><?=$userRow['user_major']?>, <?=$userRow['user_grade']?>학년</span>
    <span><?php echo date("Y년 m월 d일"); ?></span>
  </p>
</div>

<!-- PC모듈(페이지내용) -->
<div class="module">


<!-- PC수강과목 -->
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
      
      // 강의중인지 강의 중이 아닌지 확인

      $tday = date('Ymd'); //오늘날짜
      $today = (int)$tday;

      // 강의시작날짜 구하기
      $learnDay = explode('~', $learnRow['learn_date']);
      $startDate = explode('-', $learnDay[0]);
      $startDay = $startDate[0] . $startDate[1] . $startDate[2];
      $startDay = (int)$startDay; 

      // 강의종료날짜 구하기
      $endDate = explode('-', $learnDay[1]);
      $endDay = $endDate[0] . $endDate[1] . $endDate[2];
      $endDay = (int)$endDay; 

      $progress = '준비중'; //진행현황 기본값은 준비중

      if ($endDay < $today){
        $progress = "종강";
      } else if ($startDay < $today){
        $progress = "강의중";
      } else{
        $progress;
      }

      ?>

      <div class="index-class-wrap">
        <a href="./module/learn.php?id=<?=$learnRow['learn_num']?>" title="<?=$learnRow['learn_title']?>">
        <img src="./module/img/learn_thumb/<?=$learnRow['learn_thumb']?>" alt="<?=$learnRow['learn_title']?>" class="class-thumb">

        <div class="title-wrap">
          <span class="class-progress"><?=$progress?></span>
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
    </div>
</div>
</div>


<!-- 모바일페이지 -->


<div class="mobile_index">
<?php
  include_once './db/db_conn.php'; // DB 연결
  include_once './db/config.php'; // 세션
  include_once './header.php'; //헤더
  ?>

  <?php
  if($userType == 1){ // 마스터 계정일 경우 master.php로 이동
    echo'
    <script>
    location.href = "http://na980414.dothome.co.kr/lms/module/master.php";
    </script>
    ';
  }
  if($userRow['learn_list']== null){
    $userRow['learn_list'] = "";
  }
  
  $learn_list = explode(',', $userRow['learn_list']);
  ?>
  
  <!-- 취업특강배너 -->
  <div class="m-page-nav">
    <div class="m-page-nav-banner">
      <a href="http://na980414.dothome.co.kr/lms/module/notice.php?id=56" title="취업특강 바로가기">
        <span class="nav-banner-bg">&nbsp;</span>
        <span class="nav-banner-font">취업특강 <strong>바로가기</strong></span>
      </a>
    </div>

    <!-- 상단 학년/날짜 -->
    <p class="page-nav__desc">
      <span>환영합니다. <?=$userRow['user_name']?>님</span>
      <span><?=$userRow['user_major']?>, <?=$userRow['user_grade']?>학년</span>
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
		<a href="index.php?year=<?php echo $year-1 ?>&month=12"><img src="./img/learning/more.svg" alt="이전달" class="calendar-prev"></a>
	<?php else: ?>
		<!-- 이번 년 이전 월 -->
		<a href="index.php?year=<?php echo $year ?>&month=<?php echo $month-1 ?>"><img src="./img/learning/more.svg" alt="이전달" class="calendar-prev"></a>
	<?php endif ?>

  <p><?php echo "$year 년 $month 월" ?></p>

	<!-- 현재가 12월이라 다음 달이 내년 1월인경우 -->
	<?php if ($month == 12): ?>
		<!-- 내년 1월 -->
		<a href="index.php?year=<?php echo $year+1 ?>&month=1"><img src="./img/learning/more.svg" alt="다음달"></a>
	<?php else: ?>
		<!-- 이번 년 다음 월 -->
		<a href="index.php?year=<?php echo $year ?>&month=<?php echo $month+1 ?>"><img src="./img/learning/more.svg" alt="다음달"></a>
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
      <h3><?php echo date("Y 년 m 월 d 일") ?></h3>
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

<div class="m-learn_list-wrap">

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

      // 강의중인지 강의 중이 아닌지 확인

      $tday = date('Ymd'); //오늘날짜
      $today = (int)$tday;

      // 강의시작날짜 구하기
      $learnDay = explode('~', $learnRow['learn_date']);
      $startDate = explode('-', $learnDay[0]);
      $startDay = $startDate[0] . $startDate[1] . $startDate[2];
      $startDay = (int)$startDay; 

      // 강의종료날짜 구하기
      $endDate = explode('-', $learnDay[1]);
      $endDay = $endDate[0] . $endDate[1] . $endDate[2];
      $endDay = (int)$endDay; 

      $progress = '개강예정'; //진행현황 기본값은 준비중

      if ($endDay < $today){
        $progress = "종강";
      } else if ($startDay < $today){
        $progress = "강의중";
      } else{
        $progress;
      }

      $dday = (strtotime($endDay) - strtotime($tday) ) / 86400;
      $result = 'D-' . $dday;


      if($startDay > $today){
        $result = "강의 시작 전입니다.";
      }else if($dday <= 0){
        $result = "강의가 종료되었습니다";
      }else{
        $result;
      }

      ?>
      
    <div class="m-index-class-wrap">
      <a href="http://na980414.dothome.co.kr/lms/module/learn.php?id=<?=$learnRow['learn_num']?>" title="<?=$learnRow['learn_title']?>">
      <img src="http://na980414.dothome.co.kr/lms/module/img/learn_thumb/<?=$learnRow['learn_thumb']?>" alt="<?=$learnRow['learn_title']?>" class="class-thumb">

      
      <div class="title-wrap">
      <span class="class-progress"><?=$progress?></span>
      <h3 class = "class-title">
        <?=$learnRow['learn_title']?>
        <img src="./img/learning/more.svg" alt="더보기" class="more_btn">
      </h3>
      <p class = "class-info">
        <span class="class-major">
          <?=$learnRow['learn_major']?>
        </span>
        <span class="class-teacher">
          <strong>교수</strong> <?=$learnRow['teacher_name']?>
        </span>
        <span class="class-date">
          <?=$learnRow['learn_date']?>
        </span>
        <span class="class-dday"><?=$result?></span>
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
    <span class="m-notice-more"><a href="http://na980414.dothome.co.kr/lms/module/notice_list.php" title="공지사항 "><span>더보기</span><i class="fa-solid fa-angle-right"></i></a></span>
  </div>

  <ul class="m-notice-list">
    <?php
      $query = "SELECT * FROM notice_list WHERE learn_num = 0 ORDER BY num DESC LIMIT 0, 3"; // learn_num이 0인 데이터만 가져오고, 최신 글 순으로 정렬하여 상위 7개의 데이터만 조회

      $result = mysqli_query($conn, $query);
      while($data = mysqli_fetch_array($result)){

    ?>
    <li>
      <a href="http://na980414.dothome.co.kr/lms/module/notice.php?id=<?=$data['num']?>" title="">
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
<script>
  // 모바일 수강과목 더보기 버튼 작동
  $(function(){
    $('.m-learn_list-wrap > .m-index-class-wrap').hide();
    $(".m-learn_list-wrap > .m-index-class-wrap").slice(0, 3).css("display", "block"); 
    $(".learn_major_more").click(function(e){
        e.preventDefault();
      $(".m-learn_list-wrap > div:hidden").slice(0, 3).fadeIn(200).css('display', 'block'); // 클릭시 more 갯수 지정
      if($(".m-learn_list-wrap >div:hidden").length == 0){ // 컨텐츠 남아있는지 확인
          $('.learn_major_more').fadeOut(100); // 컨텐츠 없을 시 버튼 사라짐
      }
    });
  });
</script>
</div>
</div>

</body>
</html>