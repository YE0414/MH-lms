<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../db/db_conn.php';
include '../db/config.php';

$mod = $_POST['id'] ?? '';
$num = $_POST['num'] ?? '';
$prev_file = $_POST['prev_file'] ?? '';
$notice_title=$_POST['notice_title'] ?? '';
$notice_text=$_POST['notice_text'] ?? '';
$notice_date = date('Y-m-d') ?? '';
$learn_num = $_POST['learn_title'] ?? 0;
$notice_cate = $_POST['notice_cate'] ?? 0;


// 1. 파일업로드 부터 확인한다.
if(isset($_FILES['notice_file'])) {
  $file_name = $_FILES['notice_file']['name']; //파일명
  $file_size = $_FILES['notice_file']['size']; //파일크기
  $file_tmp = $_FILES['notice_file']['tmp_name']; //파일명
  $file_type = $_FILES['notice_file']['type']; //파일유형

  $ext = explode('.',$file_name); 
  $ext = strtolower(array_pop($ext));
  //file.hwp -> [file] [hwp]

  $expensions = array("jpeg", "jpg", "png", "pdf", "hwp", "docx", "pptx", "ppt", "txt", null); //올라갈 파일 지정
  //SWF나 EXE같은 악성코드 배포방지
  
  if(in_array($ext, $expensions) === false){ //해당 확장자가 아니라면
    $errors[] = "올바른 확장자가 아닙니다.";
  } //경고

  if($file_size > 2097152) { //2MB이상 올라가면
    $errors[] = '파일 사이즈는 2MB 이상 초과할 수 없습니다.';
  } //경고

  if(empty($errors) == true) { //에러가 없다면
    move_uploaded_file($file_tmp, "./files/".$file_name); //경로에 저장
    $files = $file_name; // 변수에 파일명을 담는다
  } else { //경고가 있다면
    print_r($errors); //경고출력
  }
} else { // 만약 이미지 업로드가 아니라면
  $files = null; //null로 반환한다.
}

if($mod == 'mod'){
  if($files == null){
    $files = $prev_file;
  }
  $update_sql = "update notice_list set notice_title='$notice_title', notice_text='$notice_text', notice_file='$files', notice_date='$notice_date', learn_num='$learn_num', notice_detail='$notice_cate' where num=$num";
  $result = mysqli_query($conn, $update_sql); // sql에 저장된 명령 실행
} else {
  $sql = "insert into notice_list set notice_title='$notice_title', notice_text='$notice_text', notice_file='$files', notice_date='$notice_date', learn_num='$learn_num', notice_detail='$notice_cate'";
  $result = mysqli_query($conn, $sql); // sql에 저장된 명령 실행  
}


if(!$result){
  echo "<script>alert('글쓰기에 실패했습니다.');</script>";
  echo "<script>location.href='./notice_list.php';</script>";
  exit;
} else {
  echo "<script>alert('글쓰기에 성공했습니다.');</script>";
  echo "<script>location.href='./notice_list.php';</script>";
  exit;
}
?>
