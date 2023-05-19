<?php
$search = $_GET['search'];

$titleSQL = "SELECT learn_title FROM learn_table WHERE learn_title LIKE '%$search%'";
$result1 = mysqli_query($conn, $titleSQL);
if (!$result1) {
  $totalRow[] = null;
}

while($row1 = mysqli_fetch_array($result1)){
  $totalRow[] = array('learn_title' => $row1[0]);
}

$majorSQL = "SELECT learn_title FROM learn_table WHERE learn_major LIKE '%$search%'";
$result2 = mysqli_query($conn, $majorSQL);
if (!$result2) {
  $totalRow[] = null;
}

while($row2 = mysqli_fetch_array($result2)){
  $totalRow[] = array('learn_title' => $row2[0]);
}

$teacherSQL = "SELECT learn_title FROM learn_table WHERE teacher_name LIKE '%$search%'";
$result3 = mysqli_query($conn, $teacherSQL);
if (!$result3) {
  $totalRow[] = null;
}
while($row3 = mysqli_fetch_array($result3)){
  $totalRow[] = array('learn_title' => $row3[0]);
}

if($totalRow == null){
  $totalRow[] = null;
} else {
  $unique_arr = array_unique($totalRow, SORT_REGULAR);  
}
?>


<p>
<div class="learn_list-wrap">

<?php
  if ($unique_arr == null) {
    echo '<p class="learn_list-none">검색결과가 없습니다.</p>';
  } else {

  while ($unique_arr) {
    $tot = array_shift($unique_arr);
    $learnSQL = "SELECT * FROM learn_table WHERE learn_title = '$tot[learn_title]'";
    $learnQuery = mysqli_query($conn, $learnSQL);
    $row3 = mysqli_fetch_array($learnQuery);
    if($row3['learn_major'] == '교양과목'){
      $row3['learn_major'] = '교양과목';
    } else {  
      $row3['learn_major'] = '전공과목';
    } 

    ?>
    <div class="index-class-wrap">
      <a href="./learn.php?id=<?=$row3['learn_num']?>" title="<?=$row3['learn_title']?>">
      <img src="./img/learn_thumb/<?=$row3['learn_thumb']?>" alt="<?=$row3['learn_title']?>" class="class-thumb">
      <div class="title-wrap">
      <h3 class = "class-title">
        <?=$row3['learn_title']?>
        <img src="../img/learning/more.svg" alt="더보기" class="more_btn">
      </h3>
      <p class = "class-info">
        <span class="class-major">
          <?=$row3['learn_major']?>
        </span>
        <span>
          <?=$row3['teacher_name']?>
        </span>
        <span class ="class-date">
          <?=$row3['learn_date']?>
        </span>
      </p>
      </div>
      </a>
    </div>
  <?php } } ?>

</div>