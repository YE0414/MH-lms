<?php
$search = $_GET['notice_search'];

$titleSQL = "SELECT notice_title FROM notice_list WHERE notice_title LIKE '%$search%'";
$result1 = mysqli_query($conn, $titleSQL);
if (!$result1) {
  $totalRow[] = null;
}

while($row1 = mysqli_fetch_array($result1)){
  $totalRow[] = array('notice_title' => $row1[0]);
}

$textSQL = "SELECT notice_title FROM notice_list WHERE notice_text LIKE '%$search%'";
$result2 = mysqli_query($conn, $textSQL);
if (!$result2) {
  $totalRow[] = null;
}

while($row2 = mysqli_fetch_array($result2)){
  $totalRow[] = array('notice_title' => $row2[0]);
}

$dateSQL = "SELECT notice_title FROM notice_list WHERE notice_date LIKE '%$search%'";
$result3 = mysqli_query($conn, $dateSQL);
if (!$result3) {
  $totalRow[] = null;
}
while($row3 = mysqli_fetch_array($result3)){
  $totalRow[] = array('notice_title' => $row3[0]);
}

if($totalRow == null){
  $totalRow[] = null;
} else {
  $unique_arr = array_unique($totalRow, SORT_REGULAR);  
}
?>
<section>
    <h2 style="display:none">공지사항</h2>
    <div id="notice_search">
          <form action="http://na980414.dothome.co.kr/lms/module/notice_search.php" method="get">
            <input type="search" name="notice_search" />
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
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

<?php
  if ($unique_arr == null) {
    echo '<p class="learn_list-none">검색결과가 없습니다.</p>';
  } else {
    while ($unique_arr) {
      $tot = array_shift($unique_arr);
      $learnSQL = "SELECT * FROM notice_list WHERE notice_title = '$tot[notice_title]'";
      $learnQuery = mysqli_query($conn, $learnSQL);
      $row3 = mysqli_fetch_array($learnQuery);
      ?>
          <?php
              $nl_num = $row3['num'];
              $nl_title = $row3['notice_title'];
              $nl_file = $row3['notice_file'];

              $nl_date = explode('-', $row3['notice_date']);
              $nl_date = $nl_date[0].'년 '.$nl_date[1].'월 '.$nl_date[2].'일';

              $nl_view = $row3['notice_views'];

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
  <?php } ?>

</div>
