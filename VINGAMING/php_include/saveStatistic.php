<?php
include_once("auth_cookie.php");
class saveStatistic
{
    private $type;

    function save()
    {
        $login = $_SESSION['auth_login'];
        echo $login;
        if (!session_id()) @ session_start();
        $dataBase = DataBase::getDB();
        if (isset($_POST["type"])) {
            $this->setType($_POST["type"]);
        }
        if ($this->getType() == "victorySapper") {
            $query = mysqli_query($dataBase->getLink(), "UPDATE client SET win_sapper = win_sapper+1 WHERE   = '$login'");
            mysqli_fetch_array($query, MYSQLI_ASSOC);
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
