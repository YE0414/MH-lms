<?php

include_once('../db/db_conn.php');
include_once('../db/config.php');

if(isset($_SESSION['lms_logon'])) {
    session_destroy();
    echo('
    <script>
      alert("로그아웃 되었습니다.");
      location.href = "../index.php";
    </script>
    '
    );
}


  if (!isset($_SESSION['lms_logon'])){
    echo('
    <script>
      alert("잘못된 접근입니다.");
      location.href = "../index.php";
    </script>
    ');
  } 

  ?>