<?php
header("Access-Control-Allow-Origin: http://na980414.dothome.co.kr/");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once('../../db/db_conn.php');

//post 값이 있다면 (빈공간이 아니라면)
!empty($_POST['user_id'])?$id=$_POST['user_id']:$id='';
$ret['check']=false;

if($id!=''){ //값이 있다면 아래 내용 실행
  $sql = "select user_id from user_table where user_id = '{$id}'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result); //행의 개수 만약 id가 있어서 1개가 추출되면 1이 되고 1이면 중복

  if($num==0){ //만약에 num값이 0이면 (아이디가 일치하지 않으면)
    $ret['check']=true; //true값 넘김
  }
}

// !empty($_POST['user_info'])?$c_num=$_POST['user_info']:$c_num='';
// $ret['check']=false;

// if($c_num!=''){ //값이 있다면 아래 내용 실행
//   $con = mysqli_connect('localhost','root','','lms_sample');
//   $sql = "select user_info from user_table where user_info = '{$c_num}'";
//   $result = mysqli_query($con, $sql);
//   $num = mysqli_num_rows($result); //행의 개수 만약 id가 있어서 1개가 추출되면 1이 되고 1이면 중복

//   if($num==0){ //만약에 num값이 0이면 (아이디가 일치하지 않으면)
//     $ret['check']=true; //true값 넘김
//   }
// }
echo json_encode($ret); //json데이터로 출력하라

?>