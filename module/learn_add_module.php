<?php

if($userType == 0){
  echo '<script>alert("관리자만 접근 가능합니다."); location.href = "../index.php";</script>';
  exit;
}

$mod = $_GET['mode'] ?? '';
if($mod == 'modify'){
  $id = $_GET['id'] ?? '';
  $sql = "SELECT * FROM learn_table where learn_num = $id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $learn_title = $row['learn_title'];
  $learn_thumb = $row['learn_thumb'];
  $learn_major = $row['learn_major'];
  $learn_about = $row['learn_about'];
  $learn_date = $row['learn_date'];
  $learn_name = $row['teacher_name'];
  $learn_email = $row['teacher_email'];
  $learn_limit = $row['student_total'];

  // 강의 주차
  $learn_about = explode(',', $learn_about);

  // 강의 기간
  $learn_date = explode('~', $learn_date);
  $learn_start = $learn_date[0];
  $learn_end = $learn_date[1];

} else {
  $learn_title = '';
  $learn_thumb = '';
  $learn_major = '';
  $learn_about = '';
  $learn_date = '';
  $learn_name = '';
  $learn_email = '';
  $learn_limit = '';
  $learn_start = '';
  $learn_end = '';
}

$sql = "SELECT * FROM user_table where user_type = 2";
$result = mysqli_query($conn, $sql);
?>

<form action="./learn_insert.php" method="post" enctype="multipart/form-data">

<?php if($mod == 'modify'){ ?>
  <input type="hidden" name="mod" value="modify">
  <input type="hidden" name="learn_mod_id" value="<?=$id?>">
<?php }?>


<p>
  <label for="learn_title">강의명</label>
  <input type="text" name="learn_title" id="learn_title" placeholder="강의명" value="<?=$learn_title?>">
</p>

<p>
  <span>강의 썸네일</span>
  <?php if($mod == 'modify'){
    echo '<input type="hidden" name="learn_thumb_mod" value="'.$learn_thumb.'">';
  }?>
  <input type="file" name="learn_thumbnail" id="learn_thumbnail">
  <label for="learn_thumbnail">파일 추가</label>
</p>

<p>
  <label for="teacher_name"></label>
  <select name="teacher_name" id="teacher_name">
  <option value="">--- 담당교수 ---</option>

  <!-- 교수이름 출력 -->
  <?php

  ### SQL결과 변수인 $result를 while문으로 돌려서 $teacher에 담는다. ###
  ### $teacher['user_name']은 user_table의 user_name 컬럼을 의미한다. ###
  while($teacher = mysqli_fetch_array($result)){

    if ($learn_name == $teacher['user_name']) {
      echo '<option value="'.$teacher['user_name'].'" selected>'.$teacher['user_name']. '(' . $teacher['user_major'] . ')</option>';
    } else {
      echo '<option value="'.$teacher['user_name'].'">'.$teacher['user_name']. '(' . $teacher['user_major'] . ')</option>';
    }
  }
  ?>
  </select>
</p>
<p>
  <label for="learn_start">강의 시작일</label>
  <input type="date" name="learn_start" id="learn_start" value="<?=$learn_start?>">
  <span>~</span>
  <label for="learn_end">강의 종료일</label>
  <input type="date" name="learn_end" value="<?=$learn_end?>" id="learn_end">
</p>
<p>
  <span>전공 선택</span>
  <input type="radio" name="learn_major" id="major1" value="1">
  <label for="major1">전공 전용</label>
  <input type="radio" name="learn_major" id="major2" value="2">
  <label for="major2">교양 전용</label>
  <input type="radio" name="learn_major" id="major3" value="3">
  <label for="major3">전공 &middot; 교양</label>
</p>

<p>
  <label for="learn_limit">강의정원</label>
  <input type="number" name="learn_limit" id="learn_limit" placeholder="강의정원" value="<?=$learn_limit?>">
</p>

<p>
  강의내용 입력 
</p>

<!-- 강의 주차별 -->

<div class="learn-weekly-btn_wrap">
  <button type="button" class="btn week_plus">주차 더하기</button>
  <button type="button" class="btn week_del">마지막 주차 삭제</button>
</div>

<ul class="learn_weekly-wrap">
  <li>
    <?php
    if(!$mod){
    ?>
    <label for="learn_weekly0" class="learn_weekly-title">1주차</label>
    <textarea name="learn_weekly[0]]" id="learn_weekly0" cols="30" rows="10" class="learn_weekly" placeholder="1주차"></textarea>
    <textarea name="learn_weekly_assignment[0]" id="learn_weekly_assignment0" cols="30" rows="10" class="learn_weekly" placeholder="1주차 과제명"></textarea>
    <input type="file" name="learn_weekly_file[0]" id="learn_weekly_file0">

    <?php } else { 
      foreach($learn_about as $key => $value){
        echo '<label for="learn_weekly'.$key.'" class="learn_weekly-title">'.($key+1).'주차</label>';
        echo '<textarea name="learn_weekly['.$key.']" id="learn_weekly'.$key.'" cols="30" rows="10" class="learn_weekly" placeholder="'.($key+1).'주차">'.$value.'</textarea>';
        echo '<textarea name="learn_weekly_assignment['.$key.']" id="learn_weekly_assignment'.$key.'" cols="30" rows="10" class="learn_weekly" placeholder="'.($key+1).'주차 과제명">'.$key.'</textarea>';
        echo '<input type="file" name="learn_weekly_file['.$key.']" id="learn_weekly_file'.$key.'">';
      }
    }
    ?>  
      </li>
</ul>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
  $('.week_plus').click(function(){
    let week = $('.learn_weekly-wrap li').length + 1;
    let html = '<li><label for="learn_weekly'+week+'" class="learn_weekly-title">'+week+'주차</label><textarea name="learn_weekly['+week+']" id="learn_weekly'+week+'" cols="30" rows="10" class="learn_weekly" placeholder="'+week+'주차"></textarea><textarea name="learn_weekly_assignment[' + week + ']" id="learn_weekly_assignment' + week + '" cols="30" rows="10" class="learn_weekly" placeholder="'+week+'주차 과제명"></textarea><input type="file" name="learn_weekly_file[' + week + ']" id="learn_weekly_file' + week + '"></li>';
    $('.learn_weekly-wrap').append(html);
  });

  $('.week_del').click(function(){
    if($('.learn_weekly-wrap li').length == 1){
      return false;
    }
    $('.learn_weekly-wrap li:last-child').remove();
  });
});
</script>

<p class="learn_add-btn_wrap">
  <input type="reset" value="다시 작성하기" class="btn btn-reset">
  <input type="submit" value="강의 추가" class="btn btn-apply">
</p>

</form>