<?php


include_once("connect.php");
include_once("structure.php");
include_once("database.php");
include_once("things.php");



$forum = database_getForum($_GET["forum_id"]);
$row = mysqli_fetch_assoc($forum);

if (!things_checkLevel($row["forum_view_level"],true)) die("you must be at least level ".
													  $row["forum_view_level"].
													  " to be allowed here :)");

structure_insertHeader($row["forum_name"],true);





?>


<div>
	<p>
		<a href="index.php">Return to Index</a>
	</p>
	<?php
		echo $row["forum_description"];
		echo "<p><small>you must be at least level ".$row["forum_post_level"]." to post threads here</small></p>";
		echo "<p><small>you must be at least level ".$row["forum_reply_level"]." to reply to threads here</small></p>";
		echo "<p><small>you must be at least level ".$row["forum_view_level"]." to view threads here</small></p>";

		if (things_checkLevel($row["forum_post_level"]))
		{
			echo "<a href='addThread.php?forum_id=".$_GET["forum_id"]."'>add a thread</a>";
		}

		echo "<h2>Threads</h2>";

		$threads = database_getThreads($_GET["forum_id"]);
		while ($row = mysqli_fetch_assoc($threads))
		{
			echo "<a href='viewThread.php?thread_id=".$row["thread_id"]."'><h2>".$row["thread_subject"]."</h2></a>";
			echo "created by <a href='viewUser.php?user_id=".$row["thread_author"]."'>".
				 database_getUsername($row["thread_author"])."</a>";
			echo " on ".$row["thread_date"];
			echo "<hr />";
		}
	?>
</div>


<?php

structure_insertFooter();


?>
