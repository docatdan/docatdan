<?php
//샘플 신청 프로세스 페이지
//샘플에 대한 정보를 받고 디비에 저장

session_start();
include 'ollearDB.php';

$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];
$user_nick = $_SESSION['user_nick'];

$insta_id = $_COOKIE[$user_id."_insta_code"];

$sns = $_POST['sns'];
$goods_num = $_POST['goods_num'];
$company = $_POST['company'];
$detail_goods_name = $_POST['detail_goods_name'];
$address = $_POST['ship_add'];
$memo = $_POST['ship_memo'];
$sample_name = $_POST['name'];
$sample_email = $_POST['email'];
$sample_phone = $_POST['phone_number'];

$phone = $sample_phone[0]."-".$sample_phone[1]."-".$sample_phone[2];

$date = date("Y-m-d/H:i");

$sns_name_sql = "select insta_nick,naver_id from USER_CODE where id='$user_id'";
$sns_name_result = mysqli_query($con,$sns_name_sql);
$sns_name = mysqli_fetch_array($sns_name_result);

$insta_name = $sns_name['insta_nick'];
$naver_id = $sns_name['insta_nick'];


$checked = false;

//인스타 아이디를 통해 이미 신청된적이 있는지 확인하기 위한 작업

// //해당 유저의 아이디가 아닌 아이디중에 같은 인스타id를 쓰는 유저가 있는지 확인하는 쿼리
// $double_check_sql ="select id from USER_CODE where insta_code='$insta_id' and id !='$user_id'";
// $double_check_result = mysqli_query($con,$double_check_sql);

// //유저가 있다면 while문으로 해당유저가 해당상품을 신청했는지 확인
// while($double_check_row=mysqli_fetch_array($double_check_result)){
// 	$double_id = $double_check_row['id'];

// 	$apply_check_sql = "select*from SAMPLE_APPLY where id='$double_id' and goods_id='$goods_num'";
// 	$check_result = mysqli_query($con,$apply_check_sql);
// 	$result_num = mysqli_num_rows($check_result);
// 	//신청한 이력이 있으면 checkec가 true;
// 	if($result_num>0){
// 		$checked =true;

// 	}
// }

$apply_check_sql = "select*from SAMPLE_APPLY where id='$user_id' and goods_id='$goods_num'";
$check_result = mysqli_query($con,$apply_check_sql);
$result_num = mysqli_num_rows($check_result);
//신청한 이력이 있으면 checked가 true;
if($result_num>0){
	$checked =true;

}

//해당 유저가 여러 인스타id를 사용하려고 할 경우
//해당 유저가 한 인스타id로 신청한 내역이 있는지 파악한다.
//신청한 내역이 있는경우 다른 인스타id로 다른 상품또한 신청 불가능

//우선 신청한 내역이 있는지 확인 => 같은 아이디인지 확인
// $history_ch_sql = "select id from SAMPLE_APPLY where id='$user_id'";
// $history_res = mysqli_query($con,$history_ch_sql);
// $history_num = mysqli_num_rows($history_res);

// $diff_check =true; //신청한 인스타가 과거내역과 다른지 판단하는 변수
// if($history_num>0){//신청한 적이 있는경우
// 	$insta_name = $_COOKIE[$session_id.'_insta'];

// 	$diff_insta_sql = "select id from SAMPLE_APPLY where id='$user_id' and insta_name='$insta_name'";
// 	$diff_res = mysqli_query($con,$diff_insta_sql);
// 	$diff_num = mysqli_num_rows($diff_res);


// 	if($diff_num>0){  //신청하는 인스타가 그동안 신청했던 인스타와 같은 경우
// 		$diff_check = true;
// 	}else{ //신청하는 인스타가 예전 인스타와 다른경우
// 		$diff_check = false;
// 	}

// }else{ //신청한적 없는 경우

// }











if($checked){
	echo ("<script language=javascript> alert('이미 신청된 아이디 입니다.'); document.location.href='./';</script>");
}else{
	//리뷰작성 데드라인 찾는 쿼리
	$deadline_sql = "select shipdate_en from GOODS_INFO where num='$goods_num'";
	$deadline_result = mysqli_query($con,$deadline_sql);
	$deadline_row = mysqli_fetch_array($deadline_result);

	$ship_end = $deadline_row['shipdate_en'];
	$deadline_start = date("Y-m-d", strtotime($ship_end)+86400);

	if($sns=='insta'){
		$sample_sql = "insert into SAMPLE_APPLY(id,name,goods_id,company,goods_name,option,email,phone,address,memo,date,sns,insta_name,deadline) values('$user_id','$sample_name','$goods_num','$company','$detail_goods_name','','$sample_email','$phone','$address','$memo','$date','$sns','$insta_name','$deadline_start')";
		mysqli_query($con,$sample_sql);
	}else if($sns=='naver'){
		$sample_sql = "insert into SAMPLE_APPLY(id,name,goods_id,company,goods_name,option,email,phone,address,memo,date,sns,naver_id,deadline) values('$user_id','$sample_name','$goods_num','$company','$detail_goods_name','','$sample_email','$phone','$address','$memo','$date','$sns','$naver_id','$deadline_start')";
		mysqli_query($con,$sample_sql);
	}

	echo ("<script language=javascript> alert('신청이 완료되었습니다.'); document.location.href='./index';</script>");
	// if($diff_check){
	// 	$sample_sql = "insert into SAMPLE_APPLY(id,name,goods_id,company,goods_name,option,email,phone,address,date,sns,insta_name) values('$user_id','$sample_name','$goods_num','$company','$goods_name','','$sample_email','$sample_phone','$address','$date','$sns','$insta_name')";
	// 	mysqli_query($con,$sample_sql);
	// 	echo ("<script language=javascript> alert('신청이 완료되었습니다.'); document.location.href='https://heejun92.cafe24.com/';</script>");
	// }else{
	// 	echo ("<script language=javascript> alert('한 계정에 두개의 인스타 아이디를 사용할 수 없습니다.'); document.location.href='https://heejun92.cafe24.com/';</script>");
	// }

}





?>
