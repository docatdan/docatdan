<?php
include 'ollearDB.php';


// $apply = "20181017/17:00/3";

// $apply_arr = explode("/", $apply); //"/"를 기준으로 시작날과 시작시간 남은시간을 나는다
// $today = date("Ymd");
// $date = date("H:i:s");
// $time = $apply_arr[2]*3600; //시간을 초로변환
// $compare_date_time = (strtotime($apply_arr[1]) - strtotime($date)); //시작시간과 현재시간을 비교 => 초로 표시
// $date_seconds = ($apply_arr[0]-$today)*3600*24;  //시작 기준일과 현재 날짜를 비교해서 초로 환산
// $init = ($time+$compare_date_time+$date_seconds);	//현재를 기준으로 남은시간 초로 표시(설정한 시간 - 경과시간)
// if($init<=0){//남은시간이 없는 경우 팔지않는 품목으로 전환   init 이 음수면 무조건 마감된 상품 양수일때 시간이 남은건지 시작을 하지 않은건지 판단이 필요 
// 	$not_sale = true;
// }
// $hours = floor($init / 3600);
// $minutes = floor(($init / 60) % 60);
// $seconds = $init % 60; //남은시간을 시:분:초로 표시
// $real_apply = $hours.":".$minutes.":".$seconds;

// $apply_num_sql = "select id from SAMPLE_APPLY where goods_id='$goods_num'"; //샘플 신청자 수 받아오는 쿼리
// $apply_res = mysqli_query($con,$apply_num_sql);
// $apply_number = mysqli_num_rows($apply_res);

// $aa = $apply_arr[0] - $today;


// echo $aa."/";
// echo $compare_date_time."/";
// echo $init;

// $aa = $apply_arr[0] - $today;
// if($init<=0){ //마감
	

// }else{
// 	if($aa==0){ //오늘 시작햇거나 시작할 예정
// 		if($compare_date_time<=0){ //시작햇음

// 		}else{//시작할 예정

// 		}
// 	}else if($aa>0){ //시작할 예정

// 	}
// }


// $img_link ="https://www.instagram.com/p/BpEkzxgAQRi/?utm_source=ig_web_copy_link";
// $data = file_get_contents($img_link,0);

// $get_img_count  = substr_count($data, "display_url"); //이미지 수 +1
// $img_count = $get_img_count;
// if($get_img_count>1){
// 	$img_count = $get_img_count - 1; //해당링크의 이미지 개수
// }
// $img_div1 = explode("display_url", $data);  //display_url을 기준으로 이미지구획을 나눈다.(첫번째)

// $real_text = rtrim($img_text); //받아온 텍스트에서 뒤쪽 공백을 제거한다. 

// $tag_array = explode(" ",$img_tag);
// $size = sizeof($tag_array); //태그 사이즈 
// $total_tag = "";


// for($i=0; $i<$size; $i++){
// 	$total_tag = $total_tag."#".$tag_array[$i]." ";
// }
// if($img_tag==""){ //넘어오는 태그가없으면 태그를 ""로 만든다 .
// 	$total_tag= "";
// }

// for($i=0; $i<$img_count; $i++){
// 	if($get_img_count>1){
// 		$img_1 = $img_div1[$i+2]; //이미지별 구역 
// 	}else{
// 		$img_1 = $img_div1[$i+1];  //이미지별 구역 
// 	}
	
// 	//$feed_ix = generateRandomString(15);

// 	//구역에서 이미지 링크를 가져오기 위한 추가 작업 
// 	$img_2 = explode("src\":\"", $img_1); //src를 기준으로 나눈다. 
// 	$img_3 = explode("\",\"", $img_2[1]); //"," 를 기준으로 나눔 

// 	$img_src = $img_3[0]; //이미지 링크

	
// }

// $aa = explode("“", $data);

// //echo $aa[1];

// $bb = explode("”", $aa[1]);

// //echo $bb[0];

// $cc = explode("#", $bb[0]);

// echo $data;

$deadline_sql = "select shipdate_en from GOODS_INFO where num='158'";
$deadline_result = mysqli_query($con,$deadline_sql);
$deadline_row = mysqli_fetch_array($deadline_result);

$ship_end = $deadline_row['shipdate_en'];
echo $ship_end;
$deadline_start = date("Y-m-d", strtotime($ship_end)+86400);

	
	$sample_sql = "insert into SAMPLE_APPLY(deadline) values('$deadline_start')";
	mysqli_query($con,$sample_sql);
	
?>