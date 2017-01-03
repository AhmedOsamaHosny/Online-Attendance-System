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
  $query =  "INSERT INTO Attendance (id,Course_ID, `Date` ,Statues) VALUES ('".mysqli_real_escape_string($link,$_POST['student'])."','".mysqli_real_escape_string($link,$_POST['courseid'])."','".mysqli_real_escape_string($link,$_POST['date'])."','".mysqli_real_escape_string($link,$_POST['Statues'])."') ON DUPLICATE KEY UPDATE Statues='".mysqli_real_escape_string($link,$_POST['Statues'])."'";
  mysqli_query($link, $query);  ;
}

?>

<!DOCTYPE html>
<html>

<body>
<h1> Welcome to your Account Doctor <? echo $_SESSION['name'] ;?> <h1>
  <form method="post">
    <label>Select Course </label>
    <?php

    // Select Courses from doctor's courses
      echo '<select name="courseid" id="courseselect" onchange="showUser()">';
      $sql = "SELECT `Course_Name`,`Course_ID` FROM `Course`  WHERE Professor_Name ='".mysqli_real_escape_string($link,$_SESSION['name'])."' ";
      $result = mysqli_query($link,$sql);
      echo "<option value='' disabled selected>choose course</option>";
      while ($row= mysqli_fetch_array($result)) {
        echo "<option value='" . $row['Course_ID'] ."'>" . $row['Course_Name'] ."</option>";
      }
      echo "</select>";

    ?>
    <script>

function showUser() {

var xhttp = new XMLHttpRequest();

xhttp.onreadystatechange = function() {

if (this.readyState == 4 && this.status == 200) {

document.getElementById("result").innerHTML = this.responseText;

}

};

xhttp.open("POST", "ajax_info.php", true);
var e = document.getElementById("courseselect");
var courseid = e.options[e.selectedIndex].value;
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("courseid="+courseid);

}

</script>
    <div class="" id="result">

    </div>
    <input type="date" name="date"><br>
    Attend <input type="radio" name="Statues" value="Attend"/><br/>
    Late <input type="radio" name="Statues" value="Late"/><br/>
    Absent <input type="radio" name="Statues" value="Absent"/><br/>
    <br>  <input type="submit" name="submit" value="submit"> <button><a href="check_student_attendance.php">Check Attendance</a></button>
    <button><a href="connect.php?logout=1">Log Out</a></button>
  </form>

</body>
</html>
