<?php
include_once("../php_include/database_connect.php");
include_once("../php_include/auth_cookie.php");
include_once("../php_include/auth.php");
if (!session_id()) @ session_start();
if (isset($_SESSION['auth']))
    if ($_SESSION['auth'] == 'yes_auth')
        $authentication = new AuthenticationCookie();
$save = new saveStatistic();
$save->save();

class saveStatistic
{
    private $type;

    function save()
    {
        if (isset($_SESSION['auth'])) {
            if ($_SESSION['auth'] == 'yes_auth') {
                $login = $_SESSION['auth_login'];
                echo $login;
            }
            echo "Hello\n";
        }

        if (!session_id()) @ session_start();
        $dataBase = DataBase::getDB();
        if (isset($_POST["type"])) {
            $this->setType($_POST["type"]);
        }
        echo $this->getType();
        if ($this->getType() == "victorySapper") {
            $query = mysqli_query($dataBase->getLink(), "SELECT win_sapper FROM client WHERE  login = '$login'");
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            $score = $row['win_sapper'];
            $score++;
            echo $score;
            mysqli_query($dataBase->getLink(), "UPDATE client SET win_sapper = '$score' WHERE login  = '$login'");
            echo $this->getType();
        } else {
            if ($this->getType() == "looserSapper") {
                $query = mysqli_query($dataBase->getLink(), "SELECT loose_sapper FROM client WHERE  login = '$login'");
                $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                $score = $row['loose_sapper'];
                $score++;
                echo $score;
                mysqli_query($dataBase->getLink(), "UPDATE client SET loose_sapper = '$score' WHERE login  = '$login'");
                echo $this->getType();
            }else{
                if($this->getType() == "victory2048"){
                    $query = mysqli_query($dataBase->getLink(), "SELECT win_2048 FROM client WHERE  login = '$login'");
                    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                    $score = $row['win_2048'];
                    $score++;
                    echo $score;
                    mysqli_query($dataBase->getLink(), "UPDATE client SET win_2048 = '$score' WHERE login  = '$login'");
                    echo $this->getType();
                }else{
                    $query = mysqli_query($dataBase->getLink(), "SELECT loose_2048 FROM client WHERE  login = '$login'");
                    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                    $score = $row['loose_2048'];
                    $score++;
                    echo $score;
                    mysqli_query($dataBase->getLink(), "UPDATE client SET loose_2048 = '$score' WHERE login  = '$login'");
                    echo $this->getType();
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }
}
