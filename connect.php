<?php


include_once("../scumbagr.php");


$GLOBALS["con"] = mysqli_connect($server, $username,  $password);

if(mysqli_connect_errno())
{
    die("not connected ".mysql_error());
}


if(!mysqli_select_db($GLOBALS["con"],$database))
{
    exit('Error: could not select the database');
}


?>
