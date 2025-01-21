<?php
$dsn = "mysql:host=localhost;dbname=album";
$user = "root";
$passwd = "";
$pdo = new PDO($dsn, $user, $passwd, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));