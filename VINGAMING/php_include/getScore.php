<?php
include_once("../php_include/database_connect.php");
include_once("../php_include/auth_cookie.php");
include_once("../php_include/auth.php");
if (!session_id()) @ session_start();
if (isset($_SESSION['auth']))
    if ($_SESSION['auth'] == 'yes_auth')
        $authentication = new AuthenticationCookie();
$save = new getScore();
$save->save();

class getScore
{
    private $type;

    function save()
    {
        if (isset($_SESSION['auth'])) {
            if ($_SESSION['auth'] == 'yes_auth') {
                $login = $_SESSION['auth_login'];
            }
        }

        if (!session_id()) @ session_start();
        $dataBase = DataBase::getDB();
        if (isset($_POST["type"])) {
            $this->setType($_POST["type"]);
        }
        if ($this->getType() == "SapperScore") {
            $query = mysqli_query($dataBase->getLink(), "SELECT win_sapper FROM client WHERE  login = '$login'");
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            $win = $row['win_sapper'];
            echo $win;
            echo " ";
            $query = mysqli_query($dataBase->getLink(), "SELECT loose_sapper FROM client WHERE  login = '$login'");
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            $loose = $row['loose_sapper'];
            echo $loose;

        } else {
            $query = mysqli_query($dataBase->getLink(), "SELECT win_2048 FROM client WHERE  login = '$login'");
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            $win = $row['win_2048'];
            echo $win;
            echo " ";
            $query = mysqli_query($dataBase->getLink(), "SELECT loose_2048 FROM client WHERE  login = '$login'");
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            $loose = $row['loose_2048'];
            echo $loose;
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
