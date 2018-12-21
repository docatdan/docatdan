<!DOCTYPE html>
<?php
session_start();
include 'ollearDB.php';
if (mysqli_connect_errno()) {
    echo "연결실패<br>이유 : " . mysqli_connect_error();
}

$user_id = $_SESSION['user_id'];
$user_nick = $_SESSION['user_nick'];

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
        <link rel="stylesheet" href="./css/sns.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
        <link rel="stylesheet" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">
        <link rel="stylesheet" href="https://heejun92.cafe24.com/semantic-ui/semantic.min.css">


        <script src="./js/jquery-1.8.3.min.js"></script>
        <script src="./js/site.js"></script>
        <script src="./js/jQuery.thisweb.js"></script>
        <script src="./js/slick.js"></script>
        <script src="https://heejun92.cafe24.com/semantic-ui/semantic.min.js"></script>

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
                        <li><a href="mall_home">독캣몰</a></li>
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
                        <li><a href="mall_home">독캣몰</a></li>
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
        <script type="text/javascript">
            var img_array = new Array();
            var img_num_array = new Array();

            var img_count;

            <?php
                $get_mysns_sql = "select SNS_FILE.ix,text,date,tag,SNS_FEED.good_num,SNS_FILE.feed_id,SNS_USER.user_id,SNS_USER.user_nick,SNS_USER.profile_img from SNS_FEED join SNS_FILE join SNS_USER on SNS_FEED.ix = SNS_FILE.feed_id and SNS_FILE.show_num='0' and SNS_USER.user_id=SNS_FEED.user_ix order by date desc";
                $get_mysns_result = mysqli_query($con,$get_mysns_sql);
                $num_mysns = mysqli_num_rows($get_mysns_result);//게시글 갯수

                $num_count = 0; //게시글 카운터 수 => 증가한다.
                while($get_mysns_row=mysqli_fetch_array($get_mysns_result)){
                    $ix = $get_mysns_row['ix'];
                    $feed_id = $get_mysns_row['feed_id'];
                    $text = $get_mysns_row['text'];
                    $date = $get_mysns_row['date'];
                    $tag = $get_mysns_row['tag'];
                    $good_number = $get_mysns_row['good_num'];
                    $usr_nick = $get_mysns_row['user_nick'];
                    $usr_proimg = $get_mysns_row['profile_img'];
                    $usr_ix = $get_mysns_row['user_id'];


                    //해당 게시글에 이미지가 총 몇개있는지 확인하는 쿼리
                    $get_all_img_sql ="select file_link from SNS_FILE where feed_id='$feed_id' order by show_num asc";
                    $get_all_img_result = mysqli_query($con,$get_all_img_sql);
                    $all_img_num = mysqli_num_rows($get_all_img_result);

                    //내가 이 게시글에 대한 좋아요 상태 확인 쿼리
                    $check_good_sql = "select good_state from SNS_GOOD where user_ix='$user_id' and feed_ix='$feed_id'";
                    $check_good_result = mysqli_query($con,$check_good_sql);
                    $check_good_row = mysqli_fetch_array($check_good_result);
                    $good_state = $check_good_row['good_state'];

                    //내가 해당유저를 팔로워 했는지 체크 쿼리
                    $check_follow_sql = "select follow_state from SNS_RELATION where user_ix='$user_id' and follow_ix='$usr_ix'";
                    $check_follow_result = mysqli_query($con,$check_follow_sql);
                    $check_follow_row = mysqli_fetch_array($check_follow_result);
                    $follow_state = $check_follow_row['follow_state'];



                    ?>
                    img_array[<?=$ix?>] = new Array();
                    img_array['usr_nick_'+<?=$usr_ix?>] = new Array();
                    img_num_array[<?=$num_count?>] = "<?=$ix?>";

                    img_array[<?=$ix?>][3] = "<?=$all_img_num?>";
                    <?php
                    $num_count += 1;
                    //게시글 이미지 개수대로 배열에 할당
                    for($i=0; $i<$all_img_num; $i++){
                        $img_num = $i+6;
                        $get_all_img_row = mysqli_fetch_array($get_all_img_result);
                        $img_link = $get_all_img_row['file_link'];

                    ?>


                        img_array[<?=$ix?>][<?=$img_num?>] = "<?=$img_link?>";

                    <?php
                    }
                    //진짜 게시글의 ix 받기
                    $real_ix_sql = "select feed_id from SNS_FILE where ix='$ix'";
                    $real_ix_result = mysqli_query($con,$real_ix_sql);
                    $real_ix_row = mysqli_fetch_array($real_ix_result);
                    $real_ix = $real_ix_row['feed_id'];

                    $comment_sql = "select user_nick,comment from SNS_COMMENT join SNS_USER on SNS_COMMENT.feed_ix='$real_ix' and SNS_COMMENT.user_ix=SNS_USER.user_id";

                    $comment_result = mysqli_query($con,$comment_sql);
                    $comment_number = mysqli_num_rows($comment_result); //해당 게시글에 대한 댓글 수

                    ?>
                        img_array[<?=$ix?>][14] = "<?=$comment_number?>";

                    <?php
                    for($i=0; $i<($comment_number*2); $i+=2){
                        $nick_number = $i+15;
                        $text_number = $i+16;
                        $get_comment_row = mysqli_fetch_array($comment_result);
                        $nick = $get_comment_row['user_nick'];
                        $comment = $get_comment_row['comment'];
                    ?>

                        img_array[<?=$ix?>][<?=$nick_number?>] = "<?=$nick?>";
                        img_array[<?=$ix?>][<?=$text_number?>] = "<?=$comment?>";

                    <?php
                    } ?>


                    img_array[<?=$ix?>][0] = "<?=$text?>";
                    img_array[<?=$ix?>][1] = "<?=$tag?>";
                    img_array[<?=$ix?>][2] = "<?=$date?>";
                    img_array[<?=$ix?>][4] = "<?=$good_number?>";
                    img_array[<?=$ix?>][5] = "<?=$good_state?>";
                    img_array[<?=$ix?>]['nick'] = "<?=$usr_nick?>";
                    img_array[<?=$ix?>]['profile_img'] = "<?=$profile_img?>";
                    img_array[<?=$ix?>]['usr_ix'] = "<?=$usr_ix?>";
                    img_array['usr_nick_'+<?=$usr_ix?>]['follow_state'] = "<?=$follow_state?>";
            <?php }?>
            img_count = "<?=$num_mysns?>";

        </script>


        <div id="sns_sub">
            <div id="sns" class="wrap">
                <div id="sns_form" class="wrap">
                    <h2 class="SNSQK">둘러보기<a href="./mypage_sns" style="float: right;" class="SNSQK">내 프로필 보기 ></a></h2>
                    <div class="all">
                        <?php
                        $feed_number = 0;
                        $get_mysns_sql = "select*from SNS_FEED join SNS_FILE on SNS_FEED.ix = SNS_FILE.feed_id and SNS_FILE.show_num='0' order by date desc";
                        $get_mysns_result = mysqli_query($con,$get_mysns_sql);
                        while($get_mysns_row=mysqli_fetch_array($get_mysns_result)){
                            $feed_ix = $get_mysns_row['SNS_FEED.ix'];
                            $file_ix = $get_mysns_row['SNS_FILE.ix'];
                            $feed_number +=1;

                            if($feed_number % 3 == 1){
                        ?>

                        <div class="sns_row">
                            <div class="sns_one">
                                <a href="#"  id="images">
                                    <div class="img_form">
                                        <img class="sns_img" src="<?=$get_mysns_row['file_link']?>" onclick="show_feed(this,<?=$get_mysns_row['ix']?>); return false;">
                                    </div>
                                </a>
                            </div>

                        <?php }else if($feed_number % 3 ==2){   ?>
                            <div class="sns_one">
                                <a href="#" id="images">
                                    <div class="img_form">
                                        <img class="sns_img" src="<?=$get_mysns_row['file_link']?>" onclick="show_feed(this,<?=$get_mysns_row['ix']?>); return false;">
                                    </div>
                                </a>
                            </div>

                        <?php }else if($feed_number % 3 ==0){?>
                            <div class="sns_one_last">
                                <a href="#"  id="images">
                                    <div class="img_form">
                                        <img class="sns_img" src="<?=$get_mysns_row['file_link']?>" onclick="show_feed(this,<?=$get_mysns_row['ix']?>); return false;">
                                    </div>
                                </a>
                            </div>
                        </div>

                        <?php }?>


                        <?php }?>



                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var user_ix = "<?=$user_id?>";


         function add_comment(){
            var comment = document.getElementById("sns_comment");
            var text_tag = document.getElementById("text_tag");

            var nick = "<?=$user_nick?>";


            $("#text_tag").append("<li style='padding-bottom:5px; padding-top:5px; width:90%;'><a href='./sns_profile.php?sns_user="+nick+"'><span style='font-weight:bold; padding-right:10px;'>"+nick+"</span></a>"+comment.value+"</li>");



            var formData = new FormData();
            formData.append('mode','comment');
            formData.append('ix',user_ix);
            formData.append('comment',comment.value);
            formData.append('feed_ix',file_related_ix);


            $.ajax({
                type: 'post',
                dataType: 'json',
                url: './sns_ok.php',
                processData: false,  // file전송시 필수
                contentType: false,
                data:formData,

                success:function(data){

                },
                error: function(request,status,error){
                    console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
                }
            });

            comment.value = null;
            comment.focus;
        }



        var file_related_ix;
        var usr_ix;
        var follow_state;

        function show_feed(obj,num){
            file_related_ix = num;
            var text = img_array[num][0];
            var tag = img_array[num][1];
            var date_time = img_array[num][2];
            var good_num = img_array[num][4];
            var good_state = img_array[num][5];
            var usr_nick = img_array[num]['nick'];
            usr_ix = img_array[num]['usr_ix'];
            var usr_img = img_array[num]['profile_img'];


            follow_state = img_array['usr_nick_'+usr_ix]['follow_state'];
            console.log(follow_state);


            var date_split = date_time.split(" ");
            var date = date_split[0];
            var tag_array = tag.split(" ");
            var tag_size = tag_array.length;

            $("#full_text").html("");
            $("#img_date").html("");
            $("#good_num").html("");
            $("#usr_nick").html("");


            for(i=0; i<img_count; i++){
                var img_number = img_num_array[i];
                if(num==img_number){
                    $("#visual_"+img_number).show();
                }else{
                    $("#visual_"+img_number).hide();
                }
            }
            //

            if(good_state==1){
                $("#good_click").addClass("on");
            }else{
                $("#good_click").removeClass("on");
            }



            //$("#img_tag").append(tag);
            $("#img_date").append(date);
            $("#good_num").append(good_num);

            for(i=0; i<tag_size+1; i++){
                if(i==0){
                    $("#full_text").append("<ul id='text_tag' style='height:100%;'><li><span id='tag_text'>"+text+"<br><br>");
                }else{

                    var tag = tag_array[i-1].replace('#','');

                    $("#tag_text").append("<a href='./sns_tags.php?tag="+tag+"' style='width:auto; height:30px; background:#fff; margin-right:5px;'><span style='color:#003569;'>"+tag_array[i-1]+"</span></a>");
                }

            }

            var comment_num = img_array[num][14];

            for(i=0; i<(comment_num*2); i+=2){
                var nick_num = i+15;
                var text_num = i+16;
                var comment_nick = img_array[num][nick_num];
                var comment_text = img_array[num][text_num];
                $("#text_tag").append("<li style='padding-bottom:5px; padding-top:5px; width:90%;'><a href='./sns_profile.php?sns_user="+comment_nick+"'><span style='font-weight:bold; padding-right:10px;'>"+comment_nick+"</span></a>"+comment_text+"</li>");
            }
            $("#usr_nick").append("<a href='./sns_profile.php?sns_user="+usr_nick+"'><span>"+usr_nick+"</span></a>");

            change_follow_btn('start',follow_state);


            var modal = document.getElementById('myModal');

            modal.style.display = "block";


        }


        $(document).on('click','.good_btn',function(){

            var formData = new FormData();
            var string_ = document.getElementById("good_num").innerHTML;
            var number_ = Number(string_);
            if($(this).hasClass("on")){
                $(this).removeClass("on");
                formData.append('good_state',0);
                document.getElementById("good_num").innerHTML = number_ -1;
                img_array[file_related_ix][5] = 0;
                img_array[file_related_ix][4] = Number(img_array[file_related_ix][4]) - 1;
            }else{
                $(this).addClass("on");
                formData.append('good_state',1);
                document.getElementById("good_num").innerHTML = number_ +1;
                img_array[file_related_ix][5] = 1;
                img_array[file_related_ix][4] = Number(img_array[file_related_ix][4]) + 1;
            }
            formData.append('ix',user_ix);
            formData.append('feed_ix',file_related_ix);
            formData.append('mode','good');




            $.ajax({
                type: 'post',
                dataType: 'json',
                url: './sns_ok.php',
                processData: false,  // file전송시 필수
                contentType: false,
                data:formData,

                success:function(data){

                },
                error: function(request,status,error){
                    console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
                }
            });
        });

        function follow(obj,state){
            var follow_ix = obj.value;

            var formData = new FormData();

            formData.append('ix',user_ix);
            formData.append('usr_ix',follow_ix);
            formData.append('mode','follow');
            formData.append('follow',state);



            $.ajax({
                type: 'post',
                dataType: 'json',
                url: './sns_ok.php',
                processData: false,  // file전송시 필수
                contentType: false,
                data:formData,

                success:function(data){

                },
                error: function(request,status,error){
                    console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
                }
            });

            change_follow_btn('change',state);

        }

        function change_follow_btn(start,state){
            if(start=='start'){
                $("#usr_ix").html("");
                if(user_ix==usr_ix){
                    $("#usr_ix").append("<button class='follow_btn' onclick='follow(this,1);' value='' id='follow_id'></button>");
                }else{
                    if(state==1){
                        $("#usr_ix").append("<button class='follow_btn' onclick='follow(this,0);' value='' id='follow_id' style='color:#ff0000;'>팔로우 취소</button>");
                    }else{
                        $("#usr_ix").append("<button class='follow_btn' onclick='follow(this,1);' value='' id='follow_id'>팔로우</button>");
                    }

                }

                document.getElementById("follow_id").value = usr_ix;
                console.log(usr_ix);
            }else{
                $("#usr_ix").html("");
                if(state==1){
                    $("#usr_ix").append("<button class='follow_btn' onclick='follow(this,0);' value='' id='follow_id' style='color:#ff0000;'>팔로우 취소</button>");


                    img_array['usr_nick_'+usr_ix]['follow_state'] = 1;


                }else{
                    $("#usr_ix").append("<button class='follow_btn' onclick='follow(this,1);' value='' id='follow_id'>팔로우</button>");

                    img_array['usr_nick_'+usr_ix]['follow_state'] = 0;

                }
                document.getElementById("follow_id").value = usr_ix;
            }

        }

        </script>

        <!-- The Modal -->
        <div id="myModal" class="modal" style="display: none;">
            <!-- 이전, 다음 게시물 보기 화살표 -->
            <!-- <div class="arrow-container">
                <div class="arrow-padding">
                    <div class="arrow">
                        <a class="prev" href="" role="button">이전</a>
                        <a class="next" href="" role="button">다음</a>
                    </div>
                </div>
            </div> -->
            <!-- Modal content -->
            <!-- 게시물과 게시글 및 좋아요 댓글 등이 들어가는 곳 -->
            <div class="modal-content">
                <div class="content-wrap">
                    <article class="article-wrap">
                        <!-- 프로필 사진, 닉네임, 팔로우버튼이 들어갈 곳 -->
                        <div class="article-header">
                            <div class="header-pic">
                                <!-- <canvas class="canv" width="50" height="50" style="position: absolute; top: -5px; left: -5px; width: 50px; height: 50px;"> -->
                                <a class="pic-content" href="" style="width: 40px; height: 40px;">
                                    <img class="pic-img" src="/5.jpg" alt="">
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
                        </div>
                        <!-- 게시물 -->
                        <div class="post-wrap1">
                            <div role="button" tabindex="0">
                                <div class="post-wrap2">
                                    <div class="post-wrap3">
                                        <div class="post-wrap4">
                                            <img class="post-img" src="https://scontent-hkg3-1.cdninstagram.com/vp/f452220e8237af7a71b8d8b03b9a5b34/5C8993FB/t51.2885-15/e35/31042921_1792682590794700_6739950001310400512_n.jpg" alt="요즘커피 좋아합니다">
                                        </div>
                                        <div class="post-wrap5"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 게시글 -->
                        <div class="postDesc-wrap">
                            <section class="btn-wrap">
                                <span class="likeBtn-box">
                                    <button class="like-btn">
                                        <span class="likeBtn-img" aria-label="좋아요"></span>
                                    </button>
                                </span>
                                <span class="commentBtn-box">
                                    <button class="comment-btn">
                                        <span class="commentBtn-img" aria-label="댓글달기"></span>
                                    </button>
                                </span>
                            </section>
                            <section class="likeCount-wrap">
                                <div class="likeCount-box">
                                    <button class="likeCount-btn">
                                        좋아요
                                        <span>1000개</span>
                                    </button>
                                </div>
                            </section>
                            <div class="comment-wrap">
                                <ul class="comment-list">
                                    <li class="comment-unit">
                                        <div class="unit-wrap1">
                                            <div class="unit-wrap2">
                                                <div class="unit-wrap3">
                                                    <h2 class="unit-nicWrap">
                                                        <a class="unit-nic" href="">h2jjun</a>
                                                    </h2>
                                                    <span>
                                                        요즘 커피 좋아합니다만
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="comment-unit">
                                        <div class="unit-wrap1">
                                            <div class="unit-wrap2">
                                                <div class="unit-wrap3">
                                                    <h2 class="unit-nicWrap">
                                                        <a class="unit-nic" href="">so_o222</a>
                                                    </h2>
                                                    <span>
                                                        1
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="comment-unit">
                                        <div class="unit-wrap1">
                                            <div class="unit-wrap2">
                                                <div class="unit-wrap3">
                                                    <h2 class="unit-nicWrap">
                                                        <a class="unit-nic" href="">이회연</a>
                                                    </h2>
                                                    <span>
                                                        2
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="comment-unit">
                                        <div class="unit-wrap1">
                                            <div class="unit-wrap2">
                                                <div class="unit-wrap3">
                                                    <h2 class="unit-nicWrap">
                                                        <a class="unit-nic" href="">양희준</a>
                                                    </h2>
                                                    <span>
                                                        동해물과 백두산이 마르고 닳도록 하느님이 보우하사 우리나라만세 무궁화 삼천리 화려 강산
                                                        대한 사람 대한으로 길이 보전하세
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="comment-unit">
                                        <div class="unit-wrap1">
                                            <div class="unit-wrap2">
                                                <div class="unit-wrap3">
                                                    <h2 class="unit-nicWrap">
                                                        <a class="unit-nic" href="">양희준</a>
                                                    </h2>
                                                    <span>
                                                        동해물과 백두산이 마르고 닳도록 하느님이 보우하사 우리나라만세 무궁화 삼천리 화려 강산
                                                        대한 사람 대한으로 길이 보전하세
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="comment-unit">
                                        <div class="unit-wrap1">
                                            <div class="unit-wrap2">
                                                <div class="unit-wrap3">
                                                    <h2 class="unit-nicWrap">
                                                        <a class="unit-nic" href="">양희준</a>
                                                    </h2>
                                                    <span>
                                                        동해물과 백두산이 마르고 닳도록 하느님이 보우하사 우리나라만세 무궁화 삼천리 화려 강산
                                                        대한 사람 대한으로 길이 보전하세
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="comment-unit">
                                        <div class="unit-wrap1">
                                            <div class="unit-wrap2">
                                                <div class="unit-wrap3">
                                                    <h2 class="unit-nicWrap">
                                                        <a class="unit-nic" href="">양희준</a>
                                                    </h2>
                                                    <span>
                                                        동해물과 백두산이 마르고 닳도록 하느님이 보우하사 우리나라만세 무궁화 삼천리 화려 강산
                                                        대한 사람 대한으로 길이 보전하세
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="comment-unit">
                                        <div class="unit-wrap1">
                                            <div class="unit-wrap2">
                                                <div class="unit-wrap3">
                                                    <h2 class="unit-nicWrap">
                                                        <a class="unit-nic" href="">양희준</a>
                                                    </h2>
                                                    <span>
                                                        동해물과 백두산이 마르고 닳도록 하느님이 보우하사 우리나라만세 무궁화 삼천리 화려 강산
                                                        대한 사람 대한으로 길이 보전하세
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="time-wrap">
                                <a class="time-unit">
                                    <div class="time">
                                        5월 2일
                                    </div>
                                </a>
                            </div>
                            <section class="commentInput-wrap">
                                <div class="commentInput-box">
                                    <form class="commentInput-form" action="">
                                        <textarea class="commentInput" placeholder="댓글을 입력해주세요." name="" id="" autocomplete="off" onkeydown="resize(this)" onkeyup="resize(this)"></textarea>
                                        <input type="submit" hidden="true">
                                    </form>
                                </div>
                            </section>
                        </div>
                    </article>
                </div>
            </div>
            <span class="close">&times;</span>

        </div>

        <div class="ui modal show">
            <div class="image content">
           <div id="imggg">
                <div id="sns_visual">
                    pc
                    <div class="hidden_sm">

                        <?php
                        $get_mysns_sql = "select*from SNS_FEED join SNS_FILE on SNS_FEED.ix = SNS_FILE.feed_id and SNS_FILE.show_num='0' order by date desc";
                        $get_mysns_result = mysqli_query($con,$get_mysns_sql);
                        while($get_mysns_row=mysqli_fetch_array($get_mysns_result)){
                            $ix = $get_mysns_row['ix'];
                            $feed_id = $get_mysns_row['feed_id'];
                            $text = $get_mysns_row['text'];
                            $date = $get_mysns_row['date'];
                            $tag = $get_mysns_row['tag'];
                            $feed_nick = $get_mysns_row['user_nick'];

                            $get_all_img_sql ="select file_link from SNS_FILE where feed_id='$feed_id' order by show_num asc";
                            $get_all_img_result = mysqli_query($con,$get_all_img_sql);
                            $all_img_num = mysqli_num_rows($get_all_img_result);
                            $id = "visual_".$ix;
                            ?>

                        <div class="main_visual" style="width: 500px; display: none;" id="<?=$id?>">
                            <?php

                            for($i=0; $i<$all_img_num; $i++){

                                $img_num = $i+6;
                                $get_all_img_row = mysqli_fetch_array($get_all_img_result);
                                $img_link = $get_all_img_row['file_link'];

                            ?>
                            <div><img src="<?=$img_link?>" alt="oller"></div>


                            <?php
                            }

                        ?>
                        </div>
                        <?php

                        }
                        ?>
                    </div>
                </div>

                </div>
                <div id="modal_card">
                    <div style="margin: 5px 10px 0 20px; height: 15%;">
                        <ul>
                            <li style="float: left;">
                                <img class="profile_img" id="usr_img">
                            </li>
                            <li style="float: left; margin: 5% 0 0 20px;" id="usr_nick">

                            </li>
                            <li style="float: left; margin: 5% 0 0 10px;" id="usr_ix">

                            </li>
                        </ul>
                    </div>


                    <div style="border-bottom: 1px solid #aaa; width: 85%; margin: 0 auto;"></div>
                    <div style="height: 328px;">
                        <div style="margin: 10px 0 0 20px; overflow: auto; width: 100%; height: 100%;" id="full_text">

                        </div>
                        <div style="margin: 10px 0 0 20px; overflow: auto; width: 100%;">
                            <div id="img_tag" style="width: 90%; height: auto; color: #0000ff"></div>
                        </div>
                    </div>
                    <div style="border-bottom: 1px solid #aaa;  width: 85%; margin: 0 auto;"></div>
                    <div style="margin: 10px 0 0 20px; overflow: auto;">
                        <ul>
                            <li style="float: left;">
                                <button style="width: 30px; height: 30px;"><span></span></button>
                            </li>
                            <li style="float: left; margin-left: 5px;">
                                <button style="width: 30px; height: 30px;"><span></span></button>
                            </li>
                        </ul>
                    </div>
                    <div style="margin: 10px 0 0 20px; overflow: auto;">
                        <span>좋아요 <span id="good_num"></span>개</span>
                        <button class="good_btn" style="width: 30px; height: 27px; float: right; margin-right: 20px;" id="good_click">

                        </button>
                    </div>
                    <div style="margin: 10px 0 0 20px; overflow: auto;">
                        <span id="img_date"></span>
                    </div>
                    <div style="border-bottom: 1px solid #aaa; margin-top: 10px;  width: 85%; margin: 0 auto;"></div>
                    <div style="margin: 10px 10px 0 20px;">
                        <textarea type="text" name="sns_comment" id="sns_comment" placeholder="댓글 달기.." style="width: 100%; height: auto;" k></textarea>
                    </div>
                    <div><button style="width: 100px; height: 30px; display: none;" onclick="add_comment();">작성완료</button></div>
                </div>
            </div>

        </div>

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




        <button onclick="topFunction()" id="Top_Btn" title="Go to top" style="display: none; position: fixed; bottom: 20px; right: 30px; z-index: 99; font-size: 18px; border: none; outline: none; background-color: red; color: white; cursor: pointer; padding: 15px; border-radius: 4px;">Top</button>

    </body>
</html>
            <script>

                for(i=0; i<img_count; i++){
                    var img_number = img_num_array[i];
                    $("#visual_"+img_number).slick({
                        autoplay: false,
                        dots: true
                    });
                }


                $("#sns_comment").keyup(function(event){
                    if(event.keyCode == 13){
                        add_comment();
                    }
                });

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
