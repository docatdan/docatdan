<?php 
 
 define('HOST','localhost');
 define('USER','jangho');
 define('PASS','wkdgh4232');
 define('DB','ollear');
 
 $con = mysqli_connect(HOST,USER,PASS,DB) or die('unable to connect to db'); 

 if (mysqli_connect_errno()) {
	echo "연결실패<br>이유 : " . mysqli_connect_error();
}

$user_id = $_SESSION['user_id'];
$user_nick = $_SESSION['user_nick'];
$user_email = $_SESSION['user_email'];
$admin_lv = $_SESSION['level'];

 ?>

