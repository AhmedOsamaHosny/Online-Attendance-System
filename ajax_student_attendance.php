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
$sql = "SELECT `Date`,Statues FROM Attendance WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."' AND Course_ID='".mysqli_real_escape_string($link,$_POST['courseid'])."'";
$result= mysqli_query($link,$sql);

echo "<table border=1>
<tr>
<th>Date</th>
<th>Status</th>
</tr>";

while($row = mysqli_fetch_array($result)){
echo "<tr><td>" . $row['Date'] . "</td><td>" . $row['Statues'] . "</td></tr>";
}

echo "</table>";


mysqli_close($link);
?>

  </body>
</html>
