<!DOCTYPE html>
<?php
session_start();
include 'ollearDB.php';



$get_user_profile_sql = "select*from SNS_USER where user_id='$user_id'";
$get_user_profile_result = mysqli_query($con,$get_user_profile_sql);
$get_user_profile_row = mysqli_fetch_array($get_user_profile_result);

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
		<link rel="stylesheet" href="https://heejun92.cafe24.com/semantic-ui/semantic.min.css">


		<script src="./js/jquery-1.8.3.min.js"></script>
		<script src="./js/site.js"></script>
		<script src="./js/jQuery.thisweb.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
		<script src="https://cdn.jsdelivr.net/clipboard.js/1.5.3/clipboard.min.js"></script>
		<script src="https://heejun92.cafe24.com/semantic-ui/semantic.min.js"></script>
		<script src="./js/slick.js"></script>

	</head>

	<script type="text/javascript">



	</script>

	<body>
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
	                    <li><a href="sns">SNS</a></li>
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
                    	<li><a href="sns">SNS</a></li>
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


		<div id="mypage_sub">
			<div id="new_mypage" class="wrap">
				<div id="new_guide" class="wrap">
					<ul class="menu">
						<li><a href="./mypage_spon">협찬내역</a></li>
						<li class="on"><a href="policies">구매내역</a></li>
						<li><a href="./mypage_info">정보수정</a></li>

					</ul>
					<div id="guide_cont">
						<div class="title">
                        	<h3>독캣몰</h3>
	                    </div>

						<ul class="breakdown" >
							<li id="order_history" class="on"><a >주문내역</a></li>
							<li id="cart" >장바구니</a></li>
							<li id="history" onclick="history_load('all');"><a >내역</a></li>
						</ul>

						<div id="guide_tab" style="overflow:hidden;">
							<div class="content">
								<div style="width: 100%;">
									<div class="orderListArea">
										<div class="title">
										    <h3>주문 내역</h3>
										</div>
										<div class="boardList">
											<table border="1" style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
												<thead>
													<tr>
													    <th scope="col" class="product" style="width: 70%;">상품정보</th>
													    <th scope="col" class="state">진행상태</th>
													</tr>
												</thead>

												<tbody >
													<?php
													$load_order_sql = "select*from BUY_GOODS join MGOODS_IMG on BUY_GOODS.buyer_ix='$user_id' and BUY_GOODS.goods_id=MGOODS_IMG.goods_num and MGOODS_IMG.show_num=0 and MGOODS_IMG.type=0";
													$load_order_result = mysqli_query($con,$load_order_sql);


													while($row=mysqli_fetch_array($load_order_result)){
														$goods_name = $row['goods_name'];
														$option = $row['option'];
														$ship_state = $row['ship_state'];
														$origin_img = $row['origin_img'];
														$quantity = $row['quantity'];
														$price = $row['price'];
														if($ship_state==0){ //배송준비중
															$ship_state = "배송준비중";
														}else if($ship_state==100){//배송중
															$ship_state = "배송중";
														}else if($ship_state==200){//배송완료
															$ship_state = "배송완료";
														}
													?>
													<tr>
														<td class="product" style="width: 70%;">
															<div style="display: flex;;">
																<a href=""><img src="<?=$origin_img?>" style="width: 100px;"></a>
																<div style="margin: 2% 0 0 5%; width: 100%;">
																	<strong><?=$goods_name?></strong>
																	<div class="option">
																		[옵션] : <?=$option?>
																	</div>
																	<div class="quantity" style="width: auto;">
																		수량 : <?=$quantity?>
																		<span style="margin-left: 10%; font-weight: bold; font-size: 18px;"><?=number_format($price)?>원</span>
																	</div>
																</div>
															</div>
														</td>
														<td class="state">
															<h2 id="total_<?=$cart_count?>" alt="<?=$price?>"><?=$ship_state?></h2>
														</td>
													</tr>
													<?php
													}
													?>

												</tbody>
												<tfoot>
													<tr>

													</tr>
												</tfoot>
											</table>
										</div>

									</div>
								</div>
							</div>
						</div>


					</div>


				</div>
			</div>
		</div>

		<script type="text/javascript">
			$("#cart").click(function(){
				location.href = "./cart_test";
			});

		</script>



		<div id="footer">
			<div class="wrap">
				<div class="info">
					<ul class="footer_menu">
						<li><a href="#">이용약관</a></li>
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
