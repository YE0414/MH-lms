<!-- 기본 우측메뉴 공지사항&나의일정 (유저용) -->


  <div class="user-right">
    <div class="ub-wrap">
      <div class="user-bg">
        <div class="notice-wrap">
          <span class="r-notice-title">공지사항</span>
          <span class="r-notice-more"><a href="http://na980414.dothome.co.kr/lms/module/notice_list.php" title="공지사항 "><span>더보기</span><i class="fa-solid fa-angle-right"></i></a></span>
        </div>
        <ul class="notice-list">
          <?php
            $query = "SELECT * FROM notice_list WHERE learn_num = 0 ORDER BY num DESC LIMIT 0, 7"; // learn_num이 0인 데이터만 가져오고, 최신 글 순으로 정렬하여 상위 7개의 데이터만 조회

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
  </div>
  <?php
      include 'list.php'; //나의 일정
      ?>
  </div>
