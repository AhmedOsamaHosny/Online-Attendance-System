<?php
session_start();
$link= mysqli_connect("localhost","root","", "InternetProgramming");


 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Check Student Attendance</title>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
  </head>
  <body>
    <form method="post">
      <?php
      // Select Courses from doctor's courses
        echo '<select class="styled-select blue-list rounded" name="courseid" >';
        $sql = "SELECT `Course_Name`,`Course_ID` FROM `Course`  WHERE Professor_Name ='".mysqli_real_escape_string($link,$_SESSION['name'])."' ";
        $result = mysqli_query($link,$sql);
        echo "<option value='' disabled selected>choose course</option>";
        while ($row= mysqli_fetch_array($result)) {
          echo "<option value='" . $row['Course_ID'] ."'>" . $row['Course_Name'] ."</option>";
        }
        echo "</select>";
       ?>
    <br>  <input class="styled-select blue-list rounded" type="date" name="date" value=""><br>
      <input class="btn_homepage" type="submit" name="submit" value="submit">
      <button class="btn_homepage" type="button" name="button"><a href="ProfAccount.php">Back</a></button>
    </form>
    <?if (isset($_POST['submit'])) {
      $query = "SELECT Attendance.Statues,users.Name FROM Attendance,users WHERE users.id = Attendance.id AND `Date` = '".mysqli_real_escape_string($link,$_POST['date'])."'AND Course_ID ='".mysqli_real_escape_string($link,$_POST['courseid'])."'";
      $result1 = mysqli_query($link,$query);
      echo '<div class="middle">';
      echo "<table border=1>
      <tr>
      <th>Student Name</th>
      <th>Status</th>
      </tr>";

      while($row = mysqli_fetch_array($result1)){
      echo "<tr><td>" . $row['Name'] . "</td><td>" . $row['Statues'] . "</td></tr>";
      }

      echo "</table>";
      echo "</div>";

    }?>
  </body>
</html>
