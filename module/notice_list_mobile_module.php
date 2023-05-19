      <div class="notice-wrap">
          <ul class="notice-title-wrap">
            <li class="notice-num">번호</li>
            <li class="notice-title">제목</li>
            <li class="notice-file">첨부</li>
            <li class="notice-date">등록일</li>
            <li class="notice-view">조회수</li>
          </ul>
          
          <!-- PHP 목록 불러오기 -->
          <?php
            $learnID = $_GET['id'];
            $start = $_GET['page'] ?? 1; // 현재 페이지
            if(!$start) $start = 1; // 페이지 번호가 지정이 안되었을 경우
            $start = ($start - 1) * 5; // 한 페이지에 표시할 글 수
            $scale = 5; // 한 페이지에 표시할 글 수
            $sql = "SELECT * FROM notice_list where learn_num = $learnID  ORDER BY num DESC LIMIT $start, $scale"; // DESC 내림차순, ASC 오름차순
            $result = mysqli_query($conn, $sql); // 쿼리문 실행

            while($row = mysqli_fetch_array($result)){
              $nl_num = $row['num'];
              $nl_title = $row['notice_title'];
              $nl_file = $row['notice_file'];

              $nl_date = explode('-', $row['notice_date']);
              $nl_date = $nl_date[0].'.'.$nl_date[1].'.'.$nl_date[2];

              $nl_view = $row['notice_views'];

              echo '<ul class="notice-item-wrap">';
              echo '<li class="notice-num">'.$nl_num.'</li>';
              echo '<li class="notice-title"><a href="notice.php?id='.$nl_num.'">'.$nl_title.'</a></li>';
              if($nl_file == NULL){
                echo '<li class="notice-file">없음</li>';
              }else{
                echo '<li class="notice-file"><i class="fa-solid fa-paperclip"></i></li>';
              }
              echo '<li class="notice-date">'.$nl_date.'</li>';
              echo '<li class="notice-view">'.$nl_view.'</li>';
              echo '</ul>';
            }
          ?>

        <div class="pagination">
          <!-- pagination -->
          <?php
            $sql = "SELECT * FROM notice_list where learn_num = $learnID";
            $result = mysqli_query($conn, $sql);
            $total_record = mysqli_num_rows($result); // 전체 글 수
            $total_page = ceil($total_record / $scale); // 전체 페이지 수
            $current_page = $_GET['page'] ?? 1; // 현재 페이지
            if(!$current_page) $current_page = 1; // 페이지 번호가 지정이 안되었을 경우
            $block_pages = 5; // 한 화면에 표시할 페이지 수
            $block_total = ceil($total_page / $block_pages); // 전체 블록 수
            $current_block = ceil($current_page / $block_pages); // 현재 블록

            $prev_page = $current_page - 5; // <i class="fa-solid fa-chevron-left"></i> 페이지
            $next_page = $current_page + 5; // <i class="fa-solid fa-chevron-right"></i> 페이지
            if ($prev_page < 0){ // 페이지 번호가 지정이 안되었을 경우
              $prev_page = 1;
            } 
            else if ($next_page > $total_page) {// 마지막 페이지를 넘어갔을 경우
              $next_page = $total_page;
            } 

            if($current_page < 6){
              echo '<span class="prev disable"><img src="../img/prevbtn-dis.svg" alt="이전 페이지로"></span>';
            } else {
            echo '
            <a href="notice_list.php?page=' . $prev_page . '" class="prev"><img src="../img/prevbtn.svg" alt="이전 페이지로"></a>
            ';
            };
            for ($i = $current_block * $block_pages - $block_pages + 1; $i <= $current_block * $block_pages; $i++) {
              if ($i > $total_page) break;
              if ($i == $current_page) {
                echo '<a href="notice_list.php?page=' . $i . '" class="active">' . $i . '</a>';
              } else {
                echo '<a href="notice_list.php?page=' . $i . '">' . $i . '</a>';
              }
            }
            if($total_page < 6){
              echo '<span class="next disable"><img src="../img/nextbtn-dis.svg" alt="다음 페이지로"></span>';
            } else if ($current_page > $total_page - 3) {
              echo '<span class="next disable"><img src="../img/nextbtn-dis.svg" alt="다음 페이지로"></i></span>';
            } else {
            echo '
            <a href="notice_list.php?search=' . $search . '&page=' . $next_page . '" class="next"><img src="../img/nextbtn.svg" alt="다음 페이지로"></a>
            ';
            };      
          ?>
        </div>

        <?php if($userType == 1){?>
          <div class="notice-btn-wrap">
            <a href="notice_write.php" class="btn">글쓰기</a>
          </div>
        <?php } ?>


        </div>
