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
		<link rel="stylesheet" href="./css/review.css">
		<link rel="stylesheet" href="./css/sub.css">
		<link rel="stylesheet" href="./css/slick.css">
		<link rel="stylesheet" href="./css/slick-theme.css">
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
		<link rel="stylesheet" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">
		<link rel="stylesheet" href="https://www.docatdan.com/semantic-ui/semantic.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		


		<script src="./js/jquery-1.8.3.min.js"></script>
		<script src="./js/site.js"></script>
		<script src="./js/jQuery.thisweb.js"></script>
		<script src="./js/slick.js"></script>
		<script src="./js/review.js"></script>
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

		.likeBtn-box span{
			margin-left: 5px;
		}

		.hashtag a{color: #3897f0; float: left;}

		


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
		<div id="sns_sub">
			<div id="sns" class="wrap">			
				<div id="sns_form" class="wrap">
					<button onclick="review_write();" style="background-color: #fff; margin-bottom: 3%;">
						<div style="width: 40px; height: 40px; border-radius: 50%; background-color: #fff; border: 1px solid #000; cursor: pointer;">
							<i class="fa fa-pencil fa-2x" style="margin-top: 5px;"></i>
						</div>
					</button>
					<div class="all">
						<div class="sns_row">
							<?php
							$page = 1;
							$get_review_sql = "select*from SNS_FEED join SNS_FILE join SNS_USER join GOODS_REVIEW on SNS_FEED.ix = SNS_FILE.feed_id and GOODS_REVIEW.num=SNS_FEED.review_ix and SNS_FILE.show_num='0' and SNS_USER.user_id = SNS_FEED.user_ix order by SNS_FEED.date desc limit 12";
							$review_result = mysqli_query($con,$get_review_sql);
							while($review_info = mysqli_fetch_array($review_result)){
								$usr_ix = $review_info['user_ix'];
								$profile_img = $review_info['profile_img'];
								$main_img = $review_info['file_link'];
								$nick = $review_info['user_nick'];
								$datetime = $review_info['date'];
								$date_arr = explode(' ', $datetime);
								$date = $date_arr[0];
								$title = $review_info['goods_name'];
								$text = $review_info['text'];
								$rate = $review_info['rating'];
								$good_num = $review_info['good_num'];
								$feed_id = $review_info['feed_id'];
								$review_ix = $review_info['review_ix'];

								//로그인 유저가 리뷰마다 좋아요 했는지 체크하기위한 쿼리
								$good_sql = "select good_state from SNS_GOOD where user_ix='$user_id' and feed_ix='$feed_id'";
								$good_result = mysqli_query($con,$good_sql);
								$good_row = mysqli_fetch_array($good_result);
								$good_state = $good_row['good_state'];

								//리뷰 각각의 댓글 개수파악을 위한 쿼리
								$get_comment = "select ix from SNS_COMMENT where feed_ix='$feed_id'";
								$comment_result = mysqli_query($con,$get_comment);
								$comment_number = mysqli_num_rows($comment_result); //댓글 수 

								//나와 상대에간의 팔로우 상태를 파악하기 위한 쿼리
								$follow_sql = "select ix from SNS_RELATION where user_ix='$user_id' and follow_ix='$usr_ix'";
								$follow_result = mysqli_query($con,$follow_sql);
								$follow_number = mysqli_num_rows($follow_result);
								if($follow_number>0){
									$follow_state = 1;
								}else{
									$follow_state = 0;
								}
								

							?>

							<div class="sns_one">
								<div>
									<div id="images" onclick="show_review(<?=$feed_id?>,<?=$review_ix?>);" style="cursor: pointer;">
										<div class="img_form">
											<img class="sns_img" style="background-image: url(<?=$main_img?>);" >
										</div>
									</div>
								</div>
								<div class="info">
									<div class="pro_form">
										<ul style="overflow: hidden;">
											<li class="pro">
												<div class="pro_img_form">
													<?php
													if($profile_img==""){
													?>
													<img src="https://www.docatdan.com/images/user/profile/profile_default.PNG" style="width: 100%; height: 100%;">
													<?php }else{
													?>
													<img src="<?=$profile_img?>" style="width: 100%; height: 100%;">
													<?php }?>
												</div>	
											</li>
											<li class="p_name">
												<div class="pro_info">
													<span><?=$nick?></span>
												</div>
											</li>
											<li class="p_follow">
												<div class="pro_follow">
													<?php
													if($user_id!=$usr_ix){
														if($follow_state==1){
														?>
														<span class="following_btn follow follow_<?=$usr_ix?>">팔로잉</span>
														<?php }else{
														?>
														<span class="follow_btn follow follow_<?=$usr_ix?>">팔로우</span>
														<?php
														}
													}?>
													
												</div>
											</li>
											<li class="p_date">
												<div class="pro_date">
													<p ><?=$date?></p>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="review_title">
									<div class="title_info">
										<h4><?=$title?></h4>
									</div>
									<div class="default_rating" style=" float: right;">
										<div class="rating_box">
											<div class="star m_text" style="width: 100%; overflow: hidden;">
												<?php 
												$rate10 = $rate * 10;
												$rate_num = $rate10/5;

												for($i=1; $i<=10; $i++){
													if($i<=$rate_num){
														if($i%2!=0){
												?>
														<span class="starR1 on">별1_왼쪽</span>
											  			<?php 
											  			}else{
											  			?>
											  			<span class="starR2 on">별1_오른쪽</span>
											  			<?php
											  			}
											  		}else{
											  			if($i%2!=0){?>
											  			<span class="starR1">별1_왼쪽</span>
											  			<?php
											  			}else{
											  			?>
											  			<span class="starR2">별1_오른쪽</span>
											  			<?php
											  			}
											  		}
											  		//$rate_num -= 1;
											  		?>
												<?php 
												}?>
											</div>		
										</div>
									</div>								
								</div>
								<div class="review_text">
									<div class="review_info">
										<span><?=$text?></span>
									</div>									
								</div>	
								<div class="sub_info_div">
									<div class="like" style="">
										<?php
										if($good_state==1){
										?>
										<div class="img_like" style="float: left;">
											<i class="fa fa-heart fa-lg like_btn like_<?=$feed_id?>" style="cursor: pointer;" id="like_<?=$feed_id?>"></i>
										</div>
										<span class="num_<?=$feed_id?>"><?=$good_num?></span>
										<?php }else{
										?>
										<div class="img_like" style="float: left;">
											<i class="fa fa-heart-o fa-lg like_btn like_<?=$feed_id?>" id="like_<?=$feed_id?>" style="cursor: pointer;"></i>
										</div>
										<span class="num_<?=$feed_id?>"><?=$good_num?></span>
										<?php }?>			
									</div>
									<div class="comment">
										<div class="img_comment" style="float: left;">
											<i class="fa fa-comment-o fa-lg"></i> 			
										</div>
										<span><?=$comment_number?></span>
									</div>
								</div>							
							</div>	
							<?php }
							?>						
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="plus_item" style="text-align: center;">
			<button style="border: 2px solid #DDD; border-radius: 15%;width: 120px; height: 40px; background-color: #fff; font-weight: bold; cursor: pointer;" onclick="view_more();">더보기</button>
		</div>	
   		<div class="ui modal add">
          	<div class="review_modal_form" >
          		<div class="image content">
              		<ul class="img_div">
	              		<li>
							<div class="img_form" style="width: 98%;">
								<div class="img_over1" id="back_file1">
									<form id="file_form1" method="post" enctype="multipart/form-data">
										<input type="file" id="file1" name="file1" accept="image/*" capture="camera" onchange="add_feed(this,0);">
									</form>

								</div>
							</div>
							
	                	</li>
	                	<li style="margin-top: 1%;">
	                		<ul>
	                			<li class="sub_img">
									<div class="img_form" style="width: 100%;">
										<div class="img_over" id="back_file2">
											<form id="file_form2" method="post" enctype="multipart/form-data">
												<input type="file" id="file2" name="file2" accept="image/*" capture="camera" onchange="add_feed(this,0);">
											</form>

										</div>
									</div>
	                			</li>
	                			<li class="sub_img">
									<div class="img_form" style="width: 100%;">
										<div class="img_over" id="back_file3">
											<form id="file_form3" method="post" enctype="multipart/form-data">
												<input type="file" id="file3" name="file3" accept="image/*" capture="camera" onchange="add_feed(this,0);">
											</form>

										</div>
									</div>
	                			</li>
	                			<li class="sub_img">
									<div class="img_form" style="width: 100%;">
										<div class="img_over" id="back_file4">
											<form id="file_form4" method="post" enctype="multipart/form-data">
												<input type="file" id="file4" name="file4" accept="image/*" capture="camera" onchange="add_feed(this,0);">
											</form>

										</div>
									</div>
	                			</li>
	                			<li class="sub_img">
									<div class="img_form" style="width: 100%;">
										<div class="img_over" id="back_file5">
											<form id="file_form5" method="post" enctype="multipart/form-data">
												<input type="file" id="file5" name="file5" accept="image/*" capture="camera" onchange="add_feed(this,0);">
											</form>

										</div>
									</div>
	                			</li>
	                			<li class="sub_img">
									<div class="img_form" style="width: 100%;">
										<div class="img_over" id="back_file6">
											<form id="file_form6" method="post" enctype="multipart/form-data">
												<input type="file" id="file6" name="file6" accept="image/*" capture="camera" onchange="add_feed(this,0);">
											</form>

										</div>
									</div>
	                			</li>
	                			<li class="sub_img">
									<div class="img_form" style="width: 100%;">
										<div class="img_over" id="back_file7">
											<form id="file_form7" method="post" enctype="multipart/form-data">
												<input type="file" id="file7" name="file7" accept="image/*" capture="camera" onchange="add_feed(this,0);">
											</form>
										</div>
									</div>
	                			</li>
	                			<li class="sub_img_last">
									<div class="img_form" style="width: 100%;">
										<div class="img_over" id="back_file8">
											<form id="file_form8" method="post" enctype="multipart/form-data">
												<input type="file" id="file8" name="file8" accept="image/*" capture="camera" onchange="add_feed(this,0);">
											</form>
										</div>
									</div>
	                			</li>
	                		</ul>
	                	</li>
	                </ul>
	                <div class="text_div">
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
													<input type="text" name="product_name" id="product_name" placeholder="상품명을 입력해주세요(필수)" class="m_text">	
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
													<input type="text" name="product_tag" placeholder="태그를 입력해주세요." id="product_tag" class="m_text">	
												</div>
											</div>
										</div>
										<div class="p_info">
											<div class="p_info_wrap">
												<div class="title">
													<label>평점</label>	
												</div>
												<div>
							            			<div class="starRev m_text" style="width: 80%;">
													  <span class="reR1">별1_왼쪽</span>
													  <span class="reR2">별1_오른쪽</span>
													  <span class="reR1">별2_왼쪽</span>
													  <span class="reR2">별2_오른쪽</span>
													  <span class="reR1">별3_왼쪽</span>
													  <span class="reR2">별3_오른쪽</span>
													  <span class="reR1">별4_왼쪽</span>
													  <span class="reR2">별4_오른쪽</span>
													  <span class="reR1">별5_왼쪽</span>
													  <span class="reR2">별5_오른쪽</span>
													</div>						            
												</div>
											</div>
										</div>
										
									</div>
								</form>
							</div>
						</div>
	                </div>
	           	</div>    		
          	</div>
           	<div class="actions">
             	<div class="ui cancel button" id="sns_upload">작성완료</div>
           	</div>
        </div>
        <div id="myModal" class="dcd_modal" >
	        <div class="modal-content">
	            <div class="content-wrap">
	                <article class="article-wrap">
	                    <!-- 프로필 사진, 닉네임, 팔로우버튼이 들어갈 곳 -->
	                    <div class="article-header">
	                        <section class="product-wrap">
	                            <h4 class="product-name"></h4>
	                            <div class="rating">
	                                <span class="starR1 on"></span>
	                                <span class="starR2 on"></span>
	                                <span class="starR1 on"></span>
	                                <span class="starR2 on"></span>
	                                <span class="starR1 on"></span>
	                                <span class="starR2 on"></span>
	                                <span class="starR1 on"></span>
	                                <span class="starR2 on"></span>
	                                <span class="starR1 on"></span>
	                                <span class="starR2 on"></span>
	                            </div>
	                            <div class="time-wrap">
                                    <a class="time-unit">
                                        <div class="time">
                                            5월 2일
                                        </div>
                                    </a>
                                </div>
	                        </section>
	                    </div>
	                    <!-- 게시물 -->
	                    <div class="post-wrap1">
	                        <div role="button" tabindex="0">
	                            <div class="post-wrap2">
	                                <div class="post-wrap3">
	                                    <div cass="post-wrap4">
	                                    	
                                			<div class="post_slick">
                                				<img class="post-img" src="https://scontent-hkg3-1.cdninstagram.com/vp/f452220e8237af7a71b8d8b03b9a5b34/5C8993FB/t51.2885-15/e35/31042921_1792682590794700_6739950001310400512_n.jpg" alt="요즘커피 좋아합니다">	
                                				<img class="post-img" src="https://scontent-hkg3-1.cdninstagram.com/vp/f452220e8237af7a71b8d8b03b9a5b34/5C8993FB/t51.2885-15/e35/31042921_1792682590794700_6739950001310400512_n.jpg" alt="요즘커피 좋아합니다">	
	                                    	</div>
                                	<!-- <divl id="visual">
                                		<div class="hidden_sm">
	                                    	<div class="main_visual">
	                                        	<img class="post-img" src="https://scontent-hkg3-1.cdninstagram.com/vp/f452220e8237af7a71b8d8b03b9a5b34/5C8993FB/t51.2885-15/e35/31042921_1792682590794700_6739950001310400512_n.jpg" alt="요즘커피 좋아합니다">
	                                        </div>
	                                    </div>
                                    </div> -->
                                		</div>
	                                  
	                                    <div class="post-wrap5"></div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- 게시글 -->
	                    <div class="postDesc-wrap">
	                        <section class="user-wrap">
	                            <div class="header-pic">
	                                <!-- <canvas class="canv" width="50" height="50" style="position: absolute; top: -5px; left: -5px; width: 50px; height: 50px;"> -->
	                                <a class="pic-content" href="" style="width: 40px; height: 40px;">
	                                    <img class="pic-img" src="" alt="">
	                                </a>
	                            </div>
	                            <div class="header-desc">
	                                <div class="desc-wrap">
	                                    <div class="nic-wrap">
	                                        <h2 class="nic-inline">
	                                            <a class="nic" href="">
	                                                h2jjun
	                                            </a>
	                                        </h2>
	                                    </div>
	                                    <div class="follow-wrap">
	                                        <button class="follow-btn">팔로우</button>
	                                    </div>
	                                    
	                                </div>
	                            </div>
	                        </section>
	                        <div class="review-wrap">
	                            <div class="review">
	                                텍스트
	                            </div>
	                            <br>
	                            <div class="hashtag" style="color: #0000ff;">
	                               	<ul class="tag_list">
	                               		
	                               	</ul>
	                            </div>
	                        </div>
	                        <section class="btn-wrap">
	                            <span class="likeBtn-box">
	                                <button class="like-btn">
	                                    <i class="fa fa-heart fa-lg"></i>
	                                    <!-- <i class="fas fa-heart fa-2x" style="color: red;"></i> -->
	                                </button>
	                            </span>
	                            <span class="commentBtn-box">
	                                <button class="comment-btn">
	                                    <i class="fa fa-comment-o fa-lg"> 0</i>
	                                </button>
	                            </span>
	                        </section>

	                        <div class="comment-wrap">
	                            <ul class="comment-list">
	                                
	                            </ul>

	                        </div>
	                        <section class="commentInput-wrap">
	                            <div class="commentInput-box">
	                                <form class="commentInput-form" action="">
	                                    <textarea class="commentInput" placeholder="댓글을 입력해주세요." name="review_comment" id="review_comment" autocomplete="off" onkeydown="resize(this)" onkeyup="resize(this)"></textarea>
	                                    <input type="submit" hidden="true" alt="">
	                                </form>
	                            </div>
	                        </section>
	                    </div>
	                </article>
	            </div>
	        </div>
	        <span class="close">&times;</span>
	    </div>
    	

    	<script type="text/javascript">
    		var paging = "<?=$page?>";
    		var ix = "<?=$user_id?>";
    		var user_nick = "<?=$user_nick?>";
    		var modal = document.getElementById('myModal');
    		var span = document.getElementsByClassName("close")[0];
    		var feed_ix;
    		
    		
    		
    		

    		span.onclick = function() {
	            modal.style.display = "none";
	        }

	        // When the user clicks anywhere outside of the modal, close it
	        window.onclick = function(event) {
	            if (event.target == modal) {
	                modal.style.display = "none";
	            }
	        }


    		

    		

			$('.starRev span').click(function(){
			  $(this).parent().children('span').removeClass('on');
			  $(this).addClass('on').prevAll('span').addClass('on');
			  return false;
			});

			$(function() {
				// main visual
				$('.post_slick').slick({
					dots: true
				});
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
		<button onclick="topFunction()" id="Top_Btn" title="Go to top" style="display: none; position: fixed; bottom: 20px; right: 30px; z-index: 99; font-size: 18px; border: none; outline: none; background-color: red; color: white; cursor: pointer; padding: 15px; border-radius: 4px;">Top
		</button>
	</body>
</html>
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
			</script>
