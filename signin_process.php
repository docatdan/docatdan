<?php
session_start();   //세션 시작
include("ollearDB.php");  //DB연결을 위한 config.php를 로드
if (mysqli_connect_errno()){
echo "연결실패<br>이유 : " . mysqli_connect_error();
}

$route = $_GET['route'];

if ($route == "email") {
    $user_email = $_POST["umail"];
    $user_password = md5($_POST["upw"]);

    if($user_email != ""){  // umail 값이 있으면
        $sql="select * from USER where email = '$user_email' and password = '$user_password'"; //이메일 값과 비번 값 대조
        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);

        $user_nick = $row['nick_name'];
        $user_id = $row['id'];
        $email_check = $row['email_check'];
        $user_level = $row['lv'];

         if($count==1) {
            $_SESSION['user_email'] = $user_email;
            $_SESSION['user_nick'] = $user_nick;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email_check'] = $email_check;
            $_SESSION['level'] = $user_level;
            header("location: ./");
        } else {
            $error="이메일주소 또는 비밀번호가 잘못되었습니다.";
            echo "<script>
                    alert('$error');
                    history.back();
                  </script>";
        }
    }
} else if ($route == "facebook") {
    $code = $_GET['code'];
    $nick = $_GET['nick'];

    if ($code != "") {
        $sql = "select * from USER_CODE where face_code = '$code'";
        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);

        if ($count==1) {
            $user_id = $row['id'];

            $sql = "select * from USER where id = '$user_id'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);

            $user_nick = $row['nick_name'];
            $user_level = $row['lv'];

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_nick'] = $user_nick;
            $_SESSION['level'] = $user_level;

            header("location: ./");
        } else {
            $sql_ins_code = "insert into USER_CODE (face_code) values ('$code')";
            mysqli_query($con, $sql_ins_code);

            $sql_sel_code = "select id from USER_CODE where face_code='$code'";
            $result = mysqli_query($con, $sql_sel_code);
            $row = mysqli_fetch_array($result);

            $user_id = $row['id'];
            $user_nick = $nick;
            $user_level = $row['lv'];

            $sql = "insert into USER (id,name,nick_name) values('$user_id','$user_nick','$user_nick')";
            mysqli_query($con, $sql);

            $sns_insert_sql = "insert into SNS_USER(profile_img,user_id,user_nick) values('','$user_id','$user_nick')";
            mysqli_query($con,$sns_insert_sql);

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_nick'] = $user_nick;
            $_SESSION['level'] = $user_level;

            header("location: ./");
        }
    }
} else if ($route == "naver") {
    $code = $_GET['code'];
    $nick = $_GET['nick'];

    if ($code != "") {
        $sql = "select * from USER_CODE where naver_code = '$code'";
        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);

        if ($count >= 1) {
            $user_id = $row['id'];

            $sql_sel_code = "select * from USER where id = '$user_id'";
            $result = mysqli_query($con, $sql_sel_code);
            $row = mysqli_fetch_array($result);

            $user_nick = $row['nick_name'];
            $user_level = $row['lv'];

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_nick'] = $user_nick;
            $_SESSION['level'] = $user_level;

            header("location: ./");
        } else {
            $sql_ins_code = "insert into USER_CODE (naver_code) values ('$code')";
            mysqli_query($con, $sql_ins_code);

            $sql_sel_code = "select id from USER_CODE where naver_code='$code'";
            $result = mysqli_query($con, $sql_sel_code);
            $row = mysqli_fetch_array($result);

            $user_id = $row['id'];
            $user_nick = $nick;
            $user_level = $row['lv'];

            $sql = "insert into USER (id,name,nick_name) values('$user_id','$user_nick','$user_nick')";
            mysqli_query($con, $sql);

            $sns_insert_sql = "insert into SNS_USER(profile_img,user_id,user_nick) values('','$user_id','$user_nick')";
            mysqli_query($con,$sns_insert_sql);

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_nick'] = $user_nick;
            $_SESSION['level'] = $user_level;

            header("location: ./");
        }
    }
}
?>
