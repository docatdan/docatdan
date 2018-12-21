<!DOCTYPE html>
<?php
session_start();
include 'ollearDB.php';

$user_info_sql = "select * from USER where id='$user_id'";
$result = mysqli_query($con, $user_info_sql);
$row = mysqli_fetch_array($result);

$nickName = $row['nick_name'];
$phoneNum = $row['phone'];
$email = $row['email'];

$user_img_sql = "select profile_img from SNS_USER where user_id='$user_id'";
$result_img = mysqli_query($con, $user_img_sql);
$row_img = mysqli_fetch_array($result_img);

$profileImg = $row_img['profile_img'];
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
        <link rel="stylesheet" type="text/css" href="semantic-ui/semantic.min.css">


        <script
          src="https://code.jquery.com/jquery-3.1.1.min.js"
          integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
          crossorigin="anonymous"></script>
        <script src="semantic-ui/semantic.min.js"></script>


        <script src="./js/jquery-1.8.3.min.js"></script>
        <script src="./js/jQuery.thisweb.js"></script>


    </head>

    <body>
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
                        <li><a href="/review/feed">리뷰</a></li>
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
                        <li><a href="/review/feed">리뷰</a></li>
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


        <div id="mypage_sub">
            <div id="guide" class="wrap">
                <ul class="menu">
                  <!--   <li><a href="./mypage_sns.php">SNS</a></li> -->
                    <li><a href="./mypage_spon">협찬내역</a></li>
                    <li><a href="./mypage_shop">구매내역</a></li>
                    <li class="on"><a href="./mypage_info">정보수정</a></li>
                </ul>

                <div id="guide_cont">
                    <div class="title">
                        <h3>프로필 수정</h3>
                    </div>

                    <div id="guide_tab">
                        <form class="edit_content" action="infoEdit_ok.php" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="mode" value="profile">
                          <div class="edit_pic">
                            <a href="">
                              <?php
                              if ($profileImg != '') {
                                ?>
                              <input type="file" id="file" name="profile_img" onchange="changeValue(this)" style="display: none;">
                              <img src="<?= $profileImg ?>" width="150" height="150" id="profile_img">
                              <i class="corner camera icon large" id="profile_icon"></i>
                              <?php } else { ?>
                              <input type="file" id="file" name="profile_img" onchange="changeValue(this)" style="display: none;">
                              <img src="images/user/profile/profile_default.PNG" width="150" height="150" id="profile_img">
                              <i class="corner camera icon large" id="profile_icon"></i>
                              <?php
                              }
                              ?>
                            </a>
                          </div>
                          <div class="edit_column">
                            <div class="edit_nic nick_name">
                              <label class="nic_title">별명</label>
                              <div class="ui input" style="float: right;">
                                <input type="text" name="nick_name" value="<?= $nickName ?>">
                              </div>
                            </div>
                            <div class="edit_nic">
                              <label class="nic_title">핸드폰번호</label>
                              <!-- <button class="ui button" id="imp_certification" style="float: right; margin-left: 10px;">인증하기</button> -->
                              <div class="ui input" style="float: right;">
                                <input type="text" name="phone_num" value="<?= $phoneNum ?>">
                              </div>
                            </div>
                            <div class="edit_nic">
                              <label class="nic_title">이메일</label>
                             <!--  <button class="ui button" style="float: right; margin-left: 10px;">인증하기</button> -->
                              <div class="ui input" style="float: right;">
                                <input type="text" name="email" value="<?= $email ?>">
                              </div>
                            </div>
                          </div>
                          <div class="ok_can_btn" style="text-align: center;">
                            <input type="submit" class="ui button" value="변경">
                            <a href="mypage_info" class="ui button">취소</a>
                          </div>
                        </form>
                    </div>
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
        <script>
            $(function () {
                $('#profile_img').click(function (e) {
                    e.preventDefault();
                    $('#file').click();
                });
            });

            $(function () {
                $('#profile_icon').click(function (e) {
                    e.preventDefault();
                    $('#file').click();
                });
            });

            function changeValue(obj){
              // alert(obj.value);
            }

            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#profile_img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#file").change(function(){
                readURL(this);
            });
        </script>
    </body>
</html>
