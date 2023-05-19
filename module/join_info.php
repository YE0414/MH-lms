

<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>명지대학교 lms</title>
    <!-- 파비콘 -->
    <link rel="icon" href="./img/pavicon.ico" type="image/x-icon" sizes="16x16">
    <!-- 베이스css(리셋 포함) -->
    <link rel="stylesheet" href="../css/base.css" type="text/css">
    <!-- 헤더푸터 -->
    <link rel="stylesheet" href="../css/common.css" type="text/css" />

    <!-- 모듈 CSS -->
    <link rel="stylesheet" href="../css/user_apply.css" type="text/css" />
    <link rel="stylesheet" href="./right/css/notice.css" type="text/css" />
    <link rel="stylesheet" href="./right/css/todo.css" type="text/css" />

    <!-- 폰트어썸 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- 제이쿼리 -->
    <script src="../script/jquery.js"></script>
    <script src="../script/common.js" defer></script>

    <!-- join -->
    <link rel='stylesheet' href='./css/join.css' type='text/css'>
    <script src="../script/join_info.js" defer></script>
<body>

<?php
// PHP 모듈 
include_once '../db/db_conn.php'; // DB 연결
include_once '../db/config.php'; // 세션
include_once '../header.php'; // 헤더

$id = $_GET['id'];
$id = (int)$id;
$sql = "SELECT * FROM user_table WHERE user_num = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result); //배열값을 저장하여 하나씩 출력함

?>

<div class="module">
  <!-- 메인 -->
  <form name="회원가입" id="member_form" method="post" action="./member_update.php">
      <h2 class="j-form-h2">
        회원 정보 수정
      </h2>
  

      <!-- 회원가입 폼 -->
      <div class="j-form">
      <div class="j-form-f">
        <label class="j-form-label" for="user_id">아이디 <span class="j-form-span">*</span></label>
        <input type="text" class="j-form-input" id="user_id" maxlength="16" name="user_id" placeholder="영문, 숫자포함(6자리 이상)." value=<?=$row['user_id']?> readonly>
      </div>
      <div>
        <span id="id_check_msg" data-check="0">&nbsp;</span>
      </div>
      <div class="j-form-f">
        <label class="j-form-label" for="user_password">비밀번호 <span class="j-form-span">*</span></label>
        <input type="password" class="j-form-input" id="user_password" maxlength="16"  name="user_password" placeholder="대문자, 소문자, 숫자, 특수문자 포함(8자리 이상)." value="">
      </div>
      <div>
        <span id="pass_check_msg" data-check="0">&nbsp;</span>
      </div>
      <div class="j-form-list">
        <ul class="j-form-ul">
          <li class="j-form-li">
          비밀번호는 8~16자의 영문 대/소문자, 숫자, 특수문자(!@#$%^&*) 를 혼합해서 사용하실 수 있습니다.
          </li>
          <li class="j-form-li">
          아이디와 생일, 전화번호 등 개인정보와 관련된 숫자, 연속된 숫자, 반복된 문자 등 다른 사람이 쉽게 알아 낼 수 있는 비밀번호는 <br> 개인정보 유출의 위험이 높으므로 사용을 자제해 주시기 바랍니다.
          </li>
        </ul>
      </div>
      <div class="j-form-f">
        <label class="j-form-label" for="user_password2">비밀번호 확인 <span class="j-form-span">*</span></label>
        <input type="password" class="j-form-input" id="user_password2" maxlength="16" value="">
      </div>
      <div>
        <span id="pass_check_msg2" data-check="0">&nbsp;</span>
      </div>
      <div class="j-form-f">
        <label class="j-form-label" for="user_name">이름 <span class="j-form-span">*</span></label>
        <input type="text" class="j-form-input" readonly id="user_name" name="user_name" maxlength="16" value=<?=$row['user_name']?>>
      </div>
      &nbsp;
      <div class="j-form-f">
        <label class="j-form-label" for="user_info">학번 <span class="j-form-span">*</span></label>
        <input type="text" class="j-form-input" id="user_info" name="user_info" readonly maxlength="6" placeholder="숫자만 입력가능합니다(6자리)." value=<?=$row['user_info']?>>
      </div>
      <div>
        <span id="info_check_msg" data-check="0">&nbsp;</span>
      </div>
      <div class="j-form-f">
        <label class="j-form-label" for="user_email">이메일 <span class="j-form-span">*</span></label>
        <input type="email" class="j-form-input" id="user_email" name="user_email"  maxlength="16" placeholder="ex) abcd@domain.com" value=<?=$row['user_email']?> >
      </div>
      &nbsp;
      <div class="j-form-f">
        <label class="j-form-label" for="user_phone">연락처 <span class="j-form-span">*</span></label>
        <input type="text" class="j-form-input" id="user_phone" name="user_phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="숫자만 입력가능합니다(최대11자리)." maxlength="11" value=<?=$row['user_phone']?>>
      </div>
        <span id="phone_check_msg" data-check="0">&nbsp;</span>
      <div class="j-form-b_group">
        <button class="j-form-btn j-form-btn01" type="reset">초기화</button>
        <button class="j-form-btn j-form-btn02" type="submit" id="save_frm">수정하기</button>
      </div>
    </div>
    </form>
  </div>
</body>
</html>