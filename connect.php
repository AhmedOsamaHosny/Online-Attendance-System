<?php
session_start();
$link= mysqli_connect("localhost","root","", "InternetProgramming");
// to destroy the session if the user enter logout
if (isset($_GET["logout"])) {
	if ($_GET["logout"]==1 AND isset($_SESSION['id'])) { session_destroy();

				$message="You have been logged out. Have a nice day!";
				echo $message;

						}
}

// this function for the sign-up and checking that the info is written correct
if (isset($_POST["SignUp"])) {
		$error = "";
		if (!$_POST['name']) $error.="<br />Please enter your Name";

		if (!$_POST['email']) $error.="<br />Please enter your email";
				else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $error .="<br />Please enter a valid email";


 		if (!$_POST['password']) $error.="<br />Please enter your password";
 		else {


 			if (strlen($_POST['password'])<5) $error.="<br />Please enter at least 5 characters";

 			if(!preg_match('/[A-Z]/', $_POST['password'])) $error.= "<br />Please include min 1 capital letter";
 		}
 			if (!isset($_POST['Type'])) $error.="<br />Please select your account type";
			if ($error) 
			echo "There were error(s) in your sign up details: " .$error;


			else {


// check the email is already in the database or not and if in the database send error message if not insert it into the database
			$query= "SELECT * FROM `users` WHERE Email ='".mysqli_real_escape_string($link, $_POST['email'])."'";

			$result = mysqli_query($link, $query);

			$results = mysqli_num_rows($result);

			if ($results) $error = "That email is already registered. Do you want to log in?";

			else {

			$query = "INSERT INTO `users` (`Name`,`Email`, `Password` ,`Type`) VALUES ('".mysqli_real_escape_string($link,$_POST['name'])."','".mysqli_real_escape_string($link, $_POST['email'])."', '".md5(md5($_POST['email']).$_POST['password'])."','".mysqli_real_escape_string($link,$_POST['Type'])."' )";

    		mysqli_query($link, $query);

    		$success="You've been signed up!";

    		$_SESSION['id']= mysqli_insert_id($link);
    		$_SESSION['name']=$_POST['name'];

				// this part is for checking the user type and send every user to the correct page according to his account type and sign in automaticly after sign-up
				if ($_SESSION['Type']=='Admin')
				{	header("Location:AdminAccount.php");}
				elseif ($_SESSION['Type']=='Professor')
				{	header("Location:ProfAccount.php");}
				else{
					header("Location:StudentAccount.php");
				}
			}
		}
	}


// This function is for the login
	if (isset($_POST['LogIn'])) {

		$query = "SELECT * FROM users WHERE Email='".mysqli_real_escape_string($link, $_POST['loginemail'])."'AND
		password='" .md5(md5($_POST['loginemail']) .$_POST['loginpassword']). "'LIMIT 1";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_array($result);

		if($row){

			$_SESSION['id']=$row['id'];
			$_SESSION['name']=$row['Name'];
			$_SESSION['Type']=$row['Type'];
			// this part is for checking the user type and send every user to the correct page according to his account type

			if ($_SESSION['Type']=='Admin') {
				header("Location:AdminAccount.php");
			}
			elseif ($_SESSION['Type']=='Professor')
			{	header("Location:ProfAccount.php");}
			elseif ($_SESSION['Type']=='Student'){
				header("Location:StudentAccount.php");
			}




		}
	} else {

			$error = "We could not find a user with that email and password. Please try again.";



		}



?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link rel="stylesheet" type="text/css" href="mystyle.css">

	</head>
	<body background="notepad.jpg">
		<form method="post">
<div class="connect-signup-div">
	<fieldset>
		<legend>Sign-Up</legend>
		<label for="Name">Name</label>
		<input type="text" name="name"/><br/>
		<label for="email">Email</label>
		<input type="email" name="email" id="email"/><br/>
		<label for="password">Password</label>
		<input type="password" name="password"/><br/>
		Account Type<br/>
		Professor  <input type="radio" name="Type" value="Professor"/><br/>
		Student<input type="radio" name="Type" value="Student"/><br/>
		 <input type="submit" class="btn_homepage" style="margin-left:60px; margin-top:10px" name="SignUp" value="Sign Up"/>
		 <br><br>
	</fieldset>
	 </div>
		<br><br>

<div class="connect-signin-div">
<fieldset>
	<legend>Sign In</legend>
	<label for="email">Email</label>
	<input type="email" name="loginemail" id="email"/>
	<label for="password">Password</label>
	<input type="password" name="loginpassword"/>
	<input type="submit" class ="btn_homepage" name="LogIn" value="Log In"/>
</fieldset>

</div>
		</form>
	</body>
</html>
