<?php


include("connect.php");
include("structure.php");
include("database.php");


structure_insertHeader("Sign In",false);

//if there is already someone signed in
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'You are already signed in, you can <a href="signout.php">sign out</a>
		  if you want.';
}

//if there isn't anyone signed in
else
{
	//if no data has been posted
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        echo '<form method="post" action="">
            Username: <input type="text" name="user_name" />
            Password: <input type="password" name="user_pass">
            <input type="submit" value="Sign in" />
         </form>';
    }

	//if data has been posted
    else
    {
        $errors = array();

		//if user name is not set
        if(!isset($_POST['user_name']))
        {
            $errors[] = 'The username field must not be empty.';
        }

		//if password is not set
        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'The password field must not be empty.';
        }

		//if there are errors of some description
        if(!empty($errors))
        {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) echo '<li>' . $value . '</li>';
            echo '</ul>';
        }

		//if there are no errors
        else
        {
			$result = database_login($_POST['user_name'],$_POST['user_pass']);

			//if there was an sql error
            if ($result == database_SQL_ERROR)
            {
                echo 'Something went wrong while signing in. Please try again later.';
            }

			//if sql returns nothing
			else if ($result == database_CREDENTIAL_ERROR)
			{
				echo 'You have supplied a wrong user/password combination. Please try again.';
			}

			//if it all worked
            else
            {
	            $_SESSION["signed_in"] = true;
	            echo 'Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceed to the forum overview</a>.';
            }
        }
    }
}





?>


<?php

structure_insertFooter();


?>
