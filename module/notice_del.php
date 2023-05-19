<?php
include '../db/db_conn.php';
include '../db/config.php';

$id = $_POST['id'] ?? ''; // 주소창에서 받아오는 값
$id = (int)$id;

$query = "delete from notice_list where num='$id'";
$delete = mysqli_query($conn,$query);
?>

<script>
  location.href="notice_list.php";
</script>