<?php

$data = [
  'notice_title' => '',
  'notice_text' => '',
  'notice_file' => ''
];

$id = $_GET['id']; // 주소창에서 받아오는 값
$id = (int)$id;
$id = mysqli_real_escape_string($conn, $id); // SQL 인젝션 방지용
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
$date = $date[0].'년 '.$date[1].'월 '.$date[2].'일';
$views = $data['notice_views'];
$prev = $_SERVER["HTTP_REFERER"];

//조회수 증가
$view_sql = "UPDATE notice_list set notice_views = notice_views + 1 where num = {$id}";
mysqli_query ($conn, $view_sql);
?>

<main>
<form name='write' method="post" action="writePost.php" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?=$id?>">
  <article class="notice-page">
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
    <div class="notice-item">
      <?php
        echo nl2br($text);
      ?>
    </div>
      <div class="notice-btn-wrap">

      
      <?php if($userType == 1){?>
      <p class = "notice-mod-wrap"> 
        <a href="notice_write.php?id=<?=$id?>&modify=mod" title="수정하기" class="btn-sub btn-mod">수정하기</a>
        <a href="confirmDel.php?id=<?=$id?>" title="삭제하기" class="btn-sub btn-del">삭제하기</a>
      </p>
        <a href="<?=$prev?>" class="btn btn-list" title="글목록보기">글목록보기</a>
      <?php } else {?>
        <p>&nbsp;</p>
        <a href="<?=$prev?>" class="btn btn-list" title="글목록보기">글목록보기</a>
      <?php }?>
      </div>
  </div>
  </article>
</form>
</main>