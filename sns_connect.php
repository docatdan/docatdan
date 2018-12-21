<?php
/**
인스타 연동을 받기 전에 임시로 유저가 등록한 인스타계정을 등록하고 해당 팔로우수를 가져오는 페이지 
작성자 : 한장호

**/
session_start();
include 'ollearDB.php';


$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];
$user_name = $_SESSION['user_name'];

$mode = $_POST['mode'];
$sns = $_POST['sns'];

if($sns=='insta'){
	if($mode=='connect'){
		$nick = $_POST['nick'];
		$nick = trim($nick);

		//넘어온 닉네임이 공백인지 확인
		if($nick==''){
			$result_arr = new stdClass();
			$result_arr->state = 0; //아이디가 맞지 않는 경우			
			$array[] = $result_arr;
			unset($result_arr);
			
			echo json_encode($array);

		//해당 닉네임이 다른 유저의 닉네임인지 or 이미 사용하고 있는 닉네임인지
		}else{
			$check_same_nick_sql ="select id from USER_CODE where insta_nick='$nick' and id!='$user_id'";
			$check_same_nick_result = mysqli_query($con,$check_same_nick_sql);
			$same_nick_num = mysqli_num_rows($check_same_nick_result);

			//해당 닉네임을 사용하는 유저가 있는 경우
			if($same_nick_num>0){
				$result_arr = new stdClass();
				$result_arr->state = 2; //해당 닉네임을 이미 사용하고 있음
				$array[] = $result_arr;
				unset($result_arr);
				echo json_encode($array);


			//해당 닉네임을 사용하는 유저가 없는 경우
			}else{
				//해당 유저가 등록한 인스타가 있는지 확인
				$check_my_nick_sql = "select insta_nick from USER_CODE where id='$user_id'";
				$check_my_nick_reuslt = mysqli_query($con,$check_my_nick_sql);
				$check_my_nick_row = mysqli_fetch_array($check_my_nick_reuslt);
				$check_nick = $check_my_nick_row['insta_nick'];

				//해당 유저가 등록한 인스타가 있는 경우
				if($check_nick!=$nick && $check_nick!=""){
					$result_arr = new stdClass();
					$result_arr->state = 3; //이미 등록한 아이디가 있음
					$result_arr->nick = $check_nick;
					$array[] = $result_arr;
					unset($result_arr);
					echo json_encode($array);

				}else{
					$data = file_get_contents("https://www.instagram.com/".$nick."/",0);
					$filter_1 = explode("edge_followed_by\":{\"count\":",$data);
					$filter_2 = explode("}", $filter_1[1]);

					$follow_num =  $filter_2[0]; //유저의 팔로우 수


					$profile_filter1 = explode("profile_pic_url\":\"", $data);

					$profile_filter2 = explode("\",\"", $profile_filter1[1]);
					$profile_url = $profile_filter2[0]; //유저의 프로필 이미지

					if($follow_num>0){ //아이디가 없는 아이디일경우 대비
						// setcookie($user_id."_insta",$nick,time()+1000000); //연동 확인 쿠키
						// setcookie($user_id."_insta_followers",$follow_num,time()+1000000); //인스타그램 팔로워 수 쿠키
						// //setcookie($user_id."_insta_code",$insta_id,time()+1000000);
						// if($follow_num>=100){
						// 	setcookie($user_id."_insta_ok","ok",time()+1000000);
						// }else{
						// 	setcookie($user_id."_insta_ok","no",time()+1000000);
						// }

						$update_insta_sql = "update USER_CODE set insta_nick='$nick',insta_state='1',insta_follow='$follow_num' where id='$user_id'";
						mysqli_query($con,$update_insta_sql);

						$update_profile_img_sql = "update SNS_USER set profile_img='$profile_url' where user_id='$user_id'";
						mysqli_query($con,$update_profile_img_sql);



						$result_arr = new stdClass();
						$result_arr->state = 1;  //ok 
						$result_arr->nick = $nick;
						$result_arr->follow_num = $follow_num;
						$array[] = $result_arr;
						unset($result_arr);
						

						echo json_encode($array);

					}else{
						$result_arr = new stdClass();
						$result_arr->state = 0; //아이디가 맞지 않는 경우
						
						$array[] = $result_arr;
						unset($result_arr);
						
						echo json_encode($array);
					}
				}
			}
		}

		

	}else if($mode=='insta_logout'){
		// setcookie($user_id."_insta","",time()-3600);
		// setcookie($user_id."_insta_follows",$follows,time()-3600);
		// setcookie($user_id."_insta_followers",$followers,time()-3600);
		// //setcookie($user_id."_insta_code",$insta_id,time()-3600);
		// setcookie($user_id."_insta_ok","",time()-3600);

		$disconnect_sql = "update USER_CODE set insta_state='0' where id='$user_id'";
		mysqli_query($con,$disconnect_sql);
	}
//인스타 컨넥션 끝 

//네이버 컨넥션 시작 

}else if($sns=='naver'){
	if($mode=='connect'){
		$n_id = $_POST['naver_id'];



		//해당 아이디가 다른 유저의 아이디인지 or 이미 사용하고 있는 아이디인지
		$check_same_id_sql ="select id from USER_CODE where naver_id='$n_id' and id!='$user_id'";
		$check_same_id_result = mysqli_query($con,$check_same_id_sql);
		$same_id_num = mysqli_num_rows($check_same_id_result);

		//해당 아이디를 사용하는 유저가 있는 경우
		if($same_id_num>0){
			$result_arr = new stdClass();
			$result_arr->state = 2; //해당 아이디 이미 사용하고 있음
			$array[] = $result_arr;
			unset($result_arr);
			echo json_encode($array);


		//해당 닉네임을 사용하는 유저가 없는 경우
		}else{

			//해당 유저가 등록한 아이디가 있는지 확인
			$check_my_id_sql = "select naver_id from USER_CODE where id='$user_id'";
			$check_my_id_reuslt = mysqli_query($con,$check_my_id_sql);
			$check_my_id_row = mysqli_fetch_array($check_my_id_reuslt);
			$check_id = $check_my_id_row['naver_id'];

			if($check_id!=$n_id && $check_id!=""){
				$result_arr = new stdClass();
				$result_arr->state = 3; //이미 등록한 아이디가 있음
				$result_arr->id = $check_id;
				$array[] = $result_arr;
				unset($result_arr);
				echo json_encode($array);
			}else{
				$url = "http://blog.naver.com/NVisitorgp4Ajax.nhn?blogId=".$n_id;

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, $is_post);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$response = curl_exec ($ch);  //검색된 쇼핑몰 페이지
				curl_close ($ch);

				//존재 하는 아디인지 확인
				if(strpos($response,'error_content')){
					$result_arr = new stdClass();
					$result_arr->state = 0; //아이디가 맞지 않는 경우
					
					$array[] = $result_arr;
					unset($result_arr);
					
					echo json_encode($array);

				}else{
					
					$total = 0;

					//최근 4일동안 접속자수를 받아온다.
					for($i=1; $i<5; $i++){
						$filter1 = explode("cnt=\"", $response);
						$filter2 = explode("\"", $filter1[$i]);


						$total += $filter2[0];
					}
					//접속자수를 전부 더해 평균낸다.
					$average = $total/4;

					// setcookie($user_id."_naver",$n_id,time()+1000000); //연동 확인 쿠키
					// setcookie($user_id."_naver_avr",$average,time()+1000000); //인스타그램 팔로워수 쿠키

					// if($average>10){
					// 	setcookie($user_id."_naver_ok","ok",time()+1000000);
					// }else{
					// 	setcookie($user_id."_naver_ok","no",time()+1000000);
					// }

					$update_naver_sql = "update USER_CODE set naver_id='$n_id',naver_state='1',naver_visit='$average' where id='$user_id'";
					mysqli_query($con,$update_naver_sql);


					$result_arr = new stdClass();
					$result_arr->average = $average; //해당 닉네임을 이미 사용하고 있음
					$result_arr->id = $n_id;
					$result_arr->state =1;
					$array[] = $result_arr;
					unset($result_arr);
					echo json_encode($array);
				}

				//echo $response;

				
			}

		}

	
	}else if($mode=='naver_logout'){
		// setcookie($user_id."_naver","",time()-3600);
		// setcookie($user_id."_naver_avr",$follows,time()-3600);
		// setcookie($user_id."_naver_ok",$followers,time()-3600);

		$disconnect_sql = "update USER_CODE set naver_state='0' where id='$user_id'";
		mysqli_query($con,$disconnect_sql);
		
	}
}else if($sns=='all'){
	if($mode=='edit'){
		$nick = $_POST['nick'];

		if($nick!=""){
			$data = file_get_contents("https://www.instagram.com/".$nick."/",0);
			$filter_1 = explode("edge_followed_by\":{\"count\":",$data);
			$filter_2 = explode("}", $filter_1[1]);
			$follow_num =  $filter_2[0]; //유저의 팔로우 수.
			
			$update_follow_sql = "update USER_CODE set insta_follow='$follow_num' where id='$user_id'";
			mysqli_query($con,$update_follow_sql);

		}

		$n_id = $_POST['naver_id'];
		if($n_id!=""){
			$url = "http://blog.naver.com/NVisitorgp4Ajax.nhn?blogId=".$n_id;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, $is_post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec ($ch);  //검색된 쇼핑몰 페이지
			curl_close ($ch);

			$total = 0;

			//최근 4일동안 접속자수를 받아온다.
			for($i=1; $i<5; $i++){
				$filter1 = explode("cnt=\"", $response);
				$filter2 = explode("\"", $filter1[$i]);


				$total += $filter2[0];
			}
			//접속자수를 전부 더해 평균낸다.
			$average = $total/4;
			
			$update_visit_sql = "update USER_CODE set naver_visit='$average' where id='$user_id'";
			mysqli_query($con,$update_visit_sql);
		}

		
	}
}









?>