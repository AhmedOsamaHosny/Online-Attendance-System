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


if (isset($_POST['submit'])) {
  $query = "SELECT Course_ID from Student_Registration Where id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
  $run=mysqli_query($link,$query);
  while ($row=mysqli_fetch_array($run)) {
    if($_POST['courseid']==$row['Course_ID'])
    {$no=1;}
  }
  if (isset($no)) {
echo "you are already registerd in this course ";
  }
  else {
    $sql = "INSERT INTO `Student_Registration` (`id`,`Course_ID`) VALUES ('".mysqli_real_escape_string($link,$_SESSION['id'])."','".mysqli_real_escape_string($link, $_POST['courseid'])."')";
    $result = mysqli_query($link,$sql);  }

}

 ?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="mystyle.css">


  </head>
  <body style="margin:0 ;padding:0 ; font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;">
    <div id="Menu"  >
    	<div id="logo">   Welcome to your Account  <? echo $_SESSION['name'] ;?> </div>
    </div>

<!--Add New Course Area -->
<div>
  <form method= "post">
    <fieldset>
     <legend>Choose Your Courses For This Term</legend>

    <label>Add New Course </label>
      <?php
      	echo '<select class="styled-select blue-list rounded" name="courseid">';
	      $sql = "SELECT `Course_Name`,`Course_ID` FROM `Course`";
      	$result = mysqli_query($link,$sql);
      	while ($row= mysqli_fetch_array($result)) {
          echo "<option value='" . $row['Course_ID'] ."'>" . $row['Course_Name'] ."</option>";
      	}
      	echo "</select>";
      ?>
      <br>
      <input type="submit" class="btn_homepage" name="submit" align="right" value="submit"/>
      <button class="btn_homepage"  ><a href="connect.php?logout=1">Log Out</a></button>
</fieldset>
    </form>

</div>
<!--Add New Course Area Ending-->


<!--Table Area-->

<div >
  <fieldset>
    <legend>View Your Attendance For Certain Course</legend>
  <h4>You are registered in these courses</h4>
  <?
  $sql = "SELECT Student_Registration.Course_ID,Course.Course_Name FROM Course,Student_Registration WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."' AND Course.Course_ID=Student_Registration.Course_ID";
  $result= mysqli_query($link,$sql);

  echo "<table border=1>
  <tr>
  <th>Course ID</th>
  <th>Course Name</th>
  </tr>";

  while($row = mysqli_fetch_array($result)){
  echo "<tr><td>" . $row['Course_ID'] . "</td><td>" . $row['Course_Name'] . "</td></tr>";
  }

  echo "</table>";
  ?>
  <h4>choose course to view attendance</h4>
  <form method="post">
    <label>Select Course </label>
    <?php
      echo '<select class="styled-select blue-list rounded" onchange="showAttendance()">';
      $sql = "SELECT Student_Registration.Course_ID,Course.Course_Name FROM Student_Registration,Course WHERE Course.Course_ID = Student_Registration.Course_ID AND id ='".mysqli_real_escape_string($link,$_SESSION['id'])."' ";
      $result = mysqli_query($link,$sql);
      echo "<option value='' disabled selected>choose course</option>";
      while ($row= mysqli_fetch_array($result)) {
        echo "<option value='" . $row['Course_ID'] ."'>" . $row['Course_Name'] ."</option>";
      }
      echo "</select>";
    ?>


</div>

<!--End Table Area-->

<script> //AJAX_DB.php file

function showAttendance() {

var xhttp = new XMLHttpRequest();

xhttp.onreadystatechange = function() {

if (this.readyState == 4 && this.status == 200) {

document.getElementById("AttendanceResult").innerHTML = this.responseText;

}

};

xhttp.open("POST", "ajax_student_attendance.php", true);
var e = document.getElementById("courseselect");
var courseid = e.options[e.selectedIndex].value;
//alert(courseid);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("courseid="+courseid);

}

</script>
<div class="" id="AttendanceResult">

</div>
</form>
  </body>

</html>
