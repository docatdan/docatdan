<!DOCTYPE html>
<?php
session_start();
include 'ollearDB.php';


$user_info_sql = "select * from USER where id='$user_id'";
$result = mysqli_query($con, $user_info_sql);
$row = mysqli_fetch_array($result);

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
        <script src="./js/site.js"></script>
        <script src="./js/jQuery.thisweb.js"></script>
        <script src="./js/slick.js"></script>

    </head>

    <body>
        <div class="header_wrap">
          <div id="header">
              <h4 id="logo" ><a href="/"><img src="https://www.docatdan.com/images/newLogo.png" style="width: 108px;"></a></h4>

              <p class="navBtn"><i class="xi-bars"></i></p>

              <div class="nav_wrap">
                  <i class="xi-close"></i>
                    <ul id="nav">
                        <?php
                        if (!isset($user_id)) {
                        ?>
                        <li><a href="about">소개</a></li>
                        <li><a href="/docatmall/mall_home">독캣몰</a></li>
                        <li><a href="/review/feed">SNS</a></li>
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
                        <li><a href="/review/feed">SNS</a></li>
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
                    <li><a href="./mypage_spon">협찬내역</a></li>
                    <li><a href="./mypage_shop">구매내역</a></li>
                    <li class="on"><a href="./mypage_info">정보수정</a></li>
                </ul>

                <div id="guide_cont">
                    <div class="title">
                        <h3>회원 탈퇴</h3>
                    </div>

                    <div id="guide_tab">
                        <div class="content">
                          <div class="user_retire">
                            <form action="user_retire_ok.php" method="post" name="bfrm">
                              <input type="hidden" name="user_id" value="<?=$user_id?>">
                              <select name="retire_reason">
                                <option value="" selected="false" disabled="true" style="text-align: center;">탈퇴 사유를 선택해주세요 </option>
                                <option>서비스를 더이상 사용하지 않습니다.</option>
                                <option>재가입 하고 싶습니다.</option>
                                <option>상품이 다양하지 않습니다.</option>
                                <option>협찬이 되지 않습니다.</option>
                                <option>협찬 받을 만한 상품이 없습니다.</option>
                                <option>리뷰 쓰기가 힘듭니다.</option>
                              </select>
                              <h4 style="margin-top: 3%;">구체적인 탈퇴사유를 적어주세요<p style="margin-top: 1%;">더 나은 독캣단이 되겠습니다.</p></h4>
                              <div>
                                <textarea placeholder="탈퇴사유를 적어주세요" name="retire_reason2"></textarea>
                              </div>
                              <div style="margin-top: 3%;">
                                <!-- <button style="background-color: #16192d;">탈퇴</button>
                                <button style="background-color: #aaa;">취소</button> -->
                                <input type="submit" value="탈퇴" style="background-color: #16192d;">
                                <input type="button" value="취소" style="background-color: #aaa;" onclick="back();">
                              </div>
                            </form>
                          </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div id="insta"></div>





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
          function back(){
            location.href ="./mypage_info";
          }



        </script>

    </body>
</html>
