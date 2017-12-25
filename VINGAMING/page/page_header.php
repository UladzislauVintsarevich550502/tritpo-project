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
                echo '<h2><a href="#"> ' . $_SESSION['auth_name'] . '</a> | <a href="#" id="logout">Exit</a>';
                if ($name_of_the_game != "main_page") {
                    echo "<span style='font-family:Fonts1;margin-left: 35%'>$name_of_the_game</span>";
                    if ($name_of_the_game != "SAPPER") {
                        if (isset($_SESSION['auth']))
                            if ($_SESSION['auth'] == 'yes_auth') {
                                echo '<span id = " record" style="float: right;margin-right: 5%"><a href="#" id="scoreForm" onmouseenter="setName(2048)">Score</a>
                                </span></h2>
                                ';
                            }
                    } else {
                        if (isset($_SESSION['auth']))
                            if ($_SESSION['auth'] == 'yes_auth') {
                                echo '<span id = " record" style="float: right;margin-right: 5%"><a href="#" id="scoreForm" onmouseenter="setName(1)">Score</a>
                                </span></h2>
                                ';
                            }
                    }
                }
            }
        } else {
            echo '<h2 id="Registr"><a href="#" id="loginForm">Login</a> | <a href="#" id="registerForm">Register</a>';
            if ($name_of_the_game == "main_page")
                echo "<span style='font-family:Fonts1;margin-left: 35%'>Main Page</span></h2>";
            else {
                echo "<span style='font-family:Fonts1;margin-left: 35%'>$name_of_the_game</span></h2>";
            }
        }

                echo '
            <div class="score" onclick="set2048Score()">
                <div class="scoreArrow-up"></div>
                <div class="scoreFormholder">
                    <div class="scoreRandompad">
                        <fieldset>
                            <label type="winLabel">Number of victories:</label>
                            <label type="numberOfWin" id = "win">1111</label>
                            <label type = "looseLabel">Number of defeats:</label>
                            <label type="numberOfLoose" id = "loose">2222</label>
                         </fieldset>
                    </div>
                </div>
            </div>
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
                                <input type="checkbox" name="remember_me"><label for="remember_me">Remember me</label></li>
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