<?php


include_once("connect.php");
include_once("structure.php");
include_once("database.php");
include_once("things.php");



$thread = database_getThread($_GET["thread_id"]);

$row = mysqli_fetch_assoc($thread);
structure_insertHeader($row["thread_subject"],true);

$forum = mysqli_fetch_assoc(database_getForum($row["thread_forum"]));


if (!things_checkLevel($forum["forum_view_level"])) die("you must be at least level ".
													  $row["forum_view_level"].
													  " to be allowed here :)");





?>


<div>
	<?php
		echo "<a href='viewForum.php?forum_id=".$row["thread_forum"]."'>Return to forum overview</a>";
	?>

	<table>
		<?php

			$posts = database_getPosts($_GET["thread_id"]);

			while ($row = mysqli_fetch_assoc($posts))
			{
				echo "<tr><td class='avatar'>";
				echo "<a href='viewUser.php?user_id=".$row["post_author"]."'>".
					 database_getUsername($row["post_author"])."</a>";
				echo "</td><td>";
				echo "<p>".$row["post_content"]."</p>";
				echo "</td></tr>";
			}

			if (things_checkLevel($forum["forum_reply_level"]))
			{
				echo "<tr><td>Add your post</td><td>";
				echo '<form method="post" action="finalAddPost.php?thread_id='.$_GET["thread_id"].'">
			        content: <textarea name="post_content"></textarea>
			        <input type="submit" value="Post" />
			     </form>';
		 	}
		?>
	</table>


</div>


<?php

structure_insertFooter();


?>
