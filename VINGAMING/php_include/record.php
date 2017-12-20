<?php
include_once("../php_include/database_connect.php");
$dataBase = DataBase::getDB();
$record = $dataBase->clear_string($dataBase->getLink(), $_POST['record']);
$login = $dataBase->clear_string($dataBase->getLink(), $_POST['login']);
$result = mysqli_query($dataBase->getLink(), "UPDATE client SET record = '$record' WHERE login = '$login'");
