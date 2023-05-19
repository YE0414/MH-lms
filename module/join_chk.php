<?php
include_once '../db/db_conn.php'; // DB 연결

$user_id = $_GET["user_id"];
$sql = "select * from member where id='".$user_id."'";
$member = mysqli_fetch_array();
if($memeber==0)
{
  ?>
  <?php echo("
  <script>
  $('#id_check_msg').html('<?php echo $user_id; ?>는 사용가능한 아이디입니다.').css('color','blue')
}else{
  $('#id_check_msg').html('<?php echo $user_id; ?>는 이미 존재하는 아이디입니다.').css('color','#f00');
</script>");
?>
<?php }?>
