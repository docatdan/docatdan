<?php
/**
유저가 협찬신청한 제품에 대해서 아직 진행중이거나 선정중인 상태에서 
협찬을 취소했을때 동작하는 페이지

작성자 : 짱호

**/

include 'ollearDB.php';


$goods_id = $_POST['goods_id'];
$user_id = $_POST['user_id'];

//샘플신청 취소 쿼리 
$cancel_sql = "delete from SAMPLE_APPLY where goods_id='$goods_id' and id='$user_id'";
if(mysqli_query($con,$cancel_sql)){
	echo json_encode('suc');
}else{
	echo json_encode('fail');
}







?>