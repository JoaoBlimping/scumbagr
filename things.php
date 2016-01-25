<?php


function things_checkLevel($min,$loose = false)
{
	if ($min == 0 && $loose) return true;
	else if (!isset($_SESSION["user_level"])) return false;
	else if ($_SESSION["user_level"] >= $min) return true;
	else return false;
}


?>
