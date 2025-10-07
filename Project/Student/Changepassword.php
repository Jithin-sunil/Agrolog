<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST["btn_submit"]))
{
    $currentPassword = $_POST["txt_password"];
    $newPassword     = $_POST["txt_newpassword"];
    $rePassword      = $_POST["txt_repassword"];

    $selQry = "SELECT * FROM tbl_student WHERE student_id=" . $_SESSION['sid'];
    $res = $con->query($selQry);
    $data = $res->fetch_assoc();

    if($data['student_password'] == $currentPassword)  
    {
        if($newPassword == $rePassword)
        {
            $upQry = "UPDATE tbl_student 
                      SET student_password='$newPassword' 
                      WHERE student_id=" . $_SESSION['sid'];
            if($con->query($upQry))
            {
                ?>
                <script>
                    alert("Password Updated Successfully");
                    window.location = "MyProfile.php";
                </script>
                <?php 
            }
        }
        else
        {
            ?>
            <script>
                alert("The new passwords do not match.");
            </script>
            <?php
        }
    }
    else
    {
        ?>
        <script>
            alert("The current password you entered is incorrect.");
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
<title>Change Password</title>
</head>

<body>
<h3>Change Password</h3>
<form id="form1" name="form1" method="post" action="">
  <table width="400" border="1" cellpadding="5">
    <tr>
      <td width="150">Current Password</td>
      <td><input type="password" name="txt_password" id="txt_password" required /></td>
    </tr>
    <tr>
      <td>New Password</td>
      <td><input type="password" name="txt_newpassword" id="txt_newpassword" required /></td>
    </tr>
    <tr>
      <td>Confirm New Password</td>
      <td><input type="password" name="txt_repassword" id="txt_repassword" required /></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Update Password" />
      </td>
    </tr>
  </table>
</form>
</body>
</html>

<?php
include('Foot.php');
?>