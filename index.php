<?php


include_once("connect.php");
include_once("structure.php");
include_once("database.php");


structure_insertHeader("scumbagr",true);


?>


<div>
	Welcome to Scumbagr, the premier online bulletin board for scumbags. Enjoy, my
	friends. See below for which forums you would like to observe and to post in.
	<h2>Forums</h2>
		<ul>

			<?php
				$forums = database_getForums();
				while($row = mysqli_fetch_assoc($forums))
				{
					echo "<li><a href='viewForum.php?forum_id=".$row["forum_id"]."'>".$row["forum_name"]."</a></li>";
				}

			?>
		</ul>

</div>

<?php

structure_insertFooter();


?>
