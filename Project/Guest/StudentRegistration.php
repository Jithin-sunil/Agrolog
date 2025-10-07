<?php
include('../Assets/Connection/Connection.php');


if (isset($_POST["btn_submit"])) {
    $name       = $_POST['txt_name'];
    $email      = $_POST['txt_email'];
    $rollnum    = $_POST['txt_roll'];
    $password   = $_POST['txt_pass'];
    $re_password= $_POST['txt_repass'];

    $photo = $_FILES["file_photo"]["name"];
    $path  = $_FILES["file_photo"]["tmp_name"];
    move_uploaded_file($path, "../Assets/Files/Student/Photo/" . $photo);

    if ($password == $re_password) {
        $selQry = "SELECT * FROM tbl_student WHERE student_email = '$email'";
        $res = $con->query($selQry);
        if ($res->num_rows > 0) {
            ?>
            <script>
            alert("This email is already registered.");
            </script>
            <?php
        } else {
            $insQry = "INSERT INTO tbl_student(student_name, student_email, student_password, student_photo, student_rollno) 
                       VALUES ('$name','$email','$password','$photo','$rollnum')";
            if ($con->query($insQry)) {
                ?>
                <script>
                    alert("Registration Successful");
                    window.location = "Login.php";
                </script>
                <?php
            }
        }
    } else {
        ?>
        <script>
        alert("Passwords do not match.");
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
<title>Student Registration</title>
</head>

<body>
<h2>Student Registration</h2>
<form action="" method="post" enctype="multipart/form-data" name="form1">
  <table width="400" border="1" cellpadding="5">
    <tr>
      <td width="150">Name</td>
      <td><input type="text" name="txt_name" id="txt_name" required /></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input type="email" name="txt_email" id="txt_email" required /></td>
    </tr>
    <tr>
      <td>Roll Number</td>
      <td><input type="text" name="txt_roll" id="txt_roll" required /></td>
    </tr>
    <tr>
      <td>Photo</td>
      <td><input type="file" name="file_photo" id="file_photo" required /></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input type="password" name="txt_pass" id="txt_pass" required /></td>
    </tr>
    <tr>
      <td>Confirm Password</td>
      <td><input type="password" name="txt_repass" id="txt_repass" required /></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
        <input type="reset" name="btn_reset" id="btn_reset" value="Reset" />
      </td>
    </tr>
  </table>
</form>
</body>
</html>
