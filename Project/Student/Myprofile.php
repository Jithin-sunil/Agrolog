<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

$selQry = "SELECT * FROM tbl_student WHERE student_id=" . $_SESSION["sid"];
$result = $con->query($selQry);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Profile</title>
</head>

<body>
<h3>My Profile</h3>
<table width="400" border="1" cellpadding="5">
  <tr>
    <td colspan="2" align="center">
      <img src="../Assets/Files/Student/Photo/<?php echo $data['student_photo'] ?>" width="150" height="150" alt="Profile Photo" />
    </td>
  </tr>
  <tr>
    <td width="150">Name</td>
    <td><?php echo $data["student_name"] ?></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><?php echo $data["student_email"] ?></td>
  </tr>
  <tr>
    <td>Roll Number</td>
    <td><?php echo $data["student_rollno"] ?></td>
  </tr>
 
  <tr>
    <td colspan="2" align="center">
      <a href="EditProfile.php">Edit Profile</a> | 
      <a href="ChangePassword.php">Change Password</a>
    </td>
  </tr>
</table>
</body>
</html>

<?php
include('Foot.php');
?>