<?php
include_once 'functions.php';
if (isset($_COOKIE['inklix_tkn'])) {
    if (isset($_POST['title'])) {
        $token = $_COOKIE['inklix_tkn'];
        $title = $_POST['title'];
        $caption = $_POST['caption'];
        $image = $_POST['image'];

        $url = $GLOBALS['server_ip'] . "/sendpost?token=".urlencode($token)."&post_title=".urlencode($title)."&text=".urlencode($caption)."&image=".urlencode($image);
        $url = htmlentities($url);
        $result = file_get_contents($url);
        $result = json_decode($result, true);

        if ($result['code'] == '200'){
            $msg = "<span class='success'>" . $result['message'] . "</span>";

        }
        else{
            $msg = "<span class='error'>" . $result['message'] . "</span>";
        }

    }

    if (isset($_COOKIE['inklix_uname'])) {
        $this_user = $_COOKIE['inklix_uname'];
    }

    echo '
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
            
            
                <script src="cloudinary/js/jquery.ui.widget.js" type="text/javascript"></script>
                <script src="cloudinary/js/jquery.iframe-transport.js" type="text/javascript"></script>
                <script src="cloudinary/js/jquery.fileupload.js" type="text/javascript"></script>
                <script src="cloudinary/js/jquery.cloudinary.js" type="text/javascript"></script>
                            
                        <title>INKLIX | Publish</title>
                    </head>
                    <body>
                    <div class="bg"></div>
                    
                    <nav>
                        <div class="container">
                            <div class="logo"></div>
                            <div class="tools">';

    if (isset($this_user)) {
        echo '
                    <a href="logout.php?username=' . $this_user . '"><div class="logout"></div></a>
                    <a href="account.php?username=' . $this_user . '"><div class="profile"></div></a>
                    <a href="new-post.php"><div class="new"></div></a>
                    <!--<a href="wallet.html"><div class="wallet"></div></a>-->
                ';
    }
    echo '       
                </div></div></nav>
                <div class="login-wrap col-sm-8 col-md-8 col-xl-6 offset-sm-2 offset-md-2 offset-xl-3">
                <div class="image-upload col-5">
                            <div class="post-prev">
                                <input name="file" type="file" class="cloudinary-fileupload" data-cloudinary-field="image_id"
                                       data-form-data="{ &quot;upload_preset&quot;:  &quot;y0lzx5vq&quot;,
                                                         &quot;callback&quot;: &quot;newpost.html&quot;}"
                                       data-url=" https://api.cloudinary.com/v1_1/inklix/image/upload">
                            </div>
                        </div>
                    <form action="new-post.php" method="post" class="login-form">
                        <div class="form col-7">';

    if (isset($msg)){
        echo $msg;
    }

    echo '
                
                        
                            <div class="field col-12">
                                <input id="title" name="title" type="text" placeholder="Post Title">
                            </div>
                            <div class="field col-12">
                                <input id="image" name="image" type="text" placeholder="Add url or Upload & click">
                            </div>
                            <div class="field col-12">
                                <textarea id="caption" name="caption" placeholder="Caption"></textarea>
                            </div>
                            <div class="col-12">
                                <input type="submit" id="submit" class="btn btn-block" value="publish">
                            </div>
                
                        </div>
                    </form>
                </div>
                
                </body>
                </html>
';

}
else{
    $url = "login.php";
    header('location: '.$url);
    die();
}