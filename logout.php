<?php

$result = array();
if (!empty($_GET) || !empty($_POST)) {
    include_once 'functions.php';
    if (isset($_GET['username'])){
        $username = $_GET['username'];
    }
    if (isset($_POST['username'])){
        $username = $_POST['username'];
    }
    else{
        $username = $_COOKIE['inklix_uname'];
    }
    if (isset($_POST['password'])){
        $password = $_POST['password'];
        $url = $GLOBALS['server_ip'] . "/logout?username=$username&password=$password";
        $result = file_get_contents($url);
        $result = json_decode($result, true);
        if ($result['code'] == '200'){
            $cookie_name = 'inklix_uname';
            unset($_COOKIE[$cookie_name]);
            setcookie($cookie_name, '', time() - 3600, '/');

            if (isset($_COOKIE['inklix_tkn'])){
                $cookie_name = 'inklix_tkn';
                unset($_COOKIE[$cookie_name]);
                setcookie($cookie_name, '', time() - 3600, '/');
            }

            $msg = "<span class='success'>" . $result['message'] . "</span>";
            $redirect = "login.php";
            header("refresh:5; url=$redirect",true,303);
        }
        else{
            $msg = "<span class='error'>" . $result['message'] . "</span>";
        }
    }
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

    <title>INKLIX|Login</title>
</head>
<body>
<div class="bg"></div>

<nav>
    <div class="container">
        <div class="logo"></div>
        <div class="tools">
            <a href="signup.php"><div class="nav-bottom">Sign Up</div></a>
            <a href="login.php"><div class="nav-bottom">Login</div></a>
        </div>
    </div>
</nav>



<div class="login-wrap col-sm-8 col-md-6 col-xl-4 offset-sm-2 offset-md-3 offset-xl-4">
    <div class="logo-black"></div>
    <div class="form">

            <?php

            if (isset($msg)) {
                echo $msg;
            }
            if (!empty($_GET) && !isset($msg)){
                echo "<span>$username, Please enter your password to logout</span>";
                echo '
                        <form action="logout.php" method="post" class="login-form">
                            <div class="field col-10 offset-1">
                                <input id="username" name="username" type="text" value="'.$username.'" disabled>
                            </div>
                            <div class="field col-10 offset-1">
                                <input id="password" name="password" type="password" placeholder="Password">
                            </div>
                            <div class="col-10 offset-1">
                                <input type="submit" id="submit" class="btn btn-block" value="Logout">
                            </div>
                        </form>
                    ';
            }

            ?>

    </div>
</div>

</body>
</html>