<?php
session_start();
include('ollearDB.php');
$user_check=$_SESSION['login_user'];

$ses_sql=mysqli_query($con, "select * from USER where email='$user_check'");

$row=mysqli_fetch_array($ses_sql);

$login_session=$row['name'];

if(!isset($login_session))
{
    header("Location: signin");
}
?>
