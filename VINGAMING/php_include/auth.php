<?php
include_once('database_connect.php');
if (isset($_POST["authentication"])) {
    if ($_POST["authentication"] == "authentication") {
        $authentication = new Authentication();
        $authentication->login();
    }
}
if (isset($_POST["logout"])) {
    if ($_POST["logout"] == "logout") {
        $authentication = new Authentication();
        $authentication->logout();
    }
}

class Authentication
{
    private $login;
    private $password;
    private $row;
    private $POSTLogin;
    private $POSTPassword;
    private $POSTRememberMe;

    function login()
    {
        if (isset($_POST["login"]))
            $this->setPOSTLogin($_POST["login"]);
        if (isset($_POST["password"]))
            $this->setPOSTPassword($_POST["password"]);
        if (isset($_POST["remember_me"]))
            $this->setPOSTRememberMe($_POST["remember_me"]);
        $dataBase = DataBase::getDB();
        $this->setLogin($dataBase->clear_string($dataBase->getLink(), $this->getPOSTLogin()));
        $this->setPassword(md5($dataBase->clear_string($dataBase->getLink(), $this->getPOSTPassword())));
        $this->setPassword(strrev($this->getPassword()));
        $this->setPassword(strtolower("9nm2rv8q" . $this->getPassword() . "2yo6z"));
        if ($this->getPOSTRememberMe() == "yes")
            setcookie('remember_me', $this->login . '+' . $this->password, time() + 3600 * 24 * 31, "/");
        $result = mysqli_query($dataBase->getLink(), "SELECT * FROM client WHERE (login = '$this->login' OR email = '$this->login') AND password = '$this->password'");
        if (mysqli_num_rows($result) > 0) {
            $this->setRow(mysqli_fetch_array($result));
            if (!session_id()) @ session_start();
            $_SESSION['auth'] = 'yes_auth';
            $_SESSION['auth_password'] = $this->row["password"];
            $_SESSION['auth_login'] = $this->row["login"];
            $_SESSION['auth_surname'] = $this->row["surname"];
            $_SESSION['auth_name'] = $this->row["name"];
            $_SESSION['auth_email'] = $this->row["email"];
            echo 'yes_auth';
        } else
            echo 'no_auth';
    }

    public function getPOSTLogin()
    {
        return $this->POSTLogin;
    }

    public function setPOSTLogin($POSTLogin)
    {
        $this->POSTLogin = $POSTLogin;
    }

    public function getPOSTPassword()
    {
        return $this->POSTPassword;
    }

    public function setPOSTPassword($POSTPassword)
    {
        $this->POSTPassword = $POSTPassword;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPOSTRememberMe()
    {
        return $this->POSTRememberMe;
    }

    public function setPOSTRememberMe($POSTRememberMe)
    {
        $this->POSTRememberMe = $POSTRememberMe;
    }

    public function getRow()
    {
        return $this->row;
    }

    public function setRow($row)
    {
        $this->row = $row;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function logout()
    {
        if (!session_id()) @ session_start();
        unset($_SESSION['auth']);
        setcookie('remember_me', '', 0, '/');
        echo 'logout';
    }
}