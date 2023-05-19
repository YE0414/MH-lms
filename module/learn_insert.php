<?php

// DB연결하기
include_once '../db/db_conn.php';

// 강의 삭제 쿼리
$del = $_POST['verify'] ?? '';
$learn_target = $_POST['learn_id'] ?? '';
if($del == 'no'){
  $learn_target = (int)$learn_target;

  // 외래키 규칙 삭제
  $fk1sql = "SET FOREIGN_KEY_CHECKS = 0";
  $fk1result = mysqli_query($conn, $fk1sql);

  $sql = "DELETE FROM learn_table WHERE learn_num = $learn_target";
  $sqlresult = mysqli_query($conn, $sql);

  // 외래키 규칙 복구
  $fk2sql = "SET FOREIGN_KEY_CHECKS = 1";
  $fk2result = mysqli_query($conn, $fk2sql);
  
  echo('
  <script>
    alert("강의가 삭제되었습니다.");
    location.href = "./learn_master.php";
  </script>
  ');
}

// 강의 기초
$learn_title = $_POST['learn_title'];
$teacher_name = $_POST['teacher_name'];
$learn_start = $_POST['learn_start'];
$learn_end = $_POST['learn_end'];
$learn_major = (int)$_POST['learn_major'];
$learn_limit = $_POST['learn_limit'];

// 수정 사항
$modify = $_POST['mod'] ?? '';
$id = $_POST['learn_mod_id'] ?? '';

// 강의 주차 묶기
if (isset($_POST['learn_weekly'])) {
  $learn_weekly_arr = $_POST['learn_weekly'];
  $total_learn = '';
  foreach ($learn_weekly_arr as $learn_weekly) {
      $total_learn .= $learn_weekly . ",";
  }
}
$total_learn = substr($total_learn, 0, -1);

// 강의 과제 묶기
if (isset($_POST['learn_weekly_assignment'])) {
  $learn_weekly_assignment_arr = $_POST['learn_weekly_assignment'];
  $total_assignment = '';
  foreach ($learn_weekly_assignment_arr as $learn_weekly_assignment) {
      $total_assignment .= $learn_weekly_assignment . ",";
  }
}
$total_assignment = substr($total_assignment, 0, -1);

// 강의 자료 가져와서 변수에 담기
if(isset($_FILES['learn_weekly_file'])){
  $file_data = array();
  $errors = array();

  foreach ($_FILES['learn_weekly_file']['tmp_name'] as $key => $tmp_name) {
    $file_name = $_FILES['learn_weekly_file']['name'][$key]; // file name
    $file_size = $_FILES['learn_weekly_file']['size'][$key]; // file size
    $file_tmp = $_FILES['learn_weekly_file']['tmp_name'][$key]; // file name
    $file_type = $_FILES['learn_weekly_file']['type'][$key]; //file type

    $ext = explode('.',$file_name);
    $ext = strtolower(array_pop($ext));

    if ($file_size > 2097152){
      $errors[] = "File size exceeds 2 MB.";
    }

    if(empty($errors)){
      array_push($file_data, $file_name);
      move_uploaded_file($file_tmp, "./files/learn/".$file_name);
    } else {
      print_r($errors);
      die();
    }
  }

  $learn_file = implode(",", $file_data);
  //learn_file에는 파일명이 ,로 구분되어 들어간다.
}

// 썸네일 가져와서 담기
if(isset($_FILES['learn_thumbnail'])) {
  $file_name = $_FILES['learn_thumbnail']['name']; //파일명
  $file_size = $_FILES['learn_thumbnail']['size']; //파일크기
  $file_tmp = $_FILES['learn_thumbnail']['tmp_name']; //파일명
  $file_type = $_FILES['learn_thumbnail']['type']; //파일유형

  $ext = explode('.',$file_name); 
  $ext = strtolower(array_pop($ext));
  //file.hwp -> [file] [hwp]

  $expensions = array("jpeg", "jpg", "png", null); //올라갈 파일 지정
  //SWF나 EXE같은 악성코드 배포방지
  
  if(in_array($ext, $expensions) === false){ //해당 확장자가 아니라면
    $errors[] = "올바른 이미지가 아닙니다.";
  } //경고

  if($file_size > 2097152) { //2MB이상 올라가면
    $errors[] = '파일 사이즈는 2MB 이상 초과할 수 없습니다.';
  } //경고

  if(empty($errors) == true) { //에러가 없다면
    move_uploaded_file($file_tmp, "./img/learn_thumb/".$file_name); //경로에 저장
    $files = $file_name; // 변수에 파일명을 담는다
  } else { //경고가 있다면
    print_r($errors); //경고출력
  }
} else { // 만약 이미지 업로드가 아니라면
  $files = null; //null로 반환한다.
}

// 교수 이메일 가져오기
$sql = "SELECT user_email, user_major FROM user_table WHERE user_name = '$teacher_name'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

// 교수 이메일 변수에 담기
$teacher_email = $row['user_email'];
// 교수 전공 변수에 담기
$teacher_major = $row['user_major'];

// 1이면 전공만, 2이면 교양만, 3이면 전공+교양
if($learn_major == 1){
  $result_major = $teacher_major;
} else if($learn_major == 2){
  $result_major = '교양과목';
} else {
  $result_major = $teacher_major . ', 교양과목';
}

// 강의 기간
$total_date = $learn_start . '~' . $learn_end;

// 강의 수정 쿼리
if($modify == 'modify'){

// 파일첨부 안했으면 기존값
$modify_thumb = $_POST['learn_thumb_mod'] ?? null;
if($files == null){
  $files = $modify_thumb;
}

$stmt = $conn->prepare("UPDATE learn_table SET
learn_title = ?,
learn_thumb = ?,
learn_major = ?,
learn_about = ?,
learn_date = ?,
teacher_name = ?,
teacher_email = ?,
student_total = ?,
learn_assignment = ?,
learn_file = ?
WHERE learn_num = ?");

$stmt->bind_param('sssssssissi', 
$learn_title, // 강의 제목
$files, // 썸네일
$result_major, // 전공
$total_learn, // 강의 주차
$total_date, // 강의 기간
$teacher_name, // 교수 이름
$teacher_email, // 교수 이메일
$learn_limit, // 강의 제한 인원
$total_assignment, // 과제 유무
$learn_file, // 강의 자료
$id // 강의 고유 번호
);

$stmt->execute();

// 강의결과 표시
if($stmt->affected_rows == 1){
  echo('
  <script>
    alert("강의가 수정되었습니다.");
    location.href = "./learn_master.php";
  </script>
  ');
} else {
  echo('
  <script>
    alert("강의 수정에 실패했습니다.");
    location.href = "./learn_master.php";
  </script>
  ');
}
exit;
}

// 강의 추가 전 중복 체크
$sql = "SELECT * FROM learn_table WHERE learn_title = '$learn_title'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if($row['learn_title'] == $learn_title) {
  echo('
  <script>
    alert("같은 강의가 존재합니다.");
    location.href = "./learn_add.php";
  </script>
  ');
  exit;
}

// 강의 추가 쿼리
$stmt = $conn->prepare("INSERT INTO learn_table SET
learn_title = ?,
learn_thumb = ?,
learn_major = ?,
learn_about = ?,
learn_date = ?,
teacher_name = ?,
teacher_email = ?,
student_total = ?,
learn_assignment = ?,
learn_file = ?
");

$stmt->bind_param('sssssssiss', 
$learn_title, // 강의 제목
$files, // 썸네일
$result_major, // 전공
$total_learn, // 강의 주차
$total_date, // 강의 기간
$teacher_name, // 교수 이름
$teacher_email, // 교수 이메일
$learn_limit, // 강의 제한 인원
$total_assignment, // 과제 유무
$learn_file // 강의 자료
);

$stmt->execute();

// 강의결과 표시
if($stmt->affected_rows == 1){
  echo('
  <script>
    alert("강의가 추가되었습니다.");
    location.href = "./learn_master.php";
  </script>
  ');
} else {
  echo('
  <script>
    alert("강의 추가에 실패했습니다.");
    location.href = "./learn_master.php";
  </script>
  ');
}

?>