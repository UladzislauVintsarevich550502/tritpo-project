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
<html lang="rus">
<head>
    <meta charset="UTF-8">
    <title>Sapper</title>

    <link rel="icon" type="image/png"
          href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIDSURBVHja7JW/a9tAFMdPcmrXicGmVklIMKWlUON2KCEO7ZAhYyDeMmQJWT2ajKFzJy/9G1p389ShnYoJKSEkQwIZArFLIRkS/yAQtMhGev0+cw7iepKrwdChDz6cdLp77+57754MIhKTNFNM2P6tAIZh5MBapAh8BjoC7BM4Doqv8xfm/Cl44XPwCDjAA8/l+8hWwCudL0O3Wsgwg+ZCSvgBzINV8FIO+QXOQA10wVdwBfLw54yVSK6OHfOLzS2CUiwWI9k34hq48vljFIlYzzfgjuek02kqlUpUqVSoUCgMgymBmkELDjuDHR5vmiaVy2Xq9Xo0GAyoXq9TNptVA5yAhag7OOLxyWSSGo0GeZ5HbJ1Oh4rFohqAdV/nM1N9mcrhWqCOxwFY4j44Fu12+36MbdsCO1HzIg6+gG+Yn/J/mFIGPgQ/wS2wuKPf74tqtTpsLcsStVpNtFqtoHsyJ2mOyyLe2aFfBs6gRCIxPBNFnhFbLEKoRP7sBd/9Ha7rCsdxhpJpjHe9J+eJv7kHbDlwE7BalR8gpvMXVuzy4PGYUubKu/IabILUH1UhoFTE5Q1+AD6DafAWzMohnJan4ABkwDa4BIvw1w3LIn/avZOTd0EWPAP78tuGrx49AedgGfSilGudfO/lrdWZ9gyMKP9kSMc7zqgyhM75/9MfZ78FGADUwbryqz3ywAAAAABJRU5ErkJggg==">

    <link rel="stylesheet" href="../sapper/css(sapper)/sapper.css">
    <link rel="stylesheet" href="../window/window.css">
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

    <style id="textures">
        #map .tile {
            background: #d3d5d7 url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAACmElEQVRIS6WWS2/TQBDHZ4NAEPFJ4Gsg9RNUagXXnPMRMJecmyNCnIvKJ4ja0ivNo0gQOJKqUqW+8rC9ttfe9Q6atdYEx3k4+OLd9Xh++5+ZfTCYexBxFwBezI9t2f7FGPts/2XUQMQ9ADhMNSZa6yeISGPGptguG5u3pe8ySeD29gaur2/2d3ZefbIQDEVinGqtjWN6r+vbCVj7Yv/s9BgajQZjFKI01UexVDnAGlvguv6yCZ19OU2GP76/IchbqVInTmSuIBYCeRCAUikgasaYEQzL3rVaDYCBia9ONfk0vrrnX6Hf674zkESqHCKiCCfTae7YOFgBKIJRI6pUGRBBBv1eBokT6Yg4y8l4PEYppZn6RgoKdho1ykQyCmG/112E0Ie7uzsDq6rATogKMooiM8le9xwuBv1MiYgTJxKxieP9/f1WCuaVB0FgfA36vb+QSMQ5ZDKZVMpBWUh9388h3y4GmRKCBGFknBNkZRVtkCvP8wzkYtCHHBJGwgkjYdYJGWyS9FVFMZvNjI8FCA9CQydI0UHVIiiFBGHkWAgl7X+U0L+lEB6Ejs+zigjDMFdSVYHddVdCKCdxHG+lxAKWKvF54Hg+N0oIsq2ClUo8nxsIKUnTtJKSeQXURkR0Xdes+H+qiyAzN6ttrTXa3XHd3lUEUF8phZzzRYjr+Y7r+dl5AoiMUr9mey8D0BjnHJVSi5CZ680rAQYM2SMGNVbLcAXgMgVCCFKSHT6FcO0+PIyP/CBce+Tas3yZiuL4yXFHXo5Grw11OBzi0/rz/NJQdmZXBZDfjx/ew8HBQRaHTudk7+pqdAjA5LN6/XHx9lEVMJ1O4XL0G+r1+n6r1cpuK/ZpNpu7jLGXm4ZjmR0i/my32/m96w+I8vZM/ZAy0AAAAABJRU5ErkJggg==') no-repeat;
        }

        #map .flag.wrong {
            background: #d3d5d7 url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAADFklEQVRIS52WS2/TQBDHZ52kr/QC5YqQeoUPwSfgG1Rqg7hzQT4ibqjfoEKEqFx7r1ou9EKaCqgqAU2Qkj6SPkJfcR6O7dg7aGe9dpK6SRP7sN7d2fntf3d2xwy6HiyVFgDxaXfbWN+M/Wbz85/VWCY+MJ9fgouLNNdiHU/TEoAI4qUHARDld3epvrtt/RHgmSZcXl5CxXZTz1+lPknI1ha2Hz4iR5xz4Q04cr+O5BxFu+hHTnXOZTtBfHtZDe33NtbhxfIyY2KJeOVk1X7wMACQIYSOlDMFCJxxH3jHhHa/bHb2zs9eMiwW33eq/3QnORsocGwHTdME1xNOOGOMBINfQFAHv13TRB+tFvc4oykiwn42C99LxWUfUtWdmVnqsG0ba4YRONY0BfBL5Tgk+hOQ/cARXe4yoXY/+w1+HJQkxKlWdXt6hmxqNzXsuC6NuI+CXjsmlGOn4zKxt4Xc9m2I2MyrqyuCjapATUjEkWVZNMn8dhZ+Hh5IJfZ5Vbempmm5rq+vx1LQvWdts02+Cju5EGKdnQcQw6j1rDEbsgdRS9pqtig6C7kc7B4dSiUC0p6YlHtiGAOjqH8PoqKu2WySkr87OyGkfXqmW5NTdNCEAQ0cQ4EaV2/UycctiDkxQXQBiToH91GgJhYJMU9OdQkBaJtmb9wHB7HvvPjHon9CYnAkpFU50VsJqcSy2uFSaVpvEAw5+fI0DoNwDo7jSMsxFAyGlCt6My5ueCQIG1PBQEizXNabsQRFl+fJKz2M/8GXo3KsSnE1NhoNGtQTXQJS12K08SjuFp8w7O7qB4i663lomq3bkMZxWW/EYpSI6L4XlHtucj/INE10PXnB9ihpHB3rBimRGZAxhkxjwBjliRDoH9C7FDi2DQrQCymVFox8frU+nexLsX4qFtpEBvQTURTgrrbdzQ23UKulSFYxk8H44yeBI7FgKterVBz8OIxAWU9/hNdra3Lhv35IL9ULf9IYT7gTyWQ86u9kBN/Qqt3AaaUC7txc6s3KivxbUc+7xcUFxtizURxG2SLir7eZTPDf9R/Uy7IR4yjVUQAAAABJRU5ErkJggg==') no-repeat;
        }
    </style>
    <style>
        #map.defeat .bomb {
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIDSURBVHja7JW/a9tAFMdPcmrXicGmVklIMKWlUON2KCEO7ZAhYyDeMmQJWT2ajKFzJy/9G1p389ShnYoJKSEkQwIZArFLIRkS/yAQtMhGev0+cw7iepKrwdChDz6cdLp77+57754MIhKTNFNM2P6tAIZh5MBapAh8BjoC7BM4Doqv8xfm/Cl44XPwCDjAA8/l+8hWwCudL0O3Wsgwg+ZCSvgBzINV8FIO+QXOQA10wVdwBfLw54yVSK6OHfOLzS2CUiwWI9k34hq48vljFIlYzzfgjuek02kqlUpUqVSoUCgMgymBmkELDjuDHR5vmiaVy2Xq9Xo0GAyoXq9TNptVA5yAhag7OOLxyWSSGo0GeZ5HbJ1Oh4rFohqAdV/nM1N9mcrhWqCOxwFY4j44Fu12+36MbdsCO1HzIg6+gG+Yn/J/mFIGPgQ/wS2wuKPf74tqtTpsLcsStVpNtFqtoHsyJ2mOyyLe2aFfBs6gRCIxPBNFnhFbLEKoRP7sBd/9Ha7rCsdxhpJpjHe9J+eJv7kHbDlwE7BalR8gpvMXVuzy4PGYUubKu/IabILUH1UhoFTE5Q1+AD6DafAWzMohnJan4ABkwDa4BIvw1w3LIn/avZOTd0EWPAP78tuGrx49AedgGfSilGudfO/lrdWZ9gyMKP9kSMc7zqgyhM75/9MfZ78FGADUwbryqz3ywAAAAABJRU5ErkJggg==);
        }
    </style>
    <script type="text/javascript" async="" src="//static.getclicky.com/js"></script>
    <script type="text/javascript" async=""
            src="http://in.getclicky.com/in.php?site_id=66487162&amp;res=1366x768&amp;lang=ru&amp;type=pageview&amp;href=%2F&amp;title=Minesweeper%202011%20%7C%20Play%20online%20at%20Vesna.in.ua&amp;ref=http%3A%2F%2Fvesna.in.ua%2Fminesweeper%2F&amp;jsuid=3901986583&amp;mime=js&amp;x=0.06521196125351669"></script>

</head>
<body onload="if(GAME.slowpoke) { init(); }">

<?php
include_once("page_header.php");
$page_header = new page_header();
$page_header->name("SAPPER");
?>
<div>
    <div id="page">
        <div class="menu">
            <a id="tiny" href="#tiny">Tiny<span class="noob"> </span><b></b></a> |
            <a id="normal" href="#normal">Normal<span class="noob"> </span><b></b></a> |
            <a id="expert" href="#expert">Expert<span class="noob"> </span><b></b></a> |
            <a id="epic" href="#epic">Epic<span class="noob"> </span><b></b></a>
        </div>
        <div id="map" class="" style="width: 200px; height: 200px;">
            <div class="tile x1" id="t-x0y0" style="top: 0px; left: 0px;">+</div>
            <div class="tile bomb" id="t-x1y0" style="top: 0px; left: 25px;">+</div>
            <div class="td x1" id="t-x2y0" style="top: 0px; left: 50px;">1</div>
            <div class="td x0" id="t-x3y0" style="top: 0px; left: 75px;"></div>
            <div class="td x0" id="t-x4y0" style="top: 0px; left: 100px;"></div>
            <div class="td x0" id="t-x5y0" style="top: 0px; left: 125px;"></div>
            <div class="td x0" id="t-x6y0" style="top: 0px; left: 150px;"></div>
            <div class="td x0" id="t-x7y0" style="top: 0px; left: 175px;"></div>
            <div class="tile x1" id="t-x0y1" style="top: 25px; left: 0px;">+</div>
            <div class="td x1" id="t-x1y1" style="top: 25px; left: 25px;">1</div>
            <div class="td x2" id="t-x2y1" style="top: 25px; left: 50px;">2</div>
            <div class="td x2" id="t-x3y1" style="top: 25px; left: 75px;">2</div>
            <div class="td x2" id="t-x4y1" style="top: 25px; left: 100px;">2</div>
            <div class="td x1" id="t-x5y1" style="top: 25px; left: 125px;">1</div>
            <div class="td x0" id="t-x6y1" style="top: 25px; left: 150px;"></div>
            <div class="td x0" id="t-x7y1" style="top: 25px; left: 175px;"></div>
            <div class="tile" id="t-x0y2" style="top: 50px; left: 0px;">+</div>
            <div class="tile" id="t-x1y2" style="top: 50px; left: 25px;">+</div>
            <div class="tile x1" id="t-x2y2" style="top: 50px; left: 50px;">+</div>
            <div class="tile bomb" id="t-x3y2" style="top: 50px; left: 75px;">+</div>
            <div class="tile bomb" id="t-x4y2" style="top: 50px; left: 100px;">+</div>
            <div class="td x1" id="t-x5y2" style="top: 50px; left: 125px;">1</div>
            <div class="td x0" id="t-x6y2" style="top: 50px; left: 150px;"></div>
            <div class="td x0" id="t-x7y2" style="top: 50px; left: 175px;"></div>
            <div class="tile x1" id="t-x0y3" style="top: 75px; left: 0px;">+</div>
            <div class="tile x1" id="t-x1y3" style="top: 75px; left: 25px;">+</div>
            <div class="tile x1" id="t-x2y3" style="top: 75px; left: 50px;">+</div>
            <div class="tile x3" id="t-x3y3" style="top: 75px; left: 75px;">+</div>
            <div class="td x3" id="t-x4y3" style="top: 75px; left: 100px;">3</div>
            <div class="td x2" id="t-x5y3" style="top: 75px; left: 125px;">2</div>
            <div class="td x0" id="t-x6y3" style="top: 75px; left: 150px;"></div>
            <div class="td x0" id="t-x7y3" style="top: 75px; left: 175px;"></div>
            <div class="tile bomb" id="t-x0y4" style="top: 100px; left: 0px;">+</div>
            <div class="tile x2" id="t-x1y4" style="top: 100px; left: 25px;">+</div>
            <div class="td x1" id="t-x2y4" style="top: 100px; left: 50px;">1</div>
            <div class="tile x1" id="t-x3y4" style="top: 100px; left: 75px;">+</div>
            <div class="tile bomb" id="t-x4y4" style="top: 100px; left: 100px;">+</div>
            <div class="td x1" id="t-x5y4" style="top: 100px; left: 125px;">1</div>
            <div class="td x0" id="t-x6y4" style="top: 100px; left: 150px;"></div>
            <div class="td x0" id="t-x7y4" style="top: 100px; left: 175px;"></div>
            <div class="tile x3" id="t-x0y5" style="top: 125px; left: 0px;">+</div>
            <div class="tile bomb" id="t-x1y5" style="top: 125px; left: 25px;">+</div>
            <div class="tile x2" id="t-x2y5" style="top: 125px; left: 50px;">+</div>
            <div class="td x2" id="t-x3y5" style="top: 125px; left: 75px;">2</div>
            <div class="td x1" id="t-x4y5" style="top: 125px; left: 100px;">1</div>
            <div class="td x2" id="t-x5y5" style="top: 125px; left: 125px;">2</div>
            <div class="td x1" id="t-x6y5" style="top: 125px; left: 150px;">1</div>
            <div class="td x1" id="t-x7y5" style="top: 125px; left: 175px;">1</div>
            <div class="tile bomb" id="t-x0y6" style="top: 150px; left: 0px;">+</div>
            <div class="tile x4" id="t-x1y6" style="top: 150px; left: 25px;">+</div>
            <div class="tile bomb" id="t-x2y6" style="top: 150px; left: 50px;">+</div>
            <div class="td x1" id="t-x3y6" style="top: 150px; left: 75px;">1</div>
            <div class="td x0" id="t-x4y6" style="top: 150px; left: 100px;"></div>
            <div class="td x1" id="t-x5y6" style="top: 150px; left: 125px;">1</div>
            <div class="tile bomb" id="t-x6y6" style="top: 150px; left: 150px;">+</div>
            <div class="tile x1" id="t-x7y6" style="top: 150px; left: 175px;">+</div>
            <div class="tile bomb" id="t-x0y7" style="top: 175px; left: 0px;">+</div>
            <div class="tile x3" id="t-x1y7" style="top: 175px; left: 25px;">+</div>
            <div class="tile x1" id="t-x2y7" style="top: 175px; left: 50px;">+</div>
            <div class="td x1" id="t-x3y7" style="top: 175px; left: 75px;">1</div>
            <div class="td x0" id="t-x4y7" style="top: 175px; left: 100px;"></div>
            <div class="td x1" id="t-x5y7" style="top: 175px; left: 125px;">1</div>
            <div class="tile x1" id="t-x6y7" style="top: 175px; left: 150px;">+</div>
            <div class="tile x1" id="t-x7y7" style="top: 175px; left: 175px;">+</div>
            <div class="about">8x8, 10 bombs.</div>
        </div>
        <div id="hud" class=""><span
                    title="Elapsed time. The faster you solve the puzzle, the better player you are.">Time: <b
                        id="timer1">176</b></span> | <b id="cells1">19</b> free cells left | Clicks: <b
                    id="clicks1">5
                (5)</b>
            <span id="bug">Bug</span>
            <div id="counter-sandbox" onclick="return false;">
                <a title="" href="http://getclicky.com/66487162"><img alt=""
                                                                      src="//static.getclicky.com/media/links/badge.gif"
                                                                      border="0"></a>
            </div>
        </div>
    </div>
    <a href="main.php"><input id="cSize" type="submit" value="В главное меню"/></a>
</div>
<script type="text/javascript" src="../mainpage/js(mainpage)/login.js"></script>
<script type="text/javascript" src="../mainpage/js(mainpage)/register.js"></script>
<script type="text/javascript" src="../sapper/js(sapper)/sapper.js"></script>

</body>
</html>