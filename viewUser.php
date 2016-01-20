<?php


include_once("connect.php");
include_once("structure.php");
include_once("database.php");


$user = database_getUser($_GET["user_id"]);
$row = mysqli_fetch_assoc($user);
structure_insertHeader($row["user_name"],true);


?>


<div>
	<a href="index.php">Return to Index</a>

	<?php
		echo "<h2>Level ".$row["user_level"]."</h2>";
		echo "<h2>Joined on ".$row["user_date"]."</h2>";
		echo "<p>".$row["user_bio"]."</p>";
	?>



</div>


<?php

structure_insertFooter();


?>
