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
    <link rel="stylesheet" href="./css/master_apply.css" type="text/css">
    <!-- 폰트어썸 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- 제이쿼리 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="../script/common.js" defer></script>
  </head>
<body>
<?php

include_once '../db/db_conn.php'; //DB연결
include_once '../db/config.php'; //DB세션
include_once '../header.php'; //메뉴
include_once './right/master_btn-learn.php'; //우측메뉴

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
} else

$start = $_GET['page'] ?? 1; // 현재 페이지
if(!$start) $start = 1; // 페이지 번호가 지정이 안되었을 경우
$start = ($start - 1) * 7; // 한 페이지에 표시할 글 수
$scale = 7; // 한 페이지에 표시할 글 수
$sql = "SELECT * FROM learn_table ORDER BY learn_num DESC LIMIT $start, $scale";
$result = mysqli_query($conn, $sql);
?>

<div class="page-nav">
  <h2>강의관리 페이지</h2>

  <p class="page-nav__desc">
    <a href="http://na980414.dothome.co.kr/lms/module/master.php" title="메인페이지 이동"><i class="fas fa-home"></i></a>
  </p>
</div>

<div class="module">

<table class = "table">
  <tr>
    <th>아이디</th>
    <th>강의명</th>
    <th>교수이름</th>
    <th>전공</th>
    <th>강의기간</th>
    <th>정원</th>
    <th>현황</th>
  </tr>

  <?php
  while($rows = mysqli_fetch_array($result)){
    echo '<tr>';
    echo '<td>'.$rows['learn_num'].'</td>';
    echo '<td>'.$rows['learn_title'].'</td>';
    echo '<td>'.$rows['teacher_name'].'</td>';
    echo '<td>'.$rows['learn_major'].'</td>';
    echo '<td>'.$rows['learn_date'].'</td>';
    echo '<td>'.$rows['student_person']. '/' .$rows['student_total'].'</td>';
    ?>
      <td class="apply-tab">
        <form action="./learn_insert.php" method="post" name="reject">
        <input type="hidden" name="learn_id" value="<?=$rows['learn_num']?>">
        <input type="hidden" name="verify" value="no">
        <p class = "brn-wrap">
          <a href="./learn_add.php?mode=modify&id=<?=$rows['learn_num']?>" class="btn btn-apply">변경</a>
          <button type="submit" name="reject" class = "btn btn-delete">폐강</button>
        </p>
        </form>
      </td>
    </tr>
  <?php } ?>

</table>

<!-- pagination -->
<div class="pagination">
          <!-- pagination -->
          <?php
            $sql = "SELECT * FROM learn_table";
            $result = mysqli_query($conn, $sql);
            $total_record = mysqli_num_rows($result); // 전체 글 수
            $total_page = ceil($total_record / $scale); // 전체 페이지 수
            $current_page = $_GET['page'] ?? 1; // 현재 페이지
            if(!$current_page) $current_page = 1; // 페이지 번호가 지정이 안되었을 경우
            $block_pages = 5; // 한 화면에 표시할 페이지 수
            $block_total = ceil($total_page / $block_pages); // 전체 블록 수
            $current_block = ceil($current_page / $block_pages); // 현재 블록

            $prev_page = $current_page - 5; // 이전 페이지
            $next_page = $current_page + 5; // 다음 페이지
            if ($prev_page < 0){ // 페이지 번호가 지정이 안되었을 경우
              $prev_page = 1;
            } 
            else if ($next_page > $total_page) {// 마지막 페이지를 넘어갔을 경우
              $next_page = $total_page;
            } 

            if($current_page < 6){
              echo '<span class="prev disable">이전</span>';
            } else {
            echo '
            <a href="learn_master.php?page=' . $prev_page . '" class="prev">이전</a>
            ';
            };
            for ($i = $current_block * $block_pages - $block_pages + 1; $i <= $current_block * $block_pages; $i++) {
              if ($i > $total_page) break;
              if ($i == $current_page) {
                echo '<a href="learn_master.php?page=' . $i . '" class="active">' . $i . '</a>';
              } else {
                echo '<a href="learn_master.php?page=' . $i . '">' . $i . '</a>';
              }
            }
            if($total_page < 6){
              echo '<span class="next disable">다음</span>';
            } else if ($current_page > $total_page - 3) {
              echo '<span class="next disable">다음</span>';
            } else {
            echo '
            <a href="learn_master.php?page=' . $next_page . '" class="next">다음</a>
            ';
            };
          ?>          
        </div>

</div>
</body>
</html>