<?php
include_once("../php_include/database_connect.php");
include_once("../php_include/auth_cookie.php");
include_once("../php_include/auth.php");
$dataBase = DataBase::getDB();
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
                        required: "Укажите вашу почту!",
                        minlength: "От 5 до 15 символов!",
                        maxlength: "От 5 до 15 символов!",
                        remote: "Логин занят!"
                    },
                    "registerPassword": {
                        required: "Укажите Пароль!",
                        minlength: "От 10 до 25 символов!",
                        maxlength: "От 10 до 25 символов!"
                    },
                    "registerName": {
                        required: "Укажите ваше Имя!",
                        minlength: "От 3 до 20 символов!",
                        maxlength: "От 3 до 20 символов!"
                    },
                    "registerSurname": {
                        required: "Укажите вашу Фамилию!",
                        minlength: "От 3 до 15 символов!",
                        maxlength: "От 3 до 15 символов!"
                    },
                },
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        success: function (data) {
                            if (data == 'true')
                                $(".register").html("Успешная регистрация");
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
    <a href="main.php"><input id="cSize" type="submit" value="В главное меню"/></a>
</div>



<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="../2048/js(2048)/game.js"></script>
<script src="../mainpage/js(mainpage)/login.js"></script>
<script src="../mainpage/js(mainpage)/register.js"></script>
</body>
</html>
