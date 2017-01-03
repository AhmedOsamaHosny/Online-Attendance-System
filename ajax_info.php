<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
session_start();
$link= mysqli_connect("localhost","root","", "InternetProgramming");
  echo '<select name="student" id="studentselect" onchange="" >';
  echo "<option value='' disabled selected>choose student</option>";
    $sql = "SELECT Student_Registration.id,users.Name FROM Student_Registration,users WHERE Student_Registration.id=users.id AND Student_Registration.Course_ID=".mysqli_real_escape_string($link,$_POST['courseid']);
    $result = mysqli_query($link,$sql);
    while ($row= mysqli_fetch_array($result)) {
      echo "<option value='" . $row['id'] ."'>" . $row['Name'] ."</option>";
    }
    echo "</select>";


mysqli_close($link);
?>

  </body>
</html>
