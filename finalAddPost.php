<?php


include_once("connect.php");
include_once("structure.php");
include_once("database.php");
include_once("things.php");


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	database_addPost($_POST["post_content"],$_SESSION["user_id"],$_GET["thread_id"]);
}


structure_insertHeader("post added",true);





?>


<div>
	post added.
	<p>
		<?php
			echo "<a href=viewThread.php?thread_id=".$_GET["thread_id"].">return</a>";
		?>
	</p>
</div>


<?php

structure_insertFooter();


?>
