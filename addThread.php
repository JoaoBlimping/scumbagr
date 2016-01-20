<?php


include_once("connect.php");
include_once("structure.php");
include_once("database.php");


structure_insertHeader("Add Thread",false);


//if the user's data has not yet been posted
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    echo '<form method="post" action="addThread.php?forum_id='.$_GET["forum_id"].'">
        Thread Subject: <input type="text" name="thread_subject" />
		first post content: <textarea name="post_content"></textarea>
        <input type="submit" value="Add Thread" />
     </form>';
}

//if the user's data has been posted
else
{
    $errors = array();

	//if subject is not set
    if(!isset($_POST['thread_subject']))
    {

        $errors[] = 'thread must have subject';
    }


	//if content is not set
    if (!isset($_POST['post_content']))
    {
        $errors[] = 'thread must have content';
    }

	//if there are errors to report
    if(!empty($errors))
    {
        echo 'Uh-oh.. a couple of fields are not filled in correctly..';
        echo '<ul>';
        foreach($errors as $key => $value) echo '<li>' . $value . '</li>';
        echo '</ul>';
    }

	//if there are no errors to report
    else
    {
        $result = database_addThread($_POST["thread_subject"],$_POST["post_content"],
								   $_SESSION["user_id"],$_GET["forum_id"]);

		//if the result is good
        if($result == database_SUCCESS)
        {
			echo "thread Successfully added.";
        }

		//if the result is bad
        else
        {
			echo "Something went wrong while adding thread you mongoloid :)";
        }
    }
}


?>


<?php

structure_insertFooter();


?>
