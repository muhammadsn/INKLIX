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

    <title>INKLIX|Sign Up</title>
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

<?php
if (!empty($_POST)) {
    include_once 'functions.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $url = $GLOBALS['server_ip'] . "/signup?username=$username&password=$password&firstname=$firstname&lastname=$lastname";
    $result = file_get_contents($url);
    $result = json_decode($result, true);

}
?>

<div class="login-wrap col-sm-8 col-md-6 col-xl-4 offset-sm-2 offset-md-3 offset-xl-4">
    <div class="logo-black"></div>
    <div class="form">
        <form action="signup.php" method="post" class="login-form">
            <?php
            if (!empty($_POST) && $result['code'] == '200') {

                echo "<span class='success'>" . $result['message'] . "</span>";
                echo '
                        <span>Please copy these values in a file and keep them safe</span><br>
                        <textarea class="keys">'.$result["public_key"].'</textarea>
                        <textarea class="keys">'.$result["private_key"].'</textarea>
                        </form>
                        <a href="login.php"><input type="button" id="login-button" class="btn btn-block" value="Login"></a>
                    ';
            }
            else {
                if (!empty($_POST) && $result['code'] != '200') {
                    echo "<span class='error'>" . $result['message'] . "</span>";
                }
                echo '
                            <div class="field col-10 offset-1">
                                <input id="username" name="username" type="text" placeholder="Username">
                            </div>
                            <div class="field col-10 offset-1">
                                <input id="password" name="password" type="password" placeholder="Password">
                            </div>
                            <div class="field col-10 offset-1">
                                <input id="firstname" name="firstname" type="text" placeholder="First Name">
                            </div>
                            <div class="field col-10 offset-1">
                                <input id="lastname" name="lastname" type="text" placeholder="Last Name">
                            </div>
                            <div class="col-10 offset-1">
                                <input type="submit" id="submit" class="btn btn-block" value="Sign Up">
                            </div>
                            </form>
                            <span>Already Have An Account? <a href="login.php">Log In!</a></span>
                    ';
            }
            ?>


    </div>
</div>

</body>
</html>