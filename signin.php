<?php
//페이스북 로그인 api
require_once __DIR__ . '/Facebook/autoload.php';

if (!session_id()) {
    session_start();
}

$fb = new Facebook\Facebook([
  'app_id' => '218431232155082', // Replace {app-id} with your app id
  'app_secret' => 'bdc1750aa30888c743cca7a86bef9cd8',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://docatdan.com/fb-callback.php', $permissions);

//네이버 로그인 api
$client_id = "6u0CjbBDDRx8KX5uWsNN"; // 위에서 발급받은 Client ID 입력
$redirectURI = urlencode("https://docatdan.com/naver_login_callback.php"); //자신의 Callback URL 입력
$state = "RAMDOM_STATE";
$apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;
?>

<!DOCTYPE html>
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
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" />

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

        <style>
            /* Shared */
            .loginBtn {
              box-sizing: border-box;
              position: relative;
              /* width: 13em;  - apply for fixed size */
              margin: 0.2em;
              padding: 0 15px 0 46px;
              border: none;
              line-height: 34px;
              white-space: nowrap;
              border-radius: 0.2em;
              font-size: 15px;
              font-family: 'NanumBarunGothic', 'NanumSquare', 'Malgun Gothic', sans-serif;
              color: #FFF;
              cursor: pointer;
              width: 200px;
              text-align: center;
              float: left;
            }
            .loginBtn:before {
              content: "";
              box-sizing: border-box;
              position: absolute;
              top: 0;
              left: 0;
              width: 34px;
              height: 100%;
            }
            .loginBtn:focus {
              outline: none;
            }
            .loginBtn:active {
              box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
            }


            /* Facebook */
            .loginBtn--facebook {
              background-color: #4C69BA;
              background-image: linear-gradient(#4C69BA, #3B55A0);
              /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
              /*text-shadow: 0 -1px 0 #354C8C;*/
              margin-left: 20px;
            }
            .loginBtn--facebook:before {
              border-right: #364e92 1px solid;
              background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
            }

            /* Naver */
            .loginBtn--naver {
              background-color: #1EC800;
              /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
              /*text-shadow: 0 -1px 0 #354C8C;*/
              margin-left: 10px;
            }
            .loginBtn--naver:before {
              border-right: #999999 1px solid;
              background: url('./images/naver_login_icon.PNG') 6px 6px no-repeat;
            }
        </style>

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


        <div id="sub">
            <div id="login_wrap" class="wrap">

                <div class="login_info">
                    <h2>로그인</h2>
                </div>

                <div class="login_form">
                    <form class="form" action="signin_process.php?route=email" name="submitform" method="post">
                        <input type="text" name="umail" id="umail" placeholder="Email">
                        <input type="password" name="upw" id="upw" placeholder="Password">
                        <input type="submit" value="로그인" class="login_btn">
                    </form>
                </div>

                <div class="signup">
                    <a href="signup" style="color: #aaabaf;">가입을 원하시나요?</a>
                </div>
                <div class="find_pwd">
                    <a href="findpw" style="color: #aaabaf;">비밀번호 찾기</a>
                </div>

                <div class="sns_login" style="margin-top: 50px;">
                    <div>
                        <a href="<?php echo htmlspecialchars($loginUrl) ?>">
                            <button class="loginBtn loginBtn--facebook">페이스북으로 로그인</button>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $apiURL ?>">
                        <button class="loginBtn loginBtn--naver">네이버로 로그인</button>
                        </a>
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
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = 'https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v3.1&appId=218431232155082&autoLogAppEvents=1';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <script type="text/javascript">

            jQuery( function($) { // HTML 문서를 모두 읽으면 포함한 코드를 실행

                // 정규식을 변수에 할당
                // 정규식을 직접 작성할 줄 알면 참 좋겠지만
                // 변수 우측에 할당된 정규식은 검색하면 쉽게 찾을 수 있다
                // 이 변수들의 활약상을 기대한다
                // 변수 이름을 're_'로 정한것은 'Reguar Expression'의 머릿글자
                var re_pw = /^[a-z0-9_-]{6,18}$/; // 비밀번호 검사식
                var re_mail = /^([\w\.-]+)@([a-z\d\.-]+)\.([a-z\.]{2,6})$/; // 이메일 검사식

                // 선택할 요소를 변수에 할당
                // 변수에 할당하지 않으면 매번 HTML 요소를 선택해야 하기 때문에 귀찮고 성능에도 좋지 않다
                // 쉼표를 이용해서 여러 변수를 한 번에 선언할 수 있다
                // 보기 좋으라고 쉼표 단위로 줄을 바꿨다
                var
                    form = $('.form'),
                    upw = $('#upw'),
                    umail = $('#umail');
                // 선택한 form에 서밋 이벤트가 발생하면 실행한다
                // if (사용자 입력 값이 정규식 검사에 의해 참이 아니면) {포함한 코드를 실행}
                // if 조건절 안의 '정규식.test(검사할값)' 형식은 true 또는 false를 반환한다
                // if 조건절 안의 검사 결과가 '!= true' 참이 아니면 {...} 실행
                // 사용자 입력 값이 참이 아니면 alert을 띄운다
                // 사용자 입력 값이 참이 아니면 오류가 발생한 input으로 포커스를 보낸다
                // 사용자 입력 값이 참이 아니면 form 서밋을 중단한다
                form.submit( function() {

                    if(re_mail.test(umail.val()) != true || umail.val()=="") { // 이메일 검사
                        alert('[Email 입력 오류] 유효한 이메일 주소를 입력해 주세요.');
                        umail.focus();
                        return false;
                    } else if(re_pw.test(upw.val()) != true || umail.val()=="") { // 비밀번호 검사
                        alert('[PW 입력 오류] 유효한 PW를 입력해 주세요.');
                        upw.focus();
                        return false;
                    }
                });

            });

        </script>
    </body>
</html>
