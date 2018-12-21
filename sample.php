<!DOCTYPE html>
<?php
session_start();
include 'ollearDB.php';

$email_check = $_SESSION['email_check'];

$goods_num = $_GET['goods_num'];
$detail_sql ="select*from GOODS_INFO join GOODS_IMG on GOODS_INFO.num=GOODS_IMG.goods_num and GOODS_INFO.num='$goods_num' and GOODS_IMG.show_num='0'";
$result = mysqli_query($con,$detail_sql);

$row = mysqli_fetch_array($result);
$company = $row['company'];
$detail_goods_name = $row['detail_goods_name'];

$user_info_sql = "select*from USER where id='$user_id'";
$info_result = mysqli_query($con,$user_info_sql);
$info_row = mysqli_fetch_array($info_result);

$_SESSION['main_address'] = $info_row['main_zipcode']."-".$info_row['main_add1']."  ".$info_row['main_add2'];
$_SESSION['sub_address'] = $info_row['sub_zipcode']."-".$info_row['sub_add1']."  ".$info_row['sub_add2'];


$insta_check = $_COOKIE[$user_id."_insta"];
$insta_ok = $_COOKIE[$user_id."_insta_ok"];

//상품을 신청한 인원수를 파악하기 위한 쿼리
$apply_number_sql = "select id from SAMPLE_APPLY where goods_id='$goods_num'";
$apply_number_result = mysqli_query($con,$apply_number_sql);
$apply_number = mysqli_num_rows($apply_number_result);

$apply = $row['applydate']; //db에 있는 시간
$apply_arr = explode("/", $apply); //"/"를 기준으로 시작날과 시작시간 남은시간을 나는다
$today = date("Ymd");
$date = date("H:i:s");
$time = $apply_arr[2]*3600; //시간을 초로변환
$compare_date_time = (strtotime($apply_arr[1]) - strtotime($date)); //시작시간과 현재시간을 비교 => 초로 표시
$date_seconds = ($apply_arr[0]-$today)*3600*24;  //시작 기준일과 현재 날짜를 비교해서 초로 환산
$init = ($time+$compare_date_time+$date_seconds);	//현재를 기준으로 남은시간 초로 표시(설정한 시간 - 경과시간)
if($init<=0){//남은시간이 없는 경우 팔지않는 품목으로 전환
	$not_sale = true;
}
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);
$seconds = $init % 60; //남은시간을 시:분:초로 표시
$real_apply = $hours.":".$minutes.":".$seconds;

$sns_sql = "select insta_follow,naver_visit,insta_state,naver_state from USER_CODE where id='$user_id'";
$sns_result = mysqli_query($con,$sns_sql);
$sns_row = mysqli_fetch_array($sns_result);

$insta_state = $sns_row['insta_state'];
if($insta_state==0){
	$insta_ok = "";
}else{
	$insta_followers = $sns_row['insta_follow'];
	if($insta_followers>=100){
		$insta_ok='ok';
	}else{
		$insta_ok='no';
	}
}

$naver_state = $sns_row['naver_state'];
if($naver_state==0){
	$naver_ok = "";
}else{
	$naver_visit = $sns_row['naver_visit'];
	if($naver_visit>=10){
		$naver_ok='ok';
	}else{
		$naver_ok='no';
	}
}





 ?>

<html lang="ko">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>독캣단</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">


		<link rel="shortcut icon" href="/images/favicon.ico">
		<link rel="stylesheet" href="./css/site.css">
		<link rel="stylesheet" href="./css/sub.css">
		<link rel="stylesheet" href="./css/slick.css">
		<link rel="stylesheet" href="./css/slick-theme.css">
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
		<link rel="stylesheet" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">


		<script src="./js/jquery-1.8.3.min.js"></script>
		<script src="./js/site.js"></script>
		<script src="./js/jQuery.thisweb.js"></script>
		<script src="./js/slick.js"></script>

	</head>

	<body>
		<div id="header">
			<h1 id="logo"><a href="/"><img src="https://heejun92.cafe24.com/images/newLogo.png" style="width: 108px;"></a></h1>

			<p class="navBtn"><i class="xi-bars"></i></p>

			<div class="nav_wrap">
				<i class="xi-close"></i>
				<ul id="nav">
					<?php
					if (!isset($user_id)) {
					?>
					<li><a href="about">소개</a></li>
					<li><a href="/docatmall/mall_home">독캣몰</a></li>
					<li><a href="/review/feed">리뷰</a></li>
					<li><a href="service">가이드</a></li>
					<li><a href="https://www.allear.co">제휴문의</a></li>
				</ul>
					<div id="nav_right">
						<ul class="link">
							<li><a href="signin">로그인</a></li>
							<li><a href="signup">회원가입</a></li>
						</ul>
					</div>
					<?php
					} else {
					?>
					<li><a href="about">소개</a></li>
					<li><a href="/docatmall/mall_home">독캣몰</a></li>
					<li><a href="/review/feed">리뷰</a></li>
					<li><a href="service">가이드</a></li>
					<li><a href="https://www.allear.co">제휴문의</a></li>
				</ul>
				<div id="nav_right">
					<ul class="link">
						<li><a href="mypage_spon">마이페이지</a></li>
						<li><a href="signout">로그아웃</a></li>
					</ul>
				</div>
				<?php
				}
				?>
			</div>
		</div>


		<div id="sub">
			<script>



			function select_address(){
				var add = document.getElementById("address").selectedIndex;
				var main_add = "<?=$_SESSION['main_address']?>";
				var sub_add = "<?=$_SESSION['sub_address']?>";
				if(add==0){
					$("#selected_add").html("");
					$("#selected_add").append("<h4><input type='hidden' id='add' value='"+main_add+"'>"+main_add+"</h4>");
				}else if(add==1){
					$("#selected_add").html("");
					$("#selected_add").append("<h4><input type='hidden' id='add' value='"+sub_add+"'>"+sub_add+"</h4>");
				}


			}

			function inspection(){
				var form = document.getElementById("sample_form");
				var insta_name = "<?=$insta_name?>";
				var insta_ok = "<?=$insta_ok?>";
				var insta_state = "<?=$insta_state?>";
				var naver_state = "<?=$naver_state?>";

				var add = document.getElementById("ship_add").value;

				var sns = document.getElementById("sns");

				if($("#choice_insta").hasClass("on")==true){
					sns.value = 'insta';
				}else if($("#choice_naver").hasClass("on")==true){
					sns.value = 'naver';
				}




				if(form.name.value==""){
					alert('이름을 작성해주세요');
					document.getElementById('name').focus();
				}else if($("#phone_number1").val()=="" || $("#phone_number2").val()=="" || $("#phone_number3").val()==""){
					alert('연락처를 작성해주세요');
					document.getElementById('phone_number').focus();
				}else if(add=='-'){
					alert('주소를 설정해주세요.');
					location.href = "./shipping_edit";
				}else if(sns.value==""){
					alert('리뷰를 작성할 매체를 선택해주세요.');


				}else{
					if(sns.value=='insta'){
						if(insta_state==0){
							alert('인스타를 연동해주세요.');
							location.href = "./mypage_info";
						}else{
						 	if(insta_ok=='ok'){
						 		form.submit();
						 	}else{
						 		alert('팔로우가 낮아 신청할 수 없습니다.');
						 	}
						}
					}else if(sns.value=='naver'){
						if(naver_state==0){
							alert('네이버를 연동해주세요.');
							location.href = "./mypage_info";
						}else{
							if(naver_ok=='ok'){
								form.submit();
							}else{
								alert('방문자 수가 낮아 신청할 수 없습니다.');
							}
						}
					}

				}


			}


			var isDuplicate;
            var msg;



            function e_certification(){
            	 var re_mail = /^([\w\.-]+)@([a-z\d\.-]+)\.([a-z\.]{2,6})$/;
            	 var email = $('#email');
            	 var send_email = email.val();
            	 var email_li = $("#email_ch_li");



                //var s = $(this).next('div'); // div 요소를 변수에 할당
                if (email.val().length == 0) { // 입력 값이 없을 때
                    $('#mail-validation').hide();
                    s.text(''); // strong 요소에 포함된 문자 지움
                } else {
                    $('#mail-validation').show();
                }
                if (re_mail.test(email.val()) != true) {
                    alert('잘못된 이메일 형식입니다.');
                } else {
                    $.ajax({
                        url: 'sendmail_test_ok.php',
                        datatype: 'json',
                        type: 'post',
                        data: {umail: send_email, mode:'certification'},
                        async: false,
                        success: function(data) {
                        	 //var parsed_data = JSON.parse(data);
                        	 if(data==''){
                        	 	alert('이미 인증된 이메일 입니다.');
                        	 }else{
                        	 	alert('인증메일이 전송되었습니다.');
                        	 	email_li.show();
                        	 }


                        },
                        error: function(request, status, error) {
                            console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
                        }
                    });


                }


            }

            function e_code_check(){
            	var email_code = $("#email_code");
            	var m_code = email_code.val();
            	var email = $('#email');
            	var send_email = email.val();

            	$.ajax({
                        url: 'sendmail_test_ok.php',
                        datatype: 'json',
                        type: 'post',
                        data: {code:m_code, mode:'code',umail:send_email},
                        async: false,
                        success: function(data) {
                        	 var parsed_data = JSON.parse(data);
                        	 if(parsed_data['email']=='ok'){
                        	 	alert('이메일 인증이 완료되었습니다.');
                        	 }else{
                        	 	alert('인증번호가 맞지 않습니다.');
                        	 }


                        },
                        error: function(request, status, error) {
                            console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
                        }
                });
            }







			</script>

			<div id="sample" class="wrap">
				<form action="sample_ok.php" name="sample_form" method="post" id="sample_form">
					<input type="hidden" name="company" value="<?=$company?>">
					<input type="hidden" name="detail_goods_name" value="<?=$detail_goods_name?>">
					<input type="hidden" name="goods_num" value="<?=$goods_num?>">
					<input type="hidden" name="sns" id="sns"  value="">
					<h3 class="form_name">신청하기</h3>


					<div>
						<ul class="top">
							<li class="img">
								<img src="<?=$row['origin_img']?>">
							</li>
							<li class="txt">
								<div>
									<ul style="overflow: hidden;">
										<li class="first_li">
											<span>상품명</span>
											<p><?=$row['detail_goods_name']?></p>
										</li>
										<li>
											<span>판매자</span>
											<p>[<?=$row['company']?>]</p>
										</li>
										<li>
											<span>협찬가</span>
											<p>0원</p>
										</li>
										<li>
											<span>정가</span>
											<p style="text-decoration: line-through;"><?=number_format($row['price']);?>원</p>
										</li>
									</ul>
								</div>
								<div class="sample_div2">
									<ul >
										<li class="first_li">
											<span>남은시간</span>
											<p class="sample_point" id="clock"></p>
										</li>
										<li>
											<span>선정/참여</span>
											<p class="sample_point"><?=$row['select_num']?> <span class="join_num">/ <?=$apply_number?></span> </p>
										</li>
										<li>
											<span>옵션</span>
											<p class="sample_point"><?=$row['default_option']?> <?=$row['default_num']?>개</p>
										</li>
									</ul>
								</div>

							</li>
						</ul>
					</div>

					<div class="sns">
						<h4>정보 확인</h4>
						<div class="user_info">
							<table>
								<tbody>
									<tr>
										<th>수령인</th>
										<td><input type="text" name="name" value="" id="name"></td>


									</tr>
									<tr >
										<th scope="row">연락처</th>
										<td>
											<input type="text" name="phone_number[]" value="" id="phone_number1"> -
											<input type="text" name="phone_number[]" value="" id="phone_number2"> -
											<input type="text" name="phone_number[]" value="" id="phone_number3">
										</td>

										<!-- <td class="btn_td"><button class="btn">인증</button></td> -->
									</tr>
									<tr>
										<th scope="row">배송지 주소
					<!-- 					<td>집<p><?=$_SESSION['main_address']?></p></td>
											<td class="btn_td"><button class="btn">변경</button></td> -->
											<td>
												<select class="ship_add" id="ship_add" name="ship_add">
													<option><?=$_SESSION['main_address']?></option>
													<option><?=$_SESSION['sub_address']?></option>
												</select>
											</td>
										</th>
									</tr>
									<tr>
										<th style="vertical-align: top;">배송 요청사항</th>
										<td><textarea name="ship_memo" class="ship_memo"></textarea></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="choice_sns">
						<h4>리뷰 SNS 선택</h4>
						<div class="sns_info">
							<ul>
								<li class="insta" id="choice_insta" >인스타그램</li>
								<li class="naver" id="choice_naver" >네이버 블로그</li>
							</ul>
						</div>

					</div>



					<div class="info_02">
						<ul>
							<li>
								<h3>안내 사항</h3>
							</li>
							<li class="not_first_li">
								<div class="ship_info" style="float: left;">
									<span>본 서비스는 제품을 신청한 후 선정을 통하여 제품을 협찬하는 서비스 입니다.</span>
									<p>사용자는 협찬받은 제품을 사용 후 리뷰를 남겨야 됩니다.</P>
									<p>리뷰는 제품을 받으신 후 1주일 이내에 작성되어야 합니다.</p>
									<p>리뷰는 작성 후 3개월 간 유지되어야 합니다.</p>

								</div>
							</li>
						</ul>
					</div>

					<input value="신청완료" onclick="inspection();" class="submit_btn" style="text-align: center;">
				</form>
			</div>
		</div>

		<script type="text/javascript">startTime("<?=$real_apply?>");
			var naver_ok = "<?=$naver_ok?>";
			var insta_ok = "<?=$insta_ok?>";

			$(function() {
				$("#sample .sns_info li").each(function() {
					var btn_event = $(this);
					var no_event = $(this).siblings("li");

					$(btn_event).on("keyup click",function() {
						$(no_event).not(btn_event).removeClass("on");


						var click_sns = btn_event.attr('id');
						if(click_sns=='choice_insta'){

							if(insta_ok==''){
								alert('인스타그램을 등록해주세요.');
								location.href = "./mypage_info";
							}else if(insta_ok=="ok"){
								$(btn_event).addClass("on");
							}else{
								alert('팔로우가 낮아 인스타그램을 선택할 수 없습니다.');
							}
						}else if(click_sns=='choice_naver'){
							if(naver_ok==''){
								alert('네이버 블로그 id를 등록해주세요.');
								location.href = "./mypage_info";
							}else if(naver_ok=="ok"){
								$(btn_event).addClass("on");
							}else{
								alert('블로그 방문자 수가 낮아 인스타그램을 선택할 수 없습니다.');
							}
						}


					});
				});
			});



			function startTime(today) {
				var date_array = today.split(":");
				var h = date_array[0];
				var m = date_array[1];
				var s = date_array[2];
				m = checkTime(m);
				s = checkTime(s);
				var sum = h*3600+m*60+s*1;
				if(sum>=0){
					document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
					var seconds = sum-1;
						var hour = parseInt(seconds/3600);
						var min = parseInt((seconds%3600)/60);
						var sec = seconds%60;
						var time = hour+":"+min+":"+sec;

						setTimeout(function() {
									startTime(time)
						}, 993);
				}else{
					document.getElementById('clock').innerHTML = "00:00:00";
				}

			}
			function checkTime(i) {
			    if (i < 10) {i = "0" + i}; // 숫자가 10보다 작을 경우 앞에 0을 붙여줌
				    return i;
			}

		</script>


		<div id="footer">
			<div class="wrap">
				<div class="info">
					<ul class="footer_menu">
						<li><a href="policies">이용약관</a></li>
						<li><a href="info">개인정보취급방침</a></li>
					</ul>
					<ul class="address">
						<li>
							<span>회사명 : 독캣단</span>
							<span>대표자 : 김동훈</span>
							<span>사업자등록번호 : 892-11-00972</span>
							<span>전화번호 : 070-8098-7542</span>
						</li>
						<li>
							<span>주소 : 인천광역시 부평구 안남로 272, 304동 2102호(청천동, 금호타운)</span>
							<span>개인정보관리책임자 : quadh@naver.com</span>
						</li>
					</ul>
				</div>
				<div class="cs_center">
					<h2><i class="xi-call"></i>070-8098-7542</h2>
					<p>고객센터 운영시간 09:00 ~ 19:00</p>
					<span>점심시간 12:00 ~ 13:00 주말 및 공휴일 휴무</span>
				</div>
				<p class="copy">Copyright &copy; 독캣단 . All rights reserved.</p>
			</div>
		</div>
	</body>
</html>
