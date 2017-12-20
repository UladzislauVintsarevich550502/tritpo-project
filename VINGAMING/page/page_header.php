<?php

class page_header
{
    function name($name_of_the_game)
    {
        if (!session_id()) @ session_start();
        $dataBase = DataBase::getDB();
        echo '<div id="wrap">
    <div id="regbar">
        <div id="navthing">';
        if (isset($_SESSION['auth'])) {
            if ($_SESSION['auth'] == 'yes_auth') {
                echo '<h2><a href="#"> ' . $_SESSION['auth_name'] . '</a> | <a href="#" id="logout">Выход</a>';
                if ($name_of_the_game != "main_page") {
                    echo "<span style='font-family:Fonts1;margin-left: 35%'>$name_of_the_game</span>";
                    if ($name_of_the_game != "sapper") {
                        if (isset($_SESSION['auth']))
                            if ($_SESSION['auth'] == 'yes_auth') {
                                $login = $_SESSION['auth_login'];
                                $query = mysqli_query($dataBase->getLink(), "SELECT win_2048 FROM client WHERE login = '$login'");
                                $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                $result = $row['win_2048'];
                                $query = mysqli_query($dataBase->getLink(), "SELECT loose_2048 FROM client WHERE login = '$login'");
                                $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                $result1 = $row['loose_2048'];
                                echo '<span id = " record" style="float: right;margin-right: 20px">
                                    Victories :' . $result . '   Losses :' . $result1 . '</h2>
                                </span>
                                ';
                            }
                    } else {
                        if (isset($_SESSION['auth']))
                            if ($_SESSION['auth'] == 'yes_auth') {
                                $login = $_SESSION['auth_login'];
                                $query = mysqli_query($dataBase->getLink(), "SELECT win_sapper FROM client WHERE login = '$login'");
                                $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                $result = $row['win_sapper'];
                                $query = mysqli_query($dataBase->getLink(), "SELECT loose_sapper FROM client WHERE login = '$login'");
                                $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                $result1 = $row['loose_sapper'];
                                echo '<span id = " record" style="float: right;margin-right: 20px">
                                    Victories :' . $result . '   Losses :' . $result1 . '</h2>
                                </span>
                                ';
                            }
                    }
                }
            }
        } else {
            if ($name_of_the_game == "main_page")
                echo '<h2 id="Registr"><a href="#" id="loginForm">Login</a> | <a href="#" id="registerForm">Register</a></h2>';
            else {
                echo '<h2 id="Registr"><a href="#" id="loginForm">Login</a> | <a href="#" id="registerForm">Register</a></h2>';
                echo "<span style='font-family:Fonts1;margin-left: 35%'>$name_of_the_game</span>";
                if (isset($_SESSION['auth']))
                    if ($_SESSION['auth'] == 'yes_auth') {
                        $login = $_SESSION['auth_login'];
                    }
            }
        }
        echo '
            <form method="post">
                <div class="login">
                    <div class="loginArrow-up"></div>
                    <div class="loginFormholder">
                        <div class="loginRandompad">
                            <fieldset>
                                <label name="loginEmail">Email</label>
                                <input type="loginEmail" value="example@example.com" id="loginEmail"/>
                                <label name="loginPassword">Password</label>
                                <input type="loginPassword" value="1234567890" id="loginPassword"/>
                                <input type="checkbox" name="remember_me"><label for="remember_me">Запомнить
                                    меня</label></li>
                                <p align="right" id="button_auth"><input type="submit" value="Enter"></p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
            <form method="post" id="form_reg" action="../reg/handler_reg.php">
                <div class="register">
                    <div class="registerArrow-up"></div>
                    <div class="registerFormholder">
                        <div class="registerRandompad">
                            <fieldset>
                                <label name="registerName">Name</label>
                                <input type="registerName" name="registerName" value="Влад"/>
                                <label name="registerSurname">Surname</label>
                                <input type="registerSurname" name="registerSurname" value="Винцаревич"/>
                                <label name="registerEmail">Email</label>
                                <input type="registerEmail" name="registerEmail" value="example@example.com"/>
                                <label name="registerPassword">Password</label>
                                <input type="registerPassword" name="registerPassword"/>
                                <p align="right"><input type="submit" name="reg_submit" id="form_submit"
                                                        value="Register"></p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
';
    }
}