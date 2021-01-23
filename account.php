<?php
if (!empty($_GET)) {
    include_once 'functions.php';
    $username = $_GET['username'];
    if (isset($_COOKIE['inklix_uname'])){
        $this_user = $_COOKIE['inklix_uname'];
    }
    $url = $GLOBALS['server_ip'] . "/getuserinfo?username=$username";
    $result = file_get_contents($url);
    $result = json_decode($result, true);
    $url2 = $GLOBALS['server_ip'] . "/getpost?username=$username";
    $posts = file_get_contents($url2);
    $posts = json_decode($posts, true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0">
    <script src="jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="script.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>

    <title>INKLIX | @<?php echo $username; ?></title>
</head>
<body>
<div class="bg"></div>

<div id="post-viewer" class="modal-wrapper">
    <div class="modal-bg"></div>
    <div class="modal-box col-sm-10 col-xl-6 offset-sm-1 offset-xl-3">
        <div class="close-modal"></div>
        <div id="img-view" class="img-view col-6"></div>
        <div class="post-content col-6">
            <div id="post-title" class="post-title"></div>
            <div class="post-tools container">
                <div class="post-opt like col-4"><span class="likes"></span></div>
                <div class="post-opt trusted col-4"><span class="trusts"></span></div>
                <div class="post-opt distrust col-4"></div>
            </div>
            <div id="post-text" class="post-text"></div>
        </div>

    </div>
</div>

<nav>
    <div class="container">
        <div class="logo"></div>
        <div class="tools">


            <?php
            if (isset($this_user)) {
                echo '
                    <a href="logout.php?username='.$this_user.'"><div class="logout"></div></a>
                    <a href="account.php?username='.$this_user.'"><div class="profile"></div></a>
                    <a href="new-post.php"><div class="new"></div></a>
<!--            <a href="wallet.html"><div class="wallet"></div></a>-->
                ';
                if ($this_user != $username && $result['code'] != '404') {
                    echo '<div class="nav-bottom" id="follow-bottom">Follow</div>';
                }
            }
            else{
                echo '
                    <a href="signup.php"><div class="nav-bottom">Sign Up</div></a>
                    <a href="login.php"><div class="nav-bottom">Login</div></a>
                ';
            }
            ?>
        </div>
    </div>
</nav>


<?php
    if ($result['code'] == '404'){
        echo '
                <div class="login-wrap col-sm-8 col-md-6 col-xl-4 offset-sm-2 offset-md-3 offset-xl-4">
                    <div class="logo-black"></div>
                    <div class="form">
                        <span class="error">Oops! User not Found...</span>
                    </div>
                </div>';
    }
    else{
        echo '
            <div class="container">
                <div class="info row">
                    <div class="profile-pic col-sm-2">
                        <img src="img/user.jpg">
                    </div>
                    <div class="page-info-wrap col-sm-10">
                        <div class="user-name">'.$result['firstname']." ".$result['lastname'].'</div>
            <div class="page-info reputation ">
                <h4>Followers&nbsp;&nbsp;</h4>
                <span>3</span>
            </div>
            <div class="page-info trust">
                <h4>Trust Points</h4>
                <span>'.number_format((float)$result['trust'], 2, '.', '').'</span>
            </div>
            <div class="page-info post-count">
                <h4>Posts</h4>
                <span>'.$posts['message'].'</span>
            </div>
            </div>
            </div>
            <div class="post-grid">
                <div class="row">';

        if ($posts['message'] == '0'){
            echo '
                        <div class = "no-post">
                            <span>Oops! No posts yet...</span>
                        </div>
                    ';
        }
        else{

            for ($i = 0; $i < (int)$posts['message']; $i++){
                $post = '
                            <div class="post-prev col-4">
                                <img class="post-img" src="'.$posts["block ".$i]["post_image"].'">
                                <div class="overlay">
                                    <span>'.$posts["block ".$i]["post_title"].'</span>
                                    <div class="options">
                                        <!--<div class="like post-opt"></div>-->
                                        <div class="view-post post-opt"></div>
                                    </div>
                                </div>
                                <p style="display: none;">'.$posts["block ".$i]["post_text"].'</p>
                                <div id="post_id" style="display: none;">'.$posts["block ".$i]["id"].'</div>
                                <div id="like_count" style="display: none;">'.$posts["block ".$i]["likes"].'</div>
                                <div id="trust_count" style="display: none;">'.$posts["block ".$i]["trusts"].'</div>
                                <div id="like_addr" style="display: none;">http://178.63.50.62:1104/likepost?token='.$_COOKIE['inklix_tkn'].'&id='.$posts["block ".$i]["id"].'</div>
                            </div>                
                ';
                echo $post;
            }



//            echo '
//                    <div class="post-prev col-4">
//                        <img class="post-img" src="img/img4.jpg">
//                        <div class="overlay">
//                            <span>Hello!</span>
//                            <div class="options">
//                                <!--<div class="like post-opt"></div>-->
//                                <div class="view-post post-opt"></div>
//                            </div>
//                        </div>
//                        <p style="display: none;">
//                            Lorem ipsum dolor sit amet, no utroque inermis legendos qui.
//                            Ad oratio nonumy probatus est. Et maiorum detraxit mei, et vel bonorum luptatum assueverit.
//                            Equidem instructior ea quo, nec ea enim iudico.
//                            Eu appareat intellegat instructior sea, per ea imperdiet consequat.
//                        </p>
//                    </div>';
        }

    }
?>







        </div>
    </div>
</div>
</body>
</html>