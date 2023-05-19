<!-- 비로그인시 보이는 우측메뉴 이미지&공지사항 -->

<div class="master-btn">

  <img src="http://na980414.dothome.co.kr/lms/module/right/img/master_menu.png" alt="마스터">

  <div class="bg-wrap">
    <div class="user-bg">
      <div class="menu-wrap">
      <span class="r-notice-title">공지사항</span>
      <span class="r-notice-more"><a href="http://na980414@na980414.dothome.co.kr/lms/module/notice_list.php" title="공지사항 "><span>더보기</span><i class="fa-solid fa-angle-right"></i></a></span>
      </div>
      <ul class="notice-list">
          <?php
            $query = 'select * from notice_list order by num desc limit 0,7'; //가장 최신글을 위로 올라오게 조회하여 변수에 저장

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
  </div>
</div>