<?php


//start the sesh
session_start();


/** inserts the header that goes on each page */
function structure_insertHeader($title,$doLogin)
{
	//if it should do a login thing
	if ($doLogin)
	{
		//if the signed in variable exists
		if (isset($_SESSION["signed_in"]))
		{
			//if signed in is true
		    if($_SESSION["signed_in"])
		    {
		        $login = "Hello ".$_SESSION["user_name"].". Not you? <a href='logOut.php'>Log out</a>";
		    }

			//if not signed in
		    else
		    {
		        $login = "<a href='login.php'>Log in</a> or <a href='addUser.php'>create an account</a>.";
		    }
		}

		//if signed in variable is not set
		else
		{
			$login = "<a href='login.php'>Log in</a> or <a href='addUser.php'>create an account</a>.";
		}
	}
	//if it should not do a login thing
	else
	{
		$login = "";
	}

	echo "<html>
			<head>
				<title>".$title."</title>
				<link rel='stylesheet' href='style.css' />
			</head>
			<body>
				<div id='top'>
					".$login."
					<h1>".$title."</h1>
				</div>";
}


/** inserts the footer that goes on each page */
function structure_insertFooter()
{
	echo "	<br />
			<i>another quality product from dany burton</i>
			</body>
		  </html>";
}


?>
