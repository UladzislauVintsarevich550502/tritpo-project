<?php
include_once("../php_include/database_connect.php");
$dataBase = DataBase::getDB();
$email = $dataBase->clear_string($dataBase->getLink(), $_POST['registerEmail']);
$result = mysqli_query($dataBase->getLink(), "SELECT email FROM client WHERE email = '$email'");
if (mysqli_num_rows($result) > 0)
    echo 'false';
else
    echo 'true';

