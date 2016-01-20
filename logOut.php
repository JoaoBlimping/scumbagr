<?php


include("connect.php");
include("structure.php");
include("database.php");


structure_insertHeader("log out",false);


session_unset();
session_destroy();

?>

<div>
	<a href="index.php">Back to index</a>
	<a href="login.php">Log back in</a>
</div>

<?php


structure_insertFooter();






?>
