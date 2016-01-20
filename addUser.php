<?php


include_once("connect.php");
include_once("structure.php");
include_once("database.php");


structure_insertHeader("Add User",false);


//if the user's data has not yet been posted
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    echo '<form method="post" action="">
        Username: <input type="text" name="user_name" />
        Password: <input type="password" name="user_pass">
        Password again: <input type="password" name="user_pass_check">
        E-mail: <input type="email" name="user_email">
        <input type="submit" value="Add category" />
     </form>';
}

//if the user's data has been posted
else
{
    $errors = array();

	//if user name is set
    if(isset($_POST['user_name']))
    {
        //the user name exists
        if(!ctype_alnum($_POST['user_name']))
        {
            $errors[] = 'The username can only contain letters and digits.';
        }

		//if the user name is too long
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }

	//if username is not set
    else
    {
        $errors[] = 'The username field must not be empty.';
    }


	//if the password is set
    if(isset($_POST['user_pass']))
    {
		//if the passwords don't match
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'The two passwords did not match.';
        }
    }

	//if the password is not set
    else
    {
        $errors[] = 'The password field cannot be empty.';
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
        $result = database_addUser($_POST["user_name"],$_POST["user_pass"],
								   $_POST["user_email"]);

		//if the result is good
        if($result == database_SUCCESS)
        {
			echo "Successfully registered. You can now <a href='signin.php'>sign in</a>
				  and start posting! :-)";
        }

		//if the result is bad
        else
        {
			echo "Something went wrong while registering. Please try again later.
				  Most likely, somebody already has this account name";
        }
    }
}


?>


<?php

structure_insertFooter();


?>
