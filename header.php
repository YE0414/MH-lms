<?php
// 세션 감지 및 유저정보 호출
if(isset($_SESSION['lms_logon'])){
$mySession = $_SESSION['lms_logon'] ?? '';
$userSQL = "SELECT * FROM user_table WHERE user_id = '$mySession'";
$userQuery = mysqli_query($conn, $userSQL);
$userRow = mysqli_fetch_array($userQuery);
} else {
  $userRow['user_type'] = 0;
}

// 관리자인지 아닌지 관리자면 userType 1, 아니면 0
if($userRow['user_type'] == 3){
  $userType = 1 ;
} else {
  $userType = 0 ;
}

?>

    <header>
      <!-- 상단헤더 -->
      <h1>
        <a href="http://na980414.dothome.co.kr/lms/index.php" title="메인페이지로">
          <img src="http://na980414.dothome.co.kr/lms/img/logo.svg" alt="헤더 로고">
        </a>
      </h1>
      <div id="h_wrap">
        <a href="#;" title="알림"><i class="fa-solid fa-bell"></i></a>
        <?php 
        if(isset($_SESSION['lms_logon'])){
          echo "<a href='#;' title='나의 일정'><i class='fa-solid fa-calendar'></i></a>";
          echo "<a href='http://na980414.dothome.co.kr/lms/module/logout.php' title='로그아웃'><i class='fa-solid fa-sign-out'></i></a>";}
        else{
          echo "<a href='http://na980414.dothome.co.kr/lms/module/login.php' title='로그인'><i class='fa-solid fa-sign-in'></i></a>";
        }
        ?>
      </div>
      <div id="h_wrap-mobile">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <!-- 사이드 -->
      <div id="h_side">
        <div id="profile">
          <?php
            if(isset($_SESSION['lms_logon'])){ // 로그인이 되어있으면
              echo "<img src='http://na980414.dothome.co.kr/lms/img/profile.png' alt='프로필이미지' />";
            }
            else{ // 비회원일 경우 출력
              echo "";
            }
          ?>
          <div>
            <?php
              if(isset($_SESSION['lms_logon'])){ // 로그인이 되어있으면
                echo "<p>".$userRow['user_major']."</p>";
                echo "<p>".$userRow['user_name']."</p>"; 
              } else{ // 비회원일 경우 출력
                echo "<p>비회원입니다 <br> 로그인 후 이용해주세요</p>";
              }
            ?>
          </div>
              <!-- 모바일 로그아웃 버튼 -->
            <div class="h_side-logout">
                <?php if(isset($_SESSION['lms_logon'])){ // 로그인이 되어있으면
                echo "<a href='http://na980414.dothome.co.kr/lms/module/logout.php' title='로그아웃' class='h_side-logout-btn'>로그아웃</a>";
                echo "<a href='http://na980414.dothome.co.kr/lms/module/join_info.php?id=".$userRow['user_num']."' title='정보수정' class='h_side-info-btn'>정보수정</a>";
                } else{ // 비회원일 경우 출력
                echo "<a href='http://na980414.dothome.co.kr/lms/module/login.php' title='로그인' class='h_side-logout-btn'>로그인</a>";
                }?>
            </div>

        </div>
        <div id="search">
          <form action="http://na980414.dothome.co.kr/lms/module/search.php" method="get">
            <input type="search" name="search" aria-labelledby="search">
            <button type="submit" aria-label="search"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
        </div>
        <nav>
          
        <?php
          if($userType == 0){ // 비회원, 회원
        ?>

          <ul id="gnb">
            <li>
              <div>
                <span>마이페이지</span> <i class="fa-solid fa-chevron-down"></i>
              </div>
              <ul class="lnb">
                <li><a href="#" title="증명서 발급">증명서 발급</a></li>
                <li><a href="#" title="학교필수서식">학교필수서식</a></li>
                <li><a href="#" title="성적확인">성적확인</a></li>
                <li><a href="#" title="장학금 신청">장학금 신청</a></li>
                <li><a href="#" title="자격증 안내">자격증 안내</a></li>
              </ul>
            </li>
            <li>
              <div>
                <span>나의 강의</span> <i class="fa-solid fa-chevron-down"></i>
              </div>
              <ul class="lnb">
                <li><a href="http://na980414.dothome.co.kr/lms/module/user_apply.php" title="수강신청">수강신청</a></li>
                <li><a href="#" title="수강강좌 조회">수강강좌 조회</a></li>
                <li><a href="#" title="성적관리">과거강좌 조회</a></li>
                <li>
                  <a href="#" title="졸업학력평가(4학년)"
                    >졸업학력평가(4학년)</a
                  >
                </li>
              </ul>
            </li>
            <li>
              <div>
                <span>학사일정</span> <i class="fa-solid fa-chevron-down"></i>
              </div>
              <ul class="lnb">
                <li><a href="#" title="학사일정">학사일정</a></li>
                <li><a href="http://na980414.dothome.co.kr/lms/module/notice_list.php" title="공지사항">공지사항</a></li>
                <li><a href="#" title="학교행사일정">학교행사일정</a></li>
              </ul>
            </li>
            <li>
              <div>
                <span>학교행정</span> <i class="fa-solid fa-chevron-down"></i>
              </div>
              <ul class="lnb">
                <li><a href="#" title="LMS 안내사항">LMS 안내사항</a></li>
                <li><a href="http://na980414.dothome.co.kr/lms/module/notice_list.php" title="공지사항">공지사항</a></li>
                <li><a href="#" title="명지대 뉴스레터">명지대 뉴스레터</a></li>
                <li><a href="#" title="행정부서">행정부서</a></li>
                <li>
                  <a href="#" title="대학생활 길라잡이">대학생활 길라잡이</a>
                </li>
                <li><a href="#" title="QnA">QnA</a></li>
              </ul>
            </li>
          </ul>
        <?php } else { // 관리자?> 
          <ul id="gnb">
            <li>
              <div>
                <span>계정관리</span> <i class="fa-solid fa-chevron-down"></i>
              </div>
              <ul class="lnb">
                <li><a href="http://na980414.dothome.co.kr/lms/module/master.php" title="학생관리">학생관리</a></li>
                <li><a href="#" title="교직원관리">교직원관리</a></li>
                <li><a href="#" title="자격증처리">자격증처리</a></li>
              </ul>
            </li>
            <li>
              <div>
                <span>강의관리</span> <i class="fa-solid fa-chevron-down"></i>
              </div>
              <ul class="lnb">
                <li><a href="http://na980414.dothome.co.kr/lms/module/master_apply.php" title="수강신청관리">수강신청관리</a></li>
                <li><a href="http://na980414.dothome.co.kr/lms/module/learn_master.php" title="강의관리">강의관리</a></li>
                <li><a href="#" title="성적관리">성적관리</a></li>
                <li><a href="#" title="졸업관리">졸업관리</a></li>
              </ul>
            </li>
            <li>
              <div>
                <span>학사관리</span> <i class="fa-solid fa-chevron-down"></i>
              </div>
              <ul class="lnb">
                <li><a href="#" title="수업일정관리">수업일정관리</a></li>
                <li><a href="#" title="학사일정관리">학사일정관리</a></li>
                <li><a href="#" title="학교행사관리">학교행사관리</a></li>
              </ul>
            </li>
            <li>
              <div>
                <span>행정관리</span> <i class="fa-solid fa-chevron-down"></i>
              </div>
              <ul class="lnb">
                <li><a href="#" title="LMS 안내사항">LMS 안내사항</a></li>
                <li><a href="http://na980414.dothome.co.kr/lms/module/notice_write.php" title="공지사항 작성">공지사항 작성</a></li>
                <li><a href="#" title="명지대 뉴스레터">명지대 뉴스레터</a></li>
                <li><a href="#" title="행정부서">행정부서</a></li>
                <li>
                  <a href="#" title="대학생활 길라잡이">대학생활 길라잡이</a>
                </li>
                <li><a href="#" title="QnA">QnA</a></li>
              </ul>
            </li>
          </ul>
        <?php }?>
        </nav>
        <div id="h_footer">
          <ul>
            <li>
              <a href="http://na980414.dothome.co.kr/lms/module/notice_list.php" title="공지사항"
                ><span>공지사항</span><i class="fa-solid fa-chevron-right"></i
              ></a>
            </li>
            <li>
                <a href="http://na980414.dothome.co.kr/lms/module/files/MJ_LMS_매뉴얼.pdf" target="_blank"
                ><span>LMS 이용 매뉴얼</span
                ><i class="fa-solid fa-chevron-right"></i
              ></a>
            </li>
          </ul>
          <address>
            Copyright(C) MYONGJI UNIVERSITY.<br>
            All rights reserved.
          </address>
        </div>
      </div>

      <!-- 모바일 푸터 메뉴영역 -->
      <div class="mobile-footer">
          <div class="my-class">

          <?php if(isset($_SESSION['lms_logon'])){ // 로그인이 되어있으면
                echo 
                "
                <a href ='http://na980414.dothome.co.kr/lms/module/user_apply.php' title='수강신청'>
                "
                ;
                } else{ 
                // 비회원일 경우 로그인으로
                echo "
                <script>
                function clickB(){
                  alert('로그인이 필요한 서비스입니다.')
                }
                </script>
                <a href ='http://na980414.dothome.co.kr/lms/module/login.php' onclick=clickB(); title='로그인'>         
                ";
                }?>
                <img src='http://na980414.dothome.co.kr/lms/img/icon1.svg' alt='수강 신청'>
                <span>수강 신청</span>
            </a>
          </div>
          <div class="my-info">
            <a href="#">
              <img src="http://na980414.dothome.co.kr/lms/img/icon2.svg" alt="나의 일정">
              <span>나의 일정</span>
            </a>
          </div>
          <div class="notice">
            <a href="http://na980414.dothome.co.kr/lms/module/notice_list.php">
              <img src="http://na980414.dothome.co.kr/lms/img/icon3.svg" alt="공지사항">
              <span>공지사항</span>
            </a>
          </div>
          <div class="alarm">
            <a href="#">
              <img src="http://na980414.dothome.co.kr/lms/img/icon4.svg" alt="알림">
              <span>알림</span>
            </a>
          </div>
      </div>
    </header>

