<?php
$cookie = new AuthenticationCookie();
$cookie->cookie();

class AuthenticationCookie
{
    private $string;
    private $all_length;
    private $login_length;
    private $login;
    private $password;
    private $result;
    private $row;
    private $auth;
    private $remember_me;

    function cookie()
    {
        if (isset($_SESSION['auth']))
            $this->setAuth($_SESSION['auth']);
        if (isset($_COOKIE["remember_me"]))
            $this->setRememberMe($_COOKIE["remember_me"]);
        if ($this->getAuth() != 'yes_auth' && $this->getRememberMe()) {
            $dataBase = DataBase::getDB();
            $this->setString($_COOKIE["remember_me"]);
            $this->setAllLength(strlen($this->getString()));
            $this->setLoginLength(strpos($this->getString(), '+'));
            $this->setLogin($dataBase->clear_string($dataBase->getLink(), substr($this->getString(), 0, $this->getLoginLength())));
            $this->setPassword($dataBase->clear_string($dataBase->getLink(), substr($this->getString(), $this->getLoginLength() + 1, $this->getAllLength())));
            $this->setResult(mysqli_query($dataBase->getLink(), "SELECT * FROM client WHERE (login = '$this->login' or email = '$this->login') AND password = '$this->password'"));
            if (mysqli_num_rows($this->getResult()) > 0) {
                $this->setRow(mysqli_fetch_array($this->getResult(), MYSQLI_ASSOC));
                if (!session_id()) @ session_start();
                $_SESSION['auth'] = 'yes_auth';
                $_SESSION['auth_password'] = $this->row["password"];
                $_SESSION['auth_login'] = $this->row["login"];
                $_SESSION['auth_surname'] = $this->row["surname"];
                $_SESSION['auth_name'] = $this->row["name"];
                $_SESSION['auth_email'] = $this->row["email"];
            }
        }
    }

    public function getAuth()
    {
        return $this->auth;
    }

    public function setAuth($auth)
    {
        $this->auth = $auth;
    }

    public function getRememberMe()
    {
        return $this->remember_me;
    }

    public function setRememberMe($remember_me)
    {
        $this->remember_me = $remember_me;
    }

    public function getString()
    {
        return $this->string;
    }

    public function setString($string)
    {
        $this->string = $string;
    }

    public function getLoginLength()
    {
        return $this->login_length;
    }

    public function setLoginLength($login_length)
    {
        $this->login_length = $login_length;
    }

    public function getAllLength()
    {
        return $this->all_length;
    }

    public function setAllLength($all_length)
    {
        $this->all_length = $all_length;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

    public function getRow()
    {
        return $this->row;
    }

    public function setRow($row)
    {
        $this->row = $row;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }
}