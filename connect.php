<?php
session_start();
$link= mysqli_connect("localhost","root","", "InternetProgramming");
if (isset($_GET["logout"])) {
	if ($_GET["logout"]==1 AND isset($_SESSION['id'])) { session_destroy();

				$message="You have been logged out. Have a nice day!";
				echo $message;

						}
}

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
			if ($error) echo "There were error(s) in your sign up details: " .$error;

			else {



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

	if (isset($_POST['LogIn'])) {

		$query = "SELECT * FROM users WHERE Email='".mysqli_real_escape_string($link, $_POST['loginemail'])."'AND
		password='" .md5(md5($_POST['loginemail']) .$_POST['loginpassword']). "'LIMIT 1";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_array($result);

		if($row){

			$_SESSION['id']=$row['id'];
			$_SESSION['name']=$row['Name'];
			$_SESSION['Type']=$row['Type'];

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
	</head>
	<body>
		<form method="post">

		<label for="Name">Name</label>
		<input type="text" name="name"/><br/>
		<label for="email">Email</label>
		<input type="email" name="email" id="email"/><br/>
		<label for="password">Password</label>
		<input type="password" name="password"/><br/>
		Account Type<br/>
		Professor  <input type="radio" name="Type" value="Professor"/><br/>
		Student<input type="radio" name="Type" value="Student"/><br/>
		 <input type="submit" name="SignUp" value="Sign Up"/>
		<br><br>

		<label for="email">Email</label>
		<input type="email" name="loginemail" id="email"/>
		<label for="password">Password</label>
		<input type="password" name="loginpassword"/>
		<input type="submit" name="LogIn" value="Log In"/>

		</form>
	</body>
</html>
