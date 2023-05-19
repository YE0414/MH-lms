<?php
include '../db/db_conn.php';
include '../db/config.php';

$id = $_GET['id']; // 주소창에서 받아오는 값
$id = (int)$id;
$id = mysqli_real_escape_string($conn, $id); // SQL 인젝션 방지용
?>

<form action="notice_del.php" method="post">
  <input type="hidden" name="id" value="<?=$id?>">
  <table>
    <tr>
      <th>
        <?=$id?>번 게시물을 삭제하시겠습니까?
      </th>
    </tr>
    <tr>
      <td>
        <input type="submit" value="글삭제">
      </td>
    </tr>
  </table>