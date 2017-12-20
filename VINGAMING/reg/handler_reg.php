<?php
if (!session_id()) @ session_start();
include("../php_include/database_connect.php");
$dataBase = DataBase::getDB();
$error = array();
$login = mb_convert_encoding($dataBase->clear_string($dataBase->getLink(), $_POST['registerEmail']), "UTF-8");
$password = mb_convert_encoding($dataBase->clear_string($dataBase->getLink(), $_POST['registerPassword']), "UTF-8");
$surname = mb_convert_encoding($dataBase->clear_string($dataBase->getLink(), $_POST['registerSurname']), "UTF-8");
$name = mb_convert_encoding($dataBase->clear_string($dataBase->getLink(), $_POST['registerName']), "UTF-8");
$email = mb_convert_encoding($dataBase->clear_string($dataBase->getLink(), $_POST['registerEmail']), "UTF-8");
if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($login))) {
    $error[] = "Укажите корректный Логин!";
} else {
    $result = mysqli_query($dataBase->getLink(), "SELECT login FROM client WHERE login = '$login'");
    if (mysqli_num_rows($result) > 0)
        $error[] = "Логин занят!";
}
if (strlen($password) < 7 or strlen($password) > 15) $error[] = "Укажите Пароль от 7 до 15 символов!";
if (strlen($surname) < 3 or strlen($surname) > 20) $error[] = "Укажите Фамилию от 3 до 15 символов!";
if (strlen($name) < 3 or strlen($name) > 15) $error[] = "Укажите Имя от 3 до 15 символов!";
if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($email))) $error[] = "Укажите корректный email!";
if (count($error))
    echo implode('<br />', $error);
else {
    $password = md5($password);
    $password = strrev($password);
    $password = "9nm2rv8q" . $password . "2yo6z";
    $ip = $_SERVER['REMOTE_ADDR'];
    mysqli_query($dataBase->getLink(), "INSERT INTO client(login,password,name,surname,email,ip,record)
						VALUES(
							'$login',
							'$password',
							'$name',
							'$surname',
                            '$email',
                            '$ip',
                            '0'							
						)");
    $query = mysqli_query($dataBase->getLink(), "SELECT * FROM temp");
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    echo $row['temp'];
    echo 'true';
}