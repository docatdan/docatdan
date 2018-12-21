<!DOCTYPE html>
<?php
session_start();
include 'ollearDB.php';

$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];
$user_nick = $_SESSION['user_nick'];

$user_info_sql = "select * from USER where id='$user_id'";
$result = mysqli_query($con, $user_info_sql);
$row = mysqli_fetch_array($result);


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
                        <h3>배송지 수정</h3>
                    </div>

                    <div id="guide_tab">
                        <form class="edit_content" action="infoEdit_ok.php" method="post" enctype="multipart/form-data" style="margin-left: 0px;">
                          <input type="hidden" name="mode" value="shipping">
                            <table border="1">
                               <tr class="tb_header">
                                  <th style="width: 25%;">배송지 이름</th>
                                  <th style="width: 50%;">주소지</th>
                                  <th style="width: 25%;"></th>
                               </tr>

                               <tr>
                                  <td class="shipping_name">
                                    <i class="icon truck"></i>
                                    배송지1
                                  </td>
                                  <td class="shipping_desc">
                                    <div id="main_add1">
                                    <?php
                                    if($row['main_zipcode']==""){
                                      echo "주소지 입력";
                                    } else {
                                    ?>
                                    <?=$row['main_add1'].", ".$row['main_add2']?>
                                    <?php }?>
                                    </div>
                                  </td>
                                  <td><input type="button" class="ui button" name="main_add" id="main_add" value="주소설정" onclick="search_address('main');"></td>
                               </tr>

                               <tr>
                                  <td class="shipping_name">
                                    <i class="icon truck"></i>
                                    배송지2
                                  </td>
                                  <td class="shipping_desc">
                                    <div id="sub_add1">
                                    <?php
                                    if($row['sub_zipcode']==""){
                                      echo "주소지 입력";
                                    } else {
                                    ?>
                                    <?=$row['sub_add1'].", ".$row['sub_add2']?>
                                    <?php }?>
                                    </div>
                                  </td>
                                  <td><input type="button" class="ui button" name="main_add" id="main_add" value="주소설정" onclick="search_address('sub');"></td>
                               </tr>
                            </table>
                          <div style="margin-top: 30px; text-align: center; width: 100%;">
                            <a href="mypage_info" class="ui button">완료</a>
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
            function search_address(mode){
                var add_mode = mode;
                     // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
                     // 예제를 참고하여 다양한 활용법을 확인해 보세요.
                var popUrl = "address_popup?add_mode="+add_mode;  //팝업창에 출력될 페이지 URL
                var popOption = "width=500, height=360, resizable=no, scrollbars=no, status=no";    //팝업창 옵션(optoin)
                var win = window.open(popUrl,"",popOption);
            }
        </script>
    </body>
</html>
