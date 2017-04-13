<?php
// connection à la base
$hostname_PF = "localhost";
$database_PF = "pterido";
$username_PF = "pterido";
$password_PF = "";
$PF = mysql_pconnect($hostname_PF, $username_PF, $password_PF) or die(mysql_error());
mysql_query('SET NAMES UTF8;');
?>
