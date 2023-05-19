<?php
include_once '../db/db_conn.php'; // DB 연결
include_once '../db/config.php'; // 세션 시작
?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#002968" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#002968" media="(prefers-color-scheme: dark)">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#002968">
    <title>명지대학교 lms</title>
    <!-- 파비콘 -->
    <link rel="icon" href="./img/pavicon.ico" type="image/x-icon" sizes="16x16">
    <!-- 베이스css(리셋 포함) -->
    <link rel="stylesheet" href="../css/base.css" type="text/css">
    <!-- 헤더푸터 -->
    <link rel="stylesheet" href="../css/common.css" type="text/css">

    <!-- 모듈 CSS -->
    <link rel="stylesheet" href="./css/login.css" type="text/css">
    <link rel="stylesheet" href="./right/css/notice.css" type="text/css">

    <!-- 폰트어썸 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- 제이쿼리 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="../script/common.js" defer></script>
    <script>
    //회원가입 입력양식에 대한 유효성감사
    $(function(){
       //저장된 쿠기값을 가져와서 id 칸에 넣어준다 없으면 공백으로 처리
        var key = getCookie("key");
        $("#user_id").val(key);


        if($("#user_id").val() !=""){               // 페이지 로딩시 입력 칸에 저장된 id가 표시된 상태라면 id저장하기를 체크 상태로 둔다
            $("#cb1").attr("checked", true); //id저장하기를 체크 상태로 둔다 (.attr()은 요소(element)의 속성(attribute)의 값을 가져오거나 속성을 추가합니다.)
        }

          $("#cb1").change(function(){ // 체크박스에 변화가 있다면,
                if($("#cb1").is(":checked")){ // ID 저장하기 체크했을 때,
                    setCookie("key", $("#user_id").val(), 2); // 하루 동안 쿠키 보관
                }else{ // ID 저장하기 체크 해제 시,
                    deleteCookie("key");
                }
          });

          // ID 저장하기를 체크한 상태에서 ID를 입력하는 경우, 이럴 때도 쿠키 저장.
          $("#user_id").keyup(function(){ // ID 입력 칸에 ID를 입력할 때,
              
              if($("#cb1").is(":checked")){ // ID 저장하기를 체크한 상태라면,
                deleteCookie("key");
                setCookie("key", $("#user_id").val(), 2); // 2일 동안 쿠키 보관
              }
          });
              //쿠키 함수 
        function setCookie(cookieName, value, exdays){
            var exdate = new Date();
            exdate.setDate(exdate.getDate() + exdays);
            var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
            document.cookie = cookieName + "=" + cookieValue;
        }

        function deleteCookie(cookieName){
            var expireDate = new Date();
            expireDate.setDate(expireDate.getDate() - 1);
            document.cookie = cookieName + "=" + "; expires=" + expireDate.toGMTString();
        }

        function getCookie(cookieName) {
            cookieName = cookieName + '=';
            var cookieData = document.cookie;
            var start = cookieData.indexOf(cookieName);
            var cookieValue = '';
            if(start != -1){
                start += cookieName.length;
                var end = cookieData.indexOf(';', start);
                if(end == -1)end = cookieData.length;
                cookieValue = cookieData.substring(start, end);
            }
            return unescape(cookieValue);
            }

    });  

  </script>
  </head>
<body>
<?php
// PHP 모듈 
include_once '../header.php'; // 헤더
include_once './right/user_btn.php'; //우측메뉴
?>
<div class="module">
<div class="login-form-div">

<form name="login" method="post" action="./login_chk.php" class="login-form-form">
        <p class="login-logo-wrap">
          <img src="./img/logo.jpeg" alt="명지대학교 로고" class="login-form-logo">
        </p>
        <h3 class="login-form-h3">통합 로그인</h3>
        <ul class="login-form-ul">
          <li class="login-form-li">
            <input type="text" name="user_id" placeholder="학번 또는 아이디 입력" maxlength="16" id="user_id" class="login-form-input" value="">
          </li>
          <li class="login-form-li">
            <input type="password" name="user_password" placeholder="패스워드 입력" maxlength="16" id="user_password" class="login-form-input">
          </li>
          <li class="login-form-li">
            <input type="checkbox" id="cb1" class="login-form-checkbox">
            <label for="cb1"></label>
            <label for="cb1" class="login-form-save">아이디 저장</label>
            <a href="#none" title="아이디 찾기" class="login-form-find">ID/PW 찾기</a>
          </li>
          <li class="login-form-li">
            <input type="submit" value="로그인" class="login-login-btn2">
            <a href="./join.php" title="회원가입 이동" class="login-login-btn1">회원가입</a>
          </li>
        </ul>
</form>
</div>
</div>
</body>
</html>