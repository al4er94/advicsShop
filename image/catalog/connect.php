<?php
//настройки подключания базе данных MySQL
$con_host = "localhost";
$con_port = "3306";
$con_user = "cm26687_auto";
$con_pass = "6Ov6TPdUolXT";
$sel_base = "cm26687_auto";
mysql_connect($con_host.":".$con_port,$con_user,$con_pass) or die("Error of connection to MySQL");
mysql_select_db($sel_base) or dir("Error of selecting database");//выбор базы данных
mysql_query("SET NAMES 'utf8'");//установка кодировки UTF-8
?>
