<?php


function things_checkLevel($min)
{
	if (!isset($_SESSION["user_level"])) return false;
	else if ($_SESSION["user_level"] >= $min) return true;
	else return false;
}


?>
