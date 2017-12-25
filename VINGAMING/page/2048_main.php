<?php
include_once("../php_include/database_connect.php");
include_once("../php_include/auth_cookie.php");
include_once("../php_include/auth.php");
if (!session_id()) @ session_start();
if (isset($_SESSION['auth']))
    if ($_SESSION['auth'] == 'yes_auth')
        $authentication = new AuthenticationCookie();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>2048</title>
    <link rel="stylesheet" href="../window/window.css">
    <link rel="stylesheet" href="../2048/css(2048)/game.css">
    <link rel="stylesheet" href="../mainpage/css(mainpage)/login.css">
    <link rel="stylesheet" href="../mainpage/css(mainpage)/register.css">
    <link rel="stylesheet" href="../mainpage/css(mainpage)/score.css">
    <script type="text/javascript" src="../js_include/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="../js_include/jquery.form.js"></script>
    <script type="text/javascript" src="../js_include/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="../js_include/client_script.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#form_reg').validate({
                rules: {
                    "registerEmail": {
                        required: true,
                        email: true,
                        remote: {
                            type: "post",
                            url: "../reg/check_email.php"
                        }
                    },
                    "registerPassword": {
                        required: true,
                        minlength: 10,
                        maxlength: 25
                    },
                    "registerName": {
                        required: true,
                        minlength: 3,
                        maxlength: 15
                    },
                    "registerSurname": {
                        required: true,
                        minlength: 3,
                        maxlength: 15
                    },
                },
                messages: {
                    "registerEmail": {
                        required: "\n" +"Enter your email!",
                        minlength:
                            "5 to 15 characters!",
                        maxlength:
                            "5 to 15 characters!",
                        remote:
                            "Login is busy!"
                    },
                    "registerPassword": {
                        required:
                            "Enter Password!",
                        minlength:  "10 to 25 characters!",
                        maxlength:  "10 to 25 characters!"
                    },
                    "registerName": {
                        required: "Укажите ваше Имя!",
                        minlength:  "3 to 20 characters!",
                        maxlength: "3 to 20 characters!"
                    },
                    "registerSurname": {
                        required: "Enter your Last Name!",
                        minlength: "3 to 15 characters!",
                        maxlength: "3 to 15 characters!"
                    },
                },
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        success: function (data) {
                            if (data == 'true')
                                $(".register").html(
                                    "Successful registration");
                    }
                    });
                }
            });
        });
    </script>
</head>

<body>

<?php
include_once("page_header.php");
$page_header = new page_header();
$page_header->name("2048");
?>

<div class="information">
    <div class="infoBlock">
        <label id="num" name="number">Number</label>
        <input id="size" type="number" value="4"/>
        <input id="cSize" type="submit" onclick="start()" value="Ok"/>
    </div>
    <div id="canvas-block">
        <canvas id="canvas" width="500" height="500"></canvas>

    </div>
    <a href="main.php"><input id="cSize" type="submit" value="To the main menu"/></a>
</div>



<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="../2048/js(2048)/game.js"></script>
<script src="../mainpage/js(mainpage)/login.js"></script>
<script src="../mainpage/js(mainpage)/register.js"></script>
<script src="../mainpage/js(mainpage)/score.js"></script>
</body>
</html>
