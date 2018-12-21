<!-- 회원 가입에서 가입버튼 누르면 DB로 저장 by.희준 -->
<html><head></head><body>
<?php
session_start();
include("ollearDB.php");
if (mysqli_connect_errno()){
echo "연결실패<br>이유 : " . mysqli_connect_error();
}

 $umail=$_POST['umail'];
 $upw=md5($_POST['upw']);
 $upwconf=$_POST['upwconf'];
 $name=$_POST['uname'];

 $sql_ins_code = "insert into USER_CODE (email_code) values ('$umail')";
 mysqli_query($con, $sql_ins_code);

 $sql_sel_code = "select id from USER_CODE where email_code='$umail'";
 $result = mysqli_query($con, $sql_sel_code);
 $row = mysqli_fetch_array($result);
 $id = $row['id'];

 $sql = "insert into USER (id, email, password, nick_name) values('$id', '$umail','$upw','$name')";

 $sns_insert_sql = "insert into SNS_USER(profile_img,user_id,user_nick) values('','$id','$name')";
 mysqli_query($con,$sns_insert_sql);
if (mysqli_query($con, $sql)) {
    $_SESSION['user_id'] = $id;
    $_SESSION['user_nick'] = $name;
    echo "<script>alert ('가입 성공')</script>";
    header("Location: index");
} else {
?>
<script type="text/javascript">
window.history.go(-2);
</script>
<?php
}
mysqli_close($con);
?>
</body></html>
