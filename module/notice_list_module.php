    <main>
      <section>
        <h2 style="display:none">공지사항</h2>
        <div id="notice_search">
          <form action="http://na980414.dothome.co.kr/lms/module/notice_search.php" method="get">
            <input type="search" name="search"  aria-label="Search-input"/>
            <button type="submit" aria-label="Search-Submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
        </div>
        <table class="notice">
          <tr>
            <th class="notice-num">번호</th>
            <th class="notice-title">제목</th>
            <th class="notice-file">첨부</th>
            <th class="notice-date">등록일</th>
            <th class="notice-view">조회수</th>
          </tr>
          
          <!-- PHP 목록 불러오기 -->
          <?php
            $start = $_GET['page'] ?? 1; // 현재 페이지
            if(!$start) $start = 1; // 페이지 번호가 지정이 안되었을 경우
            $start = ($start - 1) * 10; // 한 페이지에 표시할 글 수
            $scale = 10; // 한 페이지에 표시할 글 수
            $sql = "SELECT * FROM notice_list where learn_num = 0 ORDER BY num DESC LIMIT $start, $scale"; // DESC 내림차순, ASC 오름차순
            $result = mysqli_query($conn, $sql); // 쿼리문 실행

            while($row = mysqli_fetch_array($result)){
              $nl_num = $row['num'];
              $nl_title = $row['notice_title'];
              $nl_file = $row['notice_file'];

              $nl_date = explode('-', $row['notice_date']);
              $nl_date = $nl_date[0].'.'.$nl_date[1].'.'.$nl_date[2];

              $nl_view = $row['notice_views'];

              echo '<tr>';
              echo '<td class="notice-num">'.$nl_num.'</td>';
              echo '<td class="notice-title"><a href="notice.php?id='.$nl_num.'">'.$nl_title.'</a></td>';
              if($nl_file == NULL){
                echo '<td class="notice-file">없음</td>';
              }else{
                echo '<td class="notice-file"><i class="fa-solid fa-paperclip"></i></td>';
              }
              echo '<td class="notice-date">'.$nl_date.'</td>';
              echo '<td class="notice-view">'.$nl_view.'</td>';
              echo '</tr>';
            }
          ?>
        </table>

        <div class="pagination">
          <!-- pagination -->
          <?php
            $sql = "SELECT * FROM notice_list";
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
              echo '<span class="prev disable"><i class="fa-solid fa-chevron-left"></i></span>';
            } else {
            echo '
            <a href="notice_list.php?page=' . $prev_page . '" class="prev"><i class="fa-solid fa-chevron-left"></i></a>
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
              echo '<span class="next disable"><i class="fa-solid fa-chevron-right"></i></span>';
            } else if ($current_page > $total_page - 3) {
              echo '<span class="next disable"><i class="fa-solid fa-chevron-right"></i></span>';
            } else {
            echo '
            <a href="notice_list.php?page=' . $next_page . '" class="next"><i class="fa-solid fa-chevron-right"></i></a>
            ';
            };
          ?>          
        </div>

        <?php if($userType == 1){?>
          <div class="notice-btn-wrap">
            <a href="notice_write.php" class="btn">글쓰기</a>
          </div>
        <?php } ?>


      </section>
    </main>