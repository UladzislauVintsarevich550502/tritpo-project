<?php

class DataBase
{
    private static $link = null;
    private static $db = null;
    private $db_host = null;
    private $db_user = null;
    private $db_database = null;
    private $db_password = null;

    private function __construct()
    {
        $this->setDbHost("localhost");
        $this->setDbUser("root");
        $this->setDbDatabase("mydb");
        $this->setDbPassword("1111");
        $this->setLink(mysqli_connect($this->getDbHost(), $this->getDbUser(),$this->getDbPassword()));
        mysqli_select_db($this->getLink(), "mydb");
        mysqli_set_charset($this->getLink(), "utf8");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
    }

    /**
     * @param null $db_password
     */
    public function setDbPassword($db_password): void
    {
        $this->db_password = $db_password;
    }

    /**
     * @return null
     */
    public function getDbPassword()
    {
        return $this->db_password;
    }

    public function getDbHost()
    {
        return $this->db_host;
    }

    public function setDbHost($db_host)
    {
        $this->db_host = $db_host;
    }

    function getDbUser()
    {
        return $this->db_user;
    }

    public function setDbUser($db_user)
    {
        $this->db_user = $db_user;
    }

    public static function getLink()
    {
        return self::$link;
    }

    public static function setLink($link)
    {
        self::$link = $link;
    }

    public static function getDB()
    {
        if (self::$db == null) self::$db = new DataBase();
        return self::$db;
    }

    public function getDbDatabase()
    {
        return $this->db_database;
    }

    public function setDbDatabase($db_database)
    {
        $this->db_database = $db_database;
    }

    function clear_string($link, $clear_string)
    {
        $clear_string = strip_tags($clear_string);
        $clear_string = mysqli_real_escape_string($link, $clear_string);
        $clear_string = trim($clear_string);
        return $clear_string;
    }
}
