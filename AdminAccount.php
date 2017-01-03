<?php

session_start();
$link= mysqli_connect("localhost","root","", "InternetProgramming");
$query ="SELECT `id` FROM `users`";
$result = mysqli_query($link,$query);
while ($row = mysqli_fetch_array($result))
{  if ($_SESSION['id']==$row['id']) {
    $yes =1;
  }
}
if (!isset($yes)) {
  header("Location:connect.php");
}
if (isset($_POST["submit"])) {
	$query = "INSERT INTO `Course` (`Course_ID`,`Course_Name`, `Professor_Name` ) VALUES ('".mysqli_real_escape_string($link,$_POST['courseId'])."','".mysqli_real_escape_string($link, $_POST['courseName'])."','".mysqli_real_escape_string($link,$_POST['username'])."' )";
	    mysqli_query($link, $query);

	    $success="You've been signed up!";
		echo $success;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Page</title>
  <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body background="new.jpg" style="margin:0 ;padding:0 ; font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;">
  <div id="Menu"  >
        <div id="logo">   Welcome to your Account  <? echo $_SESSION['name'] ;?> </div>
      </div>
<form method="post">
	Course ID<input style="margin-top:20px;" type="text" name="courseId"/><br>
	Course Name<input style="margin-top:10px;" type="text" name="courseName"><br>
	Dr. Name
<?php
	echo '<select class="styled-select blue-list rounded" style="margin-top:10px;" name="username">';
	$sql = "SELECT `Name` FROM `users` WHERE Type='Professor'";
	$result = mysqli_query($link,$sql);
	while ($row= mysqli_fetch_array($result)) {
    echo "<option value='" . $row['Name'] ."'>" . $row['Name'] ."</option>";
	}
	echo "</select>";
?><br>
<input type="submit" class="btn_homepage"style=" margin-top:20px;" name="submit" value="submit" />
<input type="submit" class="btn_homepage" name="viewCourses" value="View Courses">
<?php
if (isset($_POST["viewCourses"])) {
	$query = "SELECT `Course_ID`,`Course_Name`, `Professor_Name` FROM Course ";
	$result= mysqli_query($link,$query);
  echo '<div class="middle">';
	echo "<table border=1>
	<tr><th>Course ID</th>
	<th>Course Name</th>
	<th>Professor Name</th>
	</tr>";
	while($row = mysqli_fetch_array($result)){
	echo "<tr><td>" . $row['Course_ID'] . "</td><td>" . $row['Course_Name'] . "</td><td>" . $row['Professor_Name'] . "</td></tr>";
	}
	echo "</table>";
  echo "</div>";
}
?>
<button class="btn_homepage"><a href="connect.php?logout=1">Log Out</a></button>

</form>
</body>
</html>
