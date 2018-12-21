<?php
session_start();
include 'ollearDB.php';

/**
유저가 회원탈퇴할때 처리하는 페이지
작성자:한짱호
**/

$user_id = $_POST['user_id'];
$reason1 = $_POST['retire_reason']; //탈퇴이유1 우리가 정해놓은 옵션 
$reason2 = $_POST['retire_reason2']; //구체적 탈퇴이유 - 직접작성

//탈퇴한 유저를 따로 정리하기 위한 테이블에 insert
$insert_sql = "insert into RETIRE_USER(user_ix,reason1,reason2) values('$user_id','$reason1','$reason2')";
mysqli_query($con,$insert_sql);

//해당 유저에 대한 정보 삭제  => 리뷰는 남겨놓음 

//USER_CODE에서 삭제 
$delete_user_code = "delete from USER_CODE where id='$user_id'";
mysqli_query($con,$delete_user_code);

//USER에서 삭제 
$delete_user = "delete from USER where id='$user_id'";
mysqli_query($con,$delete_user);

//SAMPLE_APPLY 에서 삭제 
$delete_sample = "delete from SAMPLE_APPLY where id='$user_id'";
mysqli_query($con,$delete_sample);

//SNS_COMMENT에서 삭제 
$delete_comment = "delete from SNS_COMMENT where user_ix='$user_id'";
mysqli_query($con,$delete_comment);

//SNS_GOOD 에서 삭제 
$delete_good = "delete from SNS_GOOD where user_ix='$user_id'";
mysqli_query($con,$delete_good);

session_destroy();

echo ("<script language=javascript> alert('탈퇴 완료'); document.location.href='https://www.docatdan.com/';</script>");




?>