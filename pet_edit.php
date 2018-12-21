<!DOCTYPE html>
<?php
session_start();
include 'ollearDB.php';


$user_info_sql = "select * from USER where id='$user_id'";
$result = mysqli_query($con, $user_info_sql);
$row = mysqli_fetch_array($result);

$pet_img = $row['pet_img'];
$pet_name = $row['pet_name'];
$pet_breed = $row['pet_breed'];
$pet_sex = $row['pet_sex'];
$pet_age = $row['pet_age'];

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
                      <li><a href="">소개</a></li>
                      <li><a href="/docatmall/mall_home">독캣몰</a></li>
                      <li><a href="/review/feed">리뷰</a></li>
                      <li><a href="service">가이드</a></li>
                      <li><a href="https://www.allear.co">제휴문의</a></li>
                    </ul>
                    <div id="nav_right">
                      <ul class="link">
                        <li><a href="mypage_sns">마이페이지</a></li>
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
                    <!-- <li><a href="./mypage_sns">SNS</a></li> -->
                    <li><a href="./mypage_spon">협찬내역</a></li>
                    <li><a href="./mypage_shop">구매내역</a></li>
                    <li class="on"><a href="./mypage_info">정보수정</a></li>
                </ul>

                <div id="guide_cont">
                    <div class="title">
                        <h3>반려동물 프로필 수정</h3>
                    </div>

                    <div id="guide_tab">
                        <form class="edit_content" action="infoEdit_ok.php" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="mode" value="pet">
                          <div class="edit_pic">
                            <a href="">
                              <?php
                              if ($pet_img != '') {
                              ?>
                              <input type="file" id="file" name="pet_img" onchange="changeValue(this)" style="display: none;">
                              <img src="<?= $pet_img ?>" width="150" height="150" id="pet_img">
                              <i class="corner camera icon large"></i>
                              <?php } else { ?>
                              <input type="file" id="file" name="pet_img" onchange="changeValue(this)" style="display: none;">
                              <img src="https://static.nid.naver.com/images/web/user/default.png" width="150" height="150" id="pet_img">
                              <i class="corner camera icon large"></i>
                              <?php
                              }
                              ?>
                            </a>
                          </div>
                          <div class="edit_column">
                            <div class="edit_nic" style="width: 288px;">
                              <label class="nic_title">이름</label>
                              <div class="ui input" style="float: right;">
                                <input type="text" name="pet_name" value="<?= $pet_name ?>">
                              </div>
                            </div>
                            <div class="edit_nic" style="width: 288px;">
                              <label class="nic_title">종</label>
                              <div class="ui input" style="float: right;">
                                <input type="text" name="pet_breed" value="<?= $pet_breed ?>">
                              </div>
                            </div>
                            <div class="edit_nic" style="width: 288px;">
                              <div class="ui form">
                                <div class="inline fields">
                                  <label class="nic_title" style="margin-right: 90px;">성별</label>
                                    <?php
                                    if ($pet_sex == 0) {
                                    ?>
                                  <div class="field">
                                    <div class="ui radio checkbox">
                                      <input type="radio" name="pet_sex" checked="checked" value="0">
                                      <label>남</label>
                                    </div>
                                  </div>
                                  <div class="field">
                                    <div class="ui radio checkbox">
                                      <input type="radio" name="pet_sex" value="1">
                                      <label>여</label>
                                    </div>
                                  </div>
                                  <?php
                                  } else {
                                  ?>
                                  <div class="field">
                                    <div class="ui radio checkbox">
                                      <input type="radio" name="pet_sex" value="0">
                                      <label>남</label>
                                    </div>
                                  </div>
                                  <div class="field">
                                    <div class="ui radio checkbox">
                                      <input type="radio" name="pet_sex" checked="checked" value="1">
                                      <label>여</label>
                                    </div>
                                  </div>
                                  <?php
                                  }
                                  ?>
                                </div>
                              </div>
                            </div>
                            <div class="edit_nic" style="width: 288px;">
                              <label class="nic_title" style="margin-right: 90px;">나이</label>
                              <div class="ui input">
                                <input type="number" name="pet_age" value="<?= $pet_age ?>" min="0" max="20">
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
                $('#pet_img').click(function (e) {
                    e.preventDefault();
                    $('#file').click();
                });
            });

            function changeValue(obj){
              alert(obj.value);
            }
        </script>
    </body>
</html>
