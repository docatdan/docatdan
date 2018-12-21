<!DOCTYPE html>
<?php
session_start();
include 'ollearDB.php';


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

	<body style="overflow-y: scroll;">
		<div class="header_wrap">
		        <div id="header">
		            <h4 id="logo"><a href="/"><img src="https://www.docatdan.com/images/newLogo.png" style="width: 108px;"></a></h4>

		            <p class="navBtn"><i class="xi-bars"></i></p>

		            <div class="nav_wrap">
		                <i class="xi-close"></i>
		                <ul id="nav">
		                    <?php
		                    if (!isset($user_id)) {
		                    ?>
		                    <li><a href="about">소개</a></li>
		                    <li><a href="/docatmall/mall_home">독캣몰</a></li>
		                    <li><a href="review/feed">리뷰</a></li>
		                    <li><a href="service" class="on">가이드</a></li>
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
	                    	<li><a href="">소개</a></li>
	                   	 	<li><a href="/docatmall/mall_home">독캣몰</a></li>
	                    	<li><a href="review/feed">리뷰</a></li>
	                    	<li><a href="service" class="on">가이드</a></li>
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
		         </div>


		<div id="guide_sub">
			<script>
				$(function() {
					// tab
					$("#guide_tab").tab({functions: "keyup click", fade: true});
				});


				$(function() {
					// main visual
					$('.main_visual').slick({
						autoplay: true,
						dots: true
					});
				});

				</script>

			</script>

			<div id="guide" class="wrap">
				<ul class="menu">
					<li class="service_li"><a href="./service">서비스 소개</a></li>
					<li class="service_li on"><a href="./review_guide">리뷰 작성법</a></li>
					<li class="service_li"><a href="./faq">faq</a></li>
					<li class="service_li"><a href="./direct_qna">1:1 문의</a></li>
				</ul>

				<div id="guide_cont">
					<div class="title">
						<h3>리뷰 작성법</h3>
					</div>


					<!-- tab -->
					<div id="guide_tab">
						<!-- <ul class="header">
							<li>사료 및 간식</li>
							<li>제품</li>
							<li>장난감</li>
						</ul> -->

						<div class="content">
							<div>
								<h3>사진촬영 예시</h3>
								<div id="visual" >
									<!-- pc -->
									<div class="hidden_sm">
										<div class="main_visual">
											<div><img src="./images/service_info1.png" alt="docatdan"></div>
											<div><img src="./images/service_info2.png" alt="docatdan"></div>
											<div><img src="./images/service_info3.png" alt="docatdan"></div>
											<!-- <div><img src="./images/main/main_banner3.jpg" alt="oller"></div> -->
										</div>
									</div>
									<!-- mobile -->
									<div class="visible_sm">
										<div class="main_visual">
											<div><img src="./images/service_info1.png" alt="dogcatdan"></div>
											<div><img src="./images/service_info2.png" alt="docatdan"></div>
											<div><img src="./images/service_info3.png" alt="docatdan"></div>
										</div>
									</div>
								</div>

								<div style="margin-top: 5%;">
									<img src="./images/how_to_review.png">
								</div>
							</div>
							<div>
								tab 2 content 2
							</div>
							<div>
								tab 3 content 3
							</div>
						</div>
					</div> <!-- tab -->
				</div>

			</div>
		</div>


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
