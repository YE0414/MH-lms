<?php

$data = [
  'notice_title' => '',
  'notice_text' => '',
  'notice_file' => ''
];

$id = $_GET['id']; // 주소창(?)에서 받아오는 값
$id = (int)$id;
$id = mysqli_real_escape_string($conn, $id); // SQL 인젝션 방지용
//escape_string=우리가 string을 입력할때 Tom's cat 이란 입력을 하면  '는 sql문에 앞서 있던 ' 와 중첩이 될 수 있다. 이러한 문제를 막기위해 \n, \r \" 처럼 구별해주는 형태로 만들어주는 것을 Escape string 이라고 한다.
//만약 Escape하지 않은 소스로 그냥  input을 받는다고 생각해보자.
// 사용자가 입력창에 'DROP TABLE 테이블명' 같은 위험성 있는 문장을 악의적으로 기입 할 수 있다. 그러면 테이블이 다 날라가버린다. (이를 injection 공격이라고 한다.)
// mysqli_real_escape_string 을 통해 그러한 공격을 방지하며 입력받을 수가 있다.
$query = "select * from notice_list where num= $id "; // 쿼리문
$result = mysqli_query($conn, $query); // DB에 쿼리문을 실행하게 한다
$data = mysqli_fetch_array($result); // 결과값을 불러온다

//각 사용할 내용
$id = $data['num']; 
$title = $data['notice_title'];
$text = $data['notice_text'];
$file = $data['notice_file'];
$date = $data['notice_date'];
$date = explode('-', $date);
//PHP 함수 중 하나인 explode 함수는 문자열을 특정 문자열로 나누어서 배열로 반환해주는 함수입니다. 상반되는 함수로  im plode 함수가 있습니다.explode( 경계 문자열   , 나눌 문자열 , 제한 갯수<필수x )
$date = $date[0].'. '.$date[1].'. '.$date[2];
$views = $data['notice_views'];
$learn_num = $data['learn_num'];
$teacher_name = $data['teacher_name'];
$learn_major = $data['learn_major'];

$query = "SELECT learn_title FROM learn_table where ";
//조회수 증가
$view_sql = "UPDATE notice_list set notice_views = notice_views + 1 where num = {$id}";
mysqli_query ($conn, $view_sql);
?>

<main>
<form name='write' method="post" action="writePost.php" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?=$id?>">
  <article>
  <h2><??></h2>
  <div class="notice-info-wrap">
    <h2><?=$title?></h2>
    <div class="notice-sub-wrap">
      <p><span class="notice-info">작성일</span><?=$date?></p>
      <p><span class="notice-info">조회수</span><?=$views?></p>
    </div>
  </div>

  <?php if($file) {?>
  <div class="notice-file-wrap">
    <p class="notice-file">
      <a href="./files/<?=$file?>" title="첨부파일 다운로드" class="btn-sub btn-file"><span class="notice-info">첨부파일</span>
      <i class="fas fa-download"></i>
      <?=$file?></a>
    </p>
  </div>
  <?php }?>

  <div>
    <p class="notice-item">
      <?php
        echo nl2br($text);
      ?>
    </p>
      <div class="notice-btn-wrap">

      
      <?php if($userType == 1){?>
      <p class = "notice-mod-wrap"> 
        <a href="notice_write.php?id=<?=$id?>&modify=mod" title="수정하기" class="btn-sub btn-mod">수정하기</a>
        <a href="confirmDel.php?id=<?=$id?>" title="삭제하기" class="btn-sub btn-del">삭제하기</a>
      </p>
        <a href="notice_list.php" class="btn btn-list" title="글목록보기">글목록보기</a>
      <?php } else {?>
        <p>&nbsp;</p>
        <a href="notice_list.php" class="btn btn-list" title="글목록보기">글목록보기</a>
      <?php }?>
      </div>
  </div>
  </article>
</form>
</main>