<?php


include_once("../scumbagr.php");


$GLOBALS["con"] = mysqli_connect($GLOBALS["server"],$GLOBALS["username"],
								 $GLOBALS["password"],$GLOBALS["database"]);

if(mysqli_connect_errno())
{
    die("not connected ".mysql_error());
}


?>
