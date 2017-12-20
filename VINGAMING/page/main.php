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
<html lang="rus">
<head>
    <meta charset="UTF-8">
    <title>Main Page</title>
    <link rel="stylesheet" href="../window/window.css">
    <link rel="stylesheet" href="../mainpage/css(mainpage)/login.css">
    <link rel="stylesheet" href="../mainpage/css(mainpage)/register.css">
    <link rel="stylesheet" href="../mainpage/css(mainpage)/style.css">
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
                        minlength: 5,
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
include_once ("page_header.php");
$page_header = new page_header();
$page_header->name("main_page");
?>

<div class="container">
    <div id="content-slider">
        <div id="slider">
            <div id="mask">
                <ul>
                    <li id="first" class="firstanimation">
                        <a href="2048_main.php">
                            <img src="../resource/images/img_1.jpg"/>
                        </a>
                        <div class="tooltip">
                            <h1>2048</h1>
                        </div>
                    </li>

                    <li id="second" class="secondanimation">
                        <a href="sapper.php">
                            <img src="../resource/images/img_2.jpg"/>
                        </a>
                        <div class="tooltip">
                            <h1>Сапер</h1>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="progress-bar"></div>
            <div id="pictures">
                <a href="2048_main.php">
                    <img src="../resource/images/img_1.jpg" width="337.5" height="159"/>
                </a>
                <a href="sapper.php">
                    <img src="../resource/images/img_2.jpg" width="338" height="159"/>
                </a>
            </div>
        </div>
    </div>
</div>
<script src="../mainpage/js(mainpage)/login.js"></script>
<script src="../mainpage/js(mainpage)/register.js"></script>
</body>
</html>