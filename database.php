<?php


include_once("connect.php");
include_once("things.php");


/** this is returned when the thing works */
define("database_SUCCESS",0);

/** this is returned when there is an error in the sql */
define("database_SQL_ERROR",1);

/** this is returned when the user supplies faulty credentials */
define("database_CREDENTIAL_ERROR",2);



/** add a user to the forum, returns a nasty value if something went wrong */
function database_addUser($name,$password,$email)
{
	$sql = "INSERT INTO users(user_name, user_pass, user_email ,user_date, user_level)
			VALUES('".mysqli_real_escape_string($GLOBALS["con"],$name)."',
				   '".sha1($password)."',
				   '".mysqli_real_escape_string($GLOBALS["con"],$email)."',
					NOW(),0)";

	$result = mysqli_query($GLOBALS["con"],$sql);

	if ($result) return database_SUCCESS;
	else return database_SQL_ERROR;
}


function database_addPost($content,$author,$thread)
{
	$threadData = database_getThread($thread);
	$row = mysqli_fetch_assoc($threadData);
	$forum = mysqli_fetch_assoc(database_getForum($row["thread_forum"]));


	if (!things_checkLevel($forum["forum_reply_level"])) return database_SQL_ERROR;

	if ($forum["forum_escape_html"])
	{
		$content = htmlspecialchars($content);
	}


	$sql = "INSERT INTO posts(post_content,post_date,post_author,post_thread)
			VALUES('".mysqli_real_escape_string($GLOBALS["con"],$content)."',
				    NOW(),
				    ".$author.",
					".$thread.")";

	$result = mysqli_query($GLOBALS["con"],$sql);

	if ($result) return database_SUCCESS;
	else return database_SQL_ERROR;
}


function database_addThread($subject,$content,$author,$forum)
{
	$forumData = mysqli_fetch_assoc(database_getForum($forum));


	if (!things_checkLevel($forumData["forum_post_level"])) return database_SQL_ERROR;

	$subject = htmlspecialchars($subject);

	if ($forumData["forum_escape_html"])
	{
		$content = htmlspecialchars($content);
	}


	$sql = "INSERT INTO threads(thread_subject,thread_date,thread_author,thread_forum)
			VALUES('".mysqli_real_escape_string($GLOBALS["con"],$subject)."',
				    NOW(),
				    ".$author.",
					".$forum.")";

	$result = mysqli_query($GLOBALS["con"],$sql);

	if (!$result) return database_SQL_ERROR;


	$sql = "SELECT * FROM threads ORDER BY thread_id DESC LIMIT 1";
	$result = mysqli_query($GLOBALS["con"],$sql);
	$threadData = mysqli_fetch_assoc($result);

	database_addPost($content,$author,$threadData["thread_id"]);

	if ($result) return database_SUCCESS;
	else return database_SQL_ERROR;
}


/** tries to log in a user, */
function database_login($name,$password)
{
	$sql = "SELECT user_id,user_name,user_level
			FROM users
			WHERE user_name = '" . mysqli_real_escape_string($GLOBALS["con"],$_POST['user_name']) . "' AND
				user_pass = '" . sha1($_POST['user_pass']) . "'";
	$result = mysqli_query($GLOBALS["con"],$sql);

	//if the sql broke
	if (!$result) return database_SQL_ERROR;

	//if the credentials returned no users
	else if (mysqli_num_rows($result) == 0) return database_CREDENTIAL_ERROR;

	//if it worked
	else
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$_SESSION["user_id"]    = $row["user_id"];
			$_SESSION["user_name"]  = $row["user_name"];
			$_SESSION["user_level"] = $row["user_level"];
		}

		return database_SUCCESS;
	}
}


/** gives you a list of all the forums */
function database_getForums()
{
	$sql = "SELECT forum_name,forum_id FROM forums";
	$result = mysqli_query($GLOBALS["con"],$sql);

	if (!$result) return database_SQL_ERROR;
	else return $result;
}


function database_getForum($id)
{
	$sql = "SELECT forum_name,forum_description,forum_post_level,forum_reply_level,forum_view_level,forum_escape_html FROM forums
			WHERE forum_id = ".mysqli_real_escape_string($GLOBALS["con"],$id);
	$result = mysqli_query($GLOBALS["con"],$sql);

	if (!$result) return database_SQL_ERROR;
	else return $result;
}

function database_getThreads($id)
{
	$sql = "SELECT thread_id,thread_subject,thread_date,thread_author FROM threads
			WHERE thread_forum = ".mysqli_real_escape_string($GLOBALS["con"],$id)."
			ORDER BY thread_date DESC";
	$result = mysqli_query($GLOBALS["con"],$sql);

	if (!$result) return database_SQL_ERROR;
	else return $result;
}


function database_getThread($id)
{
	$sql = "SELECT thread_subject,thread_date,thread_author,thread_forum FROM threads
			WHERE thread_id = ".mysqli_real_escape_string($GLOBALS["con"],$id);
	$result = mysqli_query($GLOBALS["con"],$sql);

	if (!$result) return database_SQL_ERROR;
	else return $result;
}


function database_getUser($id)
{
	$sql = "SELECT user_name,user_date,user_level,user_bio FROM users
			WHERE user_id = ".mysqli_real_escape_string($GLOBALS["con"],$id);
	$result = mysqli_query($GLOBALS["con"],$sql);

	if (!$result) return database_SQL_ERROR;
	else return $result;
}


function database_getPosts($id)
{
	$sql = "SELECT post_content,post_date,post_author FROM posts
			WHERE post_thread = ".mysqli_real_escape_string($GLOBALS["con"],$id);
	$result = mysqli_query($GLOBALS["con"],$sql);
	if (!$result) return database_SQL_ERROR;
	else return $result;

}


function database_getUsername($id)
{
	$sql = "SELECT user_name FROM users
			WHERE user_id = ".mysqli_real_escape_string($GLOBALS["con"],$id);
	$result = mysqli_query($GLOBALS["con"],$sql);
	$thingo = mysqli_fetch_assoc($result);
	return $thingo["user_name"];
}


function database_getForumName($id)
{
	$sql = "SELECT forum_name FROM forums
			WHERE forum_id = ".mysqli_real_escape_string($GLOBALS["con"],$id);
	$result = mysqli_query($GLOBALS["con"],$sql);
	$thingo = mysqli_fetch_assoc($result);
	return $thingo["forum_name"];
}


function database_getForumReplyLevel($id)
{
	$sql = "SELECT forum_reply_level FROM forums
			WHERE forum_id = ".mysqli_real_escape_string($GLOBALS["con"],$id);
	$result = mysqli_query($GLOBALS["con"],$sql);
	$thingo = mysqli_fetch_assoc($result);
	return $thingo["forum_reply_level"];


}


?>
