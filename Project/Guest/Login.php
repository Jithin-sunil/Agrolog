<?php
include("../Assets/Connection/Connection.php");

session_start();

if (isset($_POST['btn_submit'])) {
    $email = $_POST['txt_email'];
    $password = $_POST['txt_password'];

    $selectAdmin = "SELECT * FROM tbl_admin WHERE admin_email='$email' AND admin_password='$password'";
    $resAdmin = $con->query($selectAdmin);

    $selectStudent = "SELECT * FROM tbl_student WHERE student_email='$email' AND student_password='$password'";
    $resStudent = $con->query($selectStudent);

    if ($dataAdmin = $resAdmin->fetch_assoc()) {
        $_SESSION['aid'] = $dataAdmin['admin_id'];
        header("location:../Admin/Homepage.php");
        exit();
    } 
    else if ($dataStudent = $resStudent->fetch_assoc()) {
        $_SESSION['sid'] = $dataStudent['student_id'];
        header("location:../Student/Homepage.php");
        exit();
    }  
    else {
        ?>
        <script>
        alert('Invalid Credentials');
        window.location='Login.php';
        </script>
        <?php
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="400" border="1" cellpadding="5">
    <tr>
      <td width="150">Email</td>
      <td><input type="email" name="txt_email" id="txt_email" required /></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input type="password" name="txt_password" id="txt_password" required /></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Login" />
      </td>
    </tr>
  </table>
</form>
</body>
</html>

