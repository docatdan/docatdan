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
		<link rel="stylesheet" href="https://www.docatdan.com/semantic-ui/semantic.min.css">


		<script src="./js/jquery-1.8.3.min.js"></script>
		<script src="./js/site.js"></script>
		<script src="./js/jQuery.thisweb.js"></script>
		<script src="./js/slick.js"></script>
		<script src="https://www.docatdan.com/semantic-ui/semantic.min.js"></script>

	</head>

	<style type="text/css">
		.profile_img{
		 margin: 0 auto 0;
		    width: 45px;
		    height: 45px;
		    border-radius: 50%;
		    background: url(../images/sub/mypage/person_default.png) no-repeat center top;
		    overflow: hidden;
		    background-size: 100%;
		}
		.good_btn{
			background: url(./images/main/good_empty.png);
			background-size: contain;
		}

		.good_btn.on{
			background: url(./images/main/good_ok.png);
			background-size: contain;
		}

		h4{
			margin-block-start: 1.33em;
		    margin-block-end: 1.33em;
		    margin-inline-start: 0px;
		    margin-inline-end: 0px;
		}




	</style>

	<body style="overflow-y: scroll;">
		<div class="header_wrap">
			<!-- header -->
			<div id="header">
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
		</div>



		<div id="sns_sub">
			<div id="sns" class="wrap">
				<div id="sns_form" class="wrap">
					<h2>리뷰작성</h4>
					<div class="review">
						<div class="review_form">
							<form enctype="multipart/form-data" class="form-horizontal" action="review_ok" method="post" name="bfrm">
								<input type="hidden" name="mode" value="reivew_write">
								<div class="review_wrap">
									<div class="p_info">
										<div class="p_info_wrap">
											<div class="title">
												<label>상품명</label>
											</div>
											<div>
												<input type="text" name="product_name" placeholder="상품명을 입력해주세요" class="m_text">
											</div>
										</div>
									</div>
									<div class="p_info">
										<div class="p_info_wrap">
											<div class="title">
												<label>후기</label>
											</div>
											<div>
												<input type="text" name="product_text" placeholder="후기를 입력해주세요." id="product_text" class="m_text">
											</div>
										</div>
									</div>
									<div class="p_info">
										<div class="p_info_wrap">
											<div class="title">
												<label>태그</label>
											</div>
											<div>
												<input type="text" name="product_tag" placeholder="후기를 입력해주세요." id="product_tag" class="m_text">
											</div>
										</div>
									</div>
									<div class="p_info">
										<div class="p_info_wrap">
											<div class="title">
												<label>평점</label>
											</div>
											<div>
						            			<div class="starRev m_text" style="width: 65%;">
												  <span class="starR1">별1_왼쪽</span>
												  <span class="starR2">별1_오른쪽</span>
												  <span class="starR1">별2_왼쪽</span>
												  <span class="starR2">별2_오른쪽</span>
												  <span class="starR1">별3_왼쪽</span>
												  <span class="starR2">별3_오른쪽</span>
												  <span class="starR1">별4_왼쪽</span>
												  <span class="starR2">별4_오른쪽</span>
												  <span class="starR1">별5_왼쪽</span>
												  <span class="starR2">별5_오른쪽</span>
												</div>
											</div>
										</div>
									</div>
									<div class="p_info">
										<div class="p_info_wrap">
											<button type="submit" class="submit" style="width: 100%;">작성완료</button>
										</div>
									</div>
								</div>
							</form>
						</div>



					</div>
				</div>
			</div>
		</div>

		<script>
			window.onscroll = function(ev) {

		        // if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight-1)) {
		        //     additem(paging,category,'item');
		        //     paging ++;
		        // }
		        // scrollFunction();
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

			function not_login(cate){

				alert('로그인 후에 이용하실 수 있습니다.');


			}
			$(function(){
				$('input[id=product_tag]').keyup(function(event){
					var code = event.keyCode;

					if(code==32){
						var content = document.getElementById('product_tag').value;


						var splitedArray = content.split(' ');
						var linkedContent = '';

						for(i=0; i<splitedArray.length; i++){

							if(splitedArray[i]==""){

							}else {
								if(splitedArray[i].indexOf('#')==0){
									linkedContent += splitedArray[i]+" ";
								}else{
									linkedContent += '#'+splitedArray[i]+" ";
								}

							}


						}
						document.getElementById('product_tag').value = linkedContent;
						document.getElementById('product_tag').style.color = 'blue';

					}

				});


			});

			$('.starRev span').click(function(){
			  $(this).parent().children('span').removeClass('on');
			  $(this).addClass('on').prevAll('span').addClass('on');
			  return false;
			});
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




		<button onclick="topFunction()" id="Top_Btn" title="Go to top" style="display: none; position: fixed; bottom: 20px; right: 30px; z-index: 99; font-size: 18px; border: none; outline: none; background-color: red; color: white; cursor: pointer; padding: 15px; border-radius: 4px;">Top</button>

	</body>
</html>
