<!DOCTYPE html>
<?php
session_start();
include 'ollearDB.php';

$mAgent = array("iPhone","iPod","Android","Blackberry",
    "Opera Mini", "Windows ce", "Nokia", "sony" );
$chkMobile = false;
for($i=0; $i<sizeof($mAgent); $i++){
    if(stripos( $_SERVER['HTTP_USER_AGENT'], $mAgent[$i] )){
        $chkMobile = true;
        break;
    }
}

if($chkMobile) {
   $device = 'mobile';
} else {
   $device = 'pc';
}

$ip = $_SERVER['REMOTE_ADDR'];

$check_sql = "select ix from VISITOR where ip='$ip' and date(date) =date(now()) and goods_ix='index'";
$result = mysqli_query($con,$check_sql);
$check_number = mysqli_num_rows($result);

if($check_number>0){
	if($user_id!=""){
		$update_sql = "update VISITOR set user_ix='$user_id',user_nick='$user_nick' where ip ='$ip'";
		mysqli_query($con,$update_sql);
	}
		//echo "이미옴 ";
}else{
	if($user_id==""){
		mysqli_query($con,"insert into VISITOR(ip,user_ix,user_nick,device,goods_ix) values('$ip','non-members','non-members','$device','index')");
	}else{
		mysqli_query($con,"insert into VISITOR(ip,user_ix,user_nick,device,goods_ix) values('$ip','$user_id','$user_nick','$device','index')");
	}

}


?>


<html lang="ko">
	<head>

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-130961118-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-130961118-1');
		</script>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>독캣단</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" viewport-fit = "cover">
		<link rel="canonical" href="https://docatdan.com/">
		<meta property="og:type" content="website">
		<meta property="og:title" content="독캣단">
		<meta property="og:description" content="반려동물을 셀럽으로 만들고싶다면? 모두 독캣단의 단원이 되어보세요!">
		<meta property="og:image" content="/images/favicon.ico">
		<meta property="og:url" content="http://docatdan.com">
		<meta name="description" content="반려동물을 셀럽으로 만들고싶다면? 모두 독캣단의 단원이 되어보세요!">



		<link rel="shortcut icon" href="/images/favicon.ico">
		<link rel="stylesheet" href="./css/site.css">
		<link rel="stylesheet" href="./css/sub.css">
		<link rel="stylesheet" href="./css/slick.css">
		<link rel="stylesheet" href="./css/slick-theme.css">
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
		<link rel="stylesheet" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">

		<script src="./js/jquery-1.8.3.min.js"></script>
		<script src="./js/site.js"></script>
		<script src="./js/jQuery.thisweb.js" ></script>
		<script src="./js/slick.js"></script>

		<style>
			html, body { max-width: 100%; height: 100%; overflow-x: hidden; position: relative; }
		</style>

	</head>


	<?php
	if($admin_lv==1000 || $admin_lv==100){
	?>
	<a href="./adminTest/index" target="_blank"><button  id="Admin_Btn" title="Go to top" style=" position: fixed; top: 20px; left: 30px; z-index: 99; font-size: 18px; border: none; outline: none; background-color: black; color: white; cursor: pointer; padding: 15px; border-radius: 4px;">Admin</button></a>


	<?php }?>

	<style type="text/css">
		#myModal{
			-webkit-overflow-scrolling: touch;
		}
	</style>

	<body>
        <!-- loader -->
		<div id="load" style="background-image: url('images/logo-loader.gif'); background-size: 600px 400px; background-position: 50% 45%; background-repeat: no-repeat; width: 100%; height: 100%;">
		</div>
		<!-- header -->
		<div id="header" style="display: none;">
			<h4 id="logo"><a href="/"><img src="https://www.docatdan.com/images/newLogo.png" style="width: 108px;"></a></h4>

			<p class="navBtn"><i class="xi-bars"></i></p>

			<!-- nav_wrap -->
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
			<!-- nav_wrap 끝 -->
		</div>
		<!-- header 끝 -->

		<div id="main" style="display: none;">
			<script>
			$(function() {
				// main visual
				$('.main_visual').slick({

					dots: true
				});
			});

			function not_login(cate){

				alert('로그인 후에 이용하실 수 있습니다.');


			}
			</script>

			<div id="visual">
				<!-- pc -->
				<div class="hidden_sm">
					<div class="main_visual">
						<!-- <div><img src="./images/main/new_banner_extra1.png" alt="docatdan"></div> -->
						<div class="banner_wrap" style="height: 500px;"><a class="banner_img" href="#" ></a></div>


						<!-- <div><img src="./images/main/new_banner_1_2.jpg" alt="docatdan"></div> -->
						<!-- <div><img src="./images/main/main_banner3.jpg" alt="oller"></div> -->
					</div>
				</div>
				<!-- mobile -->
				<div class="visible_sm">
					<div class="main_visual">
						<div ><img src="./images/main/20181031banner_m.png" alt="dogcatdan"></div>
						<!-- <div><img src="./images/main/new_banner_1_2.jpg" alt="oller" style="width: 80%; margin: 0 auto;"></div> -->
					<!-- 	<div><img src="./images/main/main_banner3.jpg" alt="oller"></div> -->
					</div>
				</div>
			</div>


			<div id="main_list" class="wrap">
				<!-- <h3>product</h3> -->
				<!-- <div class="img_wrap" style="text-align: center;">
					<img src="./images/hotcampaign.PNG" alt="ollear">
				</div> -->


				<!-- outer tab -->
				<div id="main_tab">
					<ul class="header">
                        <button type="button" id="prev_btn" class="btn" style="margin-top: 17px; margin-left: 5px; position: absolute; left: 0; background: none; z-index: 1;"><img src="images/main/left_btn.png" style=" width: 15px; height: 25px;"></button>
                        <button type="button" id="next_btn" class="btn" style="margin-top: 17px; margin-right: 5px; position: absolute; right: 0; background: none; z-index: 1;"><img src="images/main/right_btn.png" style=" width: 15px; height: 25px;"></button>
						<!-- <li onclick="changeitem('','item'); Getcategory('','cate');"><span>전체보기</span></li>
						<li onclick="changeitem('01','item'); Getcategory('01','cate');"><span>애견</span></li>
						<li onclick="changeitem('04','item'); Getcategory('04','cate');"><span>여행</span></li>
						<li onclick="changeitem('02','item'); Getcategory('02','cate');"><span>뷰티</span></li> -->
						<li onclick="changeitem('01','item');" style="background-image: url('/images/main/cate/cate_all2.png'); background-size: contain;"><span>전체보기</span></li>
						<li onclick="changeitem('010100','item');" style="background-image: url('/images/main/cate/cate_catfood.png'); background-size: contain;"><span>식품</span></li>
						<li onclick="changeitem('010200','item');" style="background-image: url('/images/main/cate/cate_care.png'); background-size: contain;"><span>건강관리</span></li>
						<li onclick="changeitem('010300','item');" style="background-image: url('/images/main/cate/cate_hair.png'); background-size: contain;"><span>미용</span></li>
						<li onclick="changeitem('010400','item');" style="background-image: url('/images/main/cate/cate_cloth.png'); background-size: contain;"><span>의류</span></li>
						<li onclick="changeitem('010500','item');" style="background-image: url('/images/main/cate/cate_service.png'); background-size: contain;"><span>서비스</span></li>
						<li onclick="changeitem('010600','item');" style="background-image: url('/images/main/cate/cate_cattoy.png'); background-size: contain;"><span>장난감</span></li>
					</ul>

					<div class="content2">

							<!-- inner tab -->
							<div id="main_tab2">
								<!-- <ul class="header" id="category" name="category">

								</ul>
								<div>
									<select id="order">
										<option value="">등록순</option>
										<option value="">인기순</option>
									</select>
								</div> -->

								<div class="content2">
									<div>
										<div class="item_subject">
											<h2 id="cate_name">전체보기</h2>
										</div>
										<ul id="item" name="item">
											<?php
											$page = 1;
											$load_sql = $item_sql ="select origin_img,goods_name,detail_goods_name,company,select_num,applydate,goods_num from GOODS_INFO join GOODS_IMG on GOODS_INFO.num = GOODS_IMG.goods_num and GOODS_IMG.show_num='0' and GOODS_INFO.type<=0 and GOODS_INFO.cate1='01' order by GOODS_INFO.type desc limit 16";
											$result = mysqli_query($con,$load_sql);

											while($row =mysqli_fetch_array($result)){
												$img = $row['origin_img'];
												$goods_name = $row['goods_name'];
												$detail_goods_name = $row['detail_goods_name'];
												$company = $row['company'];
												$select_num = $row['select_num'];
												$goods_num = $row['goods_num'];

												$apply = $row['applydate']; //db에 있는 시간
												$apply_arr = explode("/", $apply); //"/"를 기준으로 시작날과 시작시간 남은시간을 나는다
												$today = date("Ymd");
												$date = date("H:i:s");
												$time = $apply_arr[2]*3600; //시간을 초로변환
												$compare_date_time = (strtotime($apply_arr[1]) - strtotime($date)); //시작시간과 현재시간을 비교 => 초로 표시
												$date_seconds = (strtotime($apply_arr[0]) - strtotime($today));  //시작 기준일과 현재 날짜를 비교해서 초로 환산
												$init = ($time+$compare_date_time+$date_seconds);	//현재를 기준으로 남은시간 초로 표시(설정한 시간 - 경과시간)
												$hours = floor($init / 3600);
												$extra_date =ceil($hours/24); //캠페인 남은 날짜(올림)

												$d_day = floor($date_seconds/86400);

												$compare_start_today = $apply_arr[0] - $today; //캠페인 시작날짜와 오늘 날짜 비교 -면 시작

												$icon_name;
												if($init<=0){ //마감
													$extra_date="마감";
													$icon_name = "종료";
												}else{ //진행중이거나 진행예정
													if($compare_start_today==0){ //오늘 시작햇거나 시작할 예정
														if($compare_date_time<=0){ //시작햇음
															//$extra_date="D - ".$extra_date;

															if($init<129600){
																$icon_name = "종료임박";
															}else{
																$extra_date="D - ".$extra_date;
																$icon_name = "진행중";
															}

														}else{//시작할 예정
															$extra_date="시작예정";
															$icon_name = "시작예정";
														}
													}else if($compare_start_today>0){ //시작할 예정
														$extra_date="시작예정";
														$icon_name = "시작예정";
													}else{ //진행중
														$extra_date="D - ".$extra_date;
														if($init<129600){
															$icon_name = "종료임박";
														}else{

															$icon_name = "진행중";
														}
													}
												}

												$apply_number_sql = "select num from SAMPLE_APPLY where goods_id='$goods_num'";
												$apply_number_result = mysqli_query($con,$apply_number_sql);
												$apply_number = mysqli_num_rows($apply_number_result);




											?>
											<li>
												<a href="./detail?goods_num=<?=$goods_num?>">
													<div class="img" data-descr="<?= $extra_date?>"><img src="<?=$img?>"></div>
													<div class="item_desc">
														<h2>[<?=$company?>] <?=$detail_goods_name?></h2>
														<div class="item_sub">
															<div class="icon1">HOT</div>
															<div class="icon2"><?=$icon_name?></div>
															<div class="amount">
																총 수량 <?=$select_num?>개 / <?=$apply_number?>명 신청
															</div>
														</div>
													</div>
												</a>
											</li>

											<?php }?>

										</ul>
									</div>
								</div>
							</div>

					</div>
				</div>
			</div>

		</div>

		<script type="text/javascript">

            $(window).load(function() {
                // setTimeout(function(){
                    $('#load').hide();
                    $('#header').show()
                    $('#main').show();
                    $('#footer').show();
                // }, 2000);
            });

			var paging = <?=$page?>;
			var category = "";

			function additem(paging,catgory,mode){

				$.ajax({
					type: 'post',
					dataType: 'json',
					url: 'item_load.php',
					data:{page:paging,cate:category,mod:mode},

					success:function(data){

						for(no=0; no<data.length; no++){

							$("#item").append("<li><a href='detail.php?goods_num="+data[no].goods_num+"'>"+"<div class='img' data-descr='"+data[no].applydate+"'><img src="+data[no].img+"></div><div class='item_desc'><h2>["+data[no].company+"] "+data[no].goods_name+"</h2><div class='item_sub'><div class='icon1'>HOT</div><div class='icon2'>"+data[no].icon+"</div><div class='amount'>총 수량 "+data[no].select_num+"개 / "+data[no].apply_num+"명 신청</div></div></div></a></li>");
						}
					},
					error: function(request,status,error){
						console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
					}
				});

			}

			function Getcategory(category,mode){

				$.ajax({
					type: 'post',
					dataType: 'json',
					url: 'item_load.php',
					data:{page:paging,cate:category,mod:mode},

					success:function(data){

						$("#category").html("");
						for(no=0; no<data.length; no++){
							$("#category").append("<li id='cate' onclick=changeitem('"+data[no].cate_code+"','item')>"+data[no].category+"</li>");
						}
					},
					error: function(request,status,error){
						console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
					}
				});
			}

			function changeitem(cate,mode){
				category = cate;

				switch (category) {
					case '01' : $('#cate_name').text("전체보기"); break;
					case '010100' : $('#cate_name').text("식품"); break;
					case '010200' : $('#cate_name').text("건강관리"); break;
					case '010300' : $('#cate_name').text("미용"); break;
					case '010400' : $('#cate_name').text("의류"); break;
					case '010500' : $('#cate_name').text("서비스"); break;
					case '010600' : $('#cate_name').text("장난감"); break;
				}

		        $.ajax({
		            type: 'post',
		            dataType: 'json',
		            url: 'item_load.php',
		            data: {page:0, cate:cate, mod:mode},
		            success: function (data) {

		                $("#item").html("");
		                for(no=0; no<data.length; no++){

		                  $("#item").append("<li><a href='detail.php?goods_num="+data[no].goods_num+"'>"+"<div class='img' data-descr='"+data[no].applydate+"'><img src="+data[no].img+"></div><div class='item_desc'><h2>["+data[no].company+"] "+data[no].goods_name+"</h2><div class='item_sub'><div class='icon1'>HOT</div><div class='icon2'>"+data[no].icon+"</div><div class='amount'>총 수량 "+data[no].select_num+"개 / "+data[no].apply_num+"명 신청</div></div></div></a></li>");
		                }

		            },
		            error: function (request, status, error) {
		                console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
		            }
		        });
		        paging = 1;
		    }

			window.onscroll = function(ev) {

		        if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight-1)) {
		            additem(paging,category,'item');
		            paging ++;
		        }
		        scrollFunction();
		    };

		    // Top으로부터 20px 아래로 스크롤이 내려가면 버튼 Show
		    function scrollFunction() {
		        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		            document.getElementById("Top_Btn").style.display = "block";
		        } else {
		            document.getElementById("Top_Btn").style.display = "none";
		        }

		    }

		    // 버튼을 클릭하면 스크롤이 Top으로
		    function topFunction() {

		         $('html, body').animate({scrollTop:0}, 'slow');
		    }

		    $(document).ready(function() {
		      $('#prev_btn').hide();
		    });

		    $('#prev_btn').click( function(){
		    	$('.header li').css('transform', 'translateY(0px)');
		    	$('#prev_btn').hide();
		    	$('#next_btn').show();
		    });

		    $('#next_btn').click( function(){
		    	$('.header li').css('transform', 'translateY(-98px)');
		    	$('#prev_btn').show();
		    	$('#next_btn').hide();
		    });
		</script>

		<button onclick="topFunction()" id="Top_Btn" title="Go to top" style="display: none; position: fixed; bottom: 20px; right: 30px; z-index: 99; font-size: 18px; border: none; outline: none; background-color: red; color: white; cursor: pointer; padding: 15px; border-radius: 4px;">Top</button>



		<div id="footer" style="display: none;">
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
		<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
		<script type="text/javascript">
		if(!wcs_add) var wcs_add = {};
		wcs_add["wa"] = "12a6a4ba584f51";
		wcs_do();
		</script>

	</body>
</html>
