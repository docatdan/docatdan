<?php
session_start();
include_once('ollearDB.php');
include_once('./PHPMailer/PHPMailerAutoload.php');

$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];
$user_nick = $_SESSION['user_nick'];

$umail = $_POST['umail'];
$mode = $_POST['mode'];

if($mode=='findpwd'){
    if ($umail != "") {
        $ses_sql=mysqli_query($con, "select * from USER where email='$umail'");
        $row = mysqli_fetch_array($ses_sql);
        $id = $row['id'];

        $mail = new PHPMailer(); // defaults to using php "mail()"

            $mail->IsSMTP();
        //  $mail->SMTPDebug = 2;
            $mail->SMTPSecure = "ssl";
            $mail->SMTPAuth = true;

            $mail->Host = "smtp.naver.com";
            $mail->Port = 465;
            $mail->Username = "quadh";
            $mail->Password = "znjemdpdlcl1";

            $mail->CharSet = 'UTF-8';
            $mail->From = "quadh@naver.com";
            $mail->FromName = "독캣단";
            $mail->Subject = "[독캣단] 비밀번호 다시 설정하러 가기";
            $mail->AltBody = ""; // optional, comment out and test
            $mail->msgHTML('
                <div style="font-family: Malgun Gothic, Apple Gothic, sans-serif; background-color: white; border: 6px solid #DC143C; width: 800px; margin: 50px auto; padding-top: 0; padding-bottom: 0; padding-left: 50px; padding-right: 50px; text-align: center; word-spacing: 3px;">
                    <div style="margin-top: 100px; margin-bottom: 30px;">
                        <img src="./images/dog_logo.png">
                    </div>
                    <div style="padding: 0; background-color: white; border: 3px solid #000000; width: auto; height: auto;">
                        <p style="color: #222222; font-size: 22px; margin-top: 16px; margin-bottom: 16px; margin-left: 30px; margin-right: 30px;">
                            [독캣단]&nbsp;비밀번호&nbsp;다시&nbsp;설정하러가기
                        </p>
                    </div>
                    <div style="margin-top: 70px; margin-bottom: 20px; color: #222222; font-size: 20px; line-height: 1.5em;">
                        <p>인플루언서들과&nbsp;함께&nbsp;하는&nbsp;독캣단입니다.</p>
                    </div>
                    <div style="margin-top: 0; margin-bottom: 0; color: #222222; font-size: 18px; line-height: 1.5em;">
                        <p>회원님의&nbsp;비밀번호를&nbsp;다시&nbsp;설정하세요.</p>
                    </div>
                    <div>
                        <form action="https://heejun92.cafe24.com/alterPw.php" method="post">
                            <input type="hidden" name="id" value="'.$id.'">
                            <button type="submit" style="padding: 0px 50px; margin-top: 50px; margin-bottom: 60px; background-color: #DC143C; font-size: 24px; color: white; height: 70px;">
                                <span>비밀번호 재설정하기</span>
                            </button>
                        </form>
                    </div>
                    <div style="background-color: #f5f5f5; border: 1px solid #DC143C; width: auto; margin-bottom: 70px;">
                        <p style="margin-top: 25px; margin-left: 30px; margin-right: 30px; color: #222222; font-size: 18px; line-height: 1.5em;">
                            문의하실&nbsp;사항은
                            <strong>
                                quadh@naver.com
                            </strong>
                            로
                        </p>
                        <p style="margin-bottom: 25px; margin-left: 30px; margin-right: 30px; color: #222222; font-size: 18px; line-height: 1.5em;">
                            문의해주시기&nbsp;바랍니다.
                        </p>
                    </div>
                    <div style="color: #DC143C; font-size: 16px; margin-bottom: 40px;">
                        ©&nbsp;독캣단
                    </div>
                </div>
                ');
            $mail->addAddress("$umail");

            $mail->send();

            echo "<script>alert('이메일이 정상적으로 전송되었습니다.'); window.location.replace('signin');</script>";
    } else {
        alert("이메일을 입력해주세요.");
        echo "<script>history.back();</script>";
    }

//샘플신청시에 이메일 인증
}else if($mode=='certification'){

    //이메일 인증시 이메일 중복검사 
    $email_overlap_sql = "select id from USER where email_check='$umail'";
    $email_overlap_re = mysqli_query($con,$email_overlap_sql);
    $overlap_num = mysqli_num_rows($email_overlap_re);

    //이미 인증된 이메일이 있는경우
    $over_ary = array();
    if($overlap_num>0){
        

    }else{
        
        if ($umail != "") {
        $ses_sql=mysqli_query($con, "select * from USER where email='$umail'");
        $row = mysqli_fetch_array($ses_sql);
        $id = $row['id'];

        $check_num = generateRandomString(6); //인증코드 랜덤으로 생성 

        $mail = new PHPMailer(); // defaults to using php "mail()"

        $mail->IsSMTP();
    //  $mail->SMTPDebug = 2;
        $mail->SMTPSecure = "ssl";
        $mail->SMTPAuth = true;

        $mail->Host = "smtp.naver.com";
        $mail->Port = 465;
        $mail->Username = "quadh";
        $mail->Password = "znjemdpdlcl1";

        $mail->CharSet = 'UTF-8';
        $mail->From = "quadh@naver.com";
        $mail->FromName = "독캣단";
        $mail->Subject = "[독캣단] 이메일 인증번호 입니다.";
        $mail->AltBody = ""; // optional, comment out and test
        $mail->msgHTML('
            <div style="font-family: Malgun Gothic, Apple Gothic, sans-serif; background-color: white; border: 6px solid #DC143C; width: 800px; margin: 50px auto; padding-top: 0; padding-bottom: 0; padding-left: 50px; padding-right: 50px; text-align: center; word-spacing: 3px;">
                <div style="margin-top: 100px; margin-bottom: 30px;">
                    <img src="./images/dog_logo.png">
                </div>
                <div style="padding: 0; background-color: white; border: 3px solid #000000; width: auto; height: auto;">
                    <p style="color: #222222; font-size: 22px; margin-top: 16px; margin-bottom: 16px; margin-left: 30px; margin-right: 30px;">
                        [독캣단]&nbsp;이메일&nbsp;인증번호&nbsp;입니다.
                    </p>
                </div>
                <div style="margin-top: 70px; margin-bottom: 20px; color: #222222; font-size: 20px; line-height: 1.5em;">
                    <p>인플루언서들과&nbsp;함께&nbsp;하는&nbsp;독캣단입니다.</p>
                </div>
                <div style="margin-top: 0; margin-bottom: 0; color: #222222; font-size: 18px; line-height: 1.5em;">
                    <p>회원님의&nbsp;인증번호&nbsp;입니다.</p>
                </div>
                <div>
                    <p style="color:#0000ff; font-size:20px; margin-top:25px; margin-bottom:25px;">'.$check_num.'</p>
                </div>
                <div style="background-color: #f5f5f5; border: 1px solid #DC143C; width: auto; margin-bottom: 70px;">
                    <p style="margin-top: 25px; margin-left: 30px; margin-right: 30px; color: #222222; font-size: 18px; line-height: 1.5em;">
                        문의하실&nbsp;사항은
                        <strong>
                            quadh@naver.com
                        </strong>
                        로
                    </p>
                    <p style="margin-bottom: 25px; margin-left: 30px; margin-right: 30px; color: #222222; font-size: 18px; line-height: 1.5em;">
                        문의해주시기&nbsp;바랍니다.
                    </p>
                </div>
                <div style="color: #DC143C; font-size: 16px; margin-bottom: 40px;">
                    ©&nbsp;독캣단
                </div>
            </div>
            ');
        $mail->addAddress("$umail");

        $mail->send();

        setcookie("email_code",$check_num,time()+120); //유저 메일의 코드와 비교하기위해 쿠키 생성

        $over_ary['over'] = 'not';
        echo json_encode($over_ary, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        //echo "<script>alert('이메일이 정상적으로 전송되었습니다.'); window.location.replace('signin.php');</script>";
        } else {
            alert("이메일을 입력해주세요.");
            echo "<script>history.back();</script>";
        }
    }

  
    
//인증메일을 작성후 유저가 인증코드를 확인하는 작업
}else if($mode=='code'){
    $code_cookie = $_COOKIE['email_code'];
    $my_code = $_POST['code'];

    $array = array();
    if($code_cookie==$my_code){        
        $array['email'] = "ok";

        $email_up_sql = "update USER set email_check='$umail' where id='$user_id'";
        mysqli_query($con,$email_up_sql);

        $_SESSION['email_check'] = $umail;

    }else{
        $array['email'] = "no";
    }
    echo json_encode($array, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

}

//고유스트링 5개를 생성하는 함수 => 같은 이름의 이미지라도 구분하기 위함, 이미지 명은 생성날짜+고유번호+이미지이름
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



?>
