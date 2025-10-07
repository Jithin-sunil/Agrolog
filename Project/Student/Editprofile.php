<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST['btn_submit']))
{
    $name   = $_POST["txt_name"];
    $email  = $_POST["txt_email"];
    $rollno = $_POST["txt_roll"];

    if(!empty($_FILES["file_photo"]["name"])) {
        $photo = $_FILES["file_photo"]["name"];
        $path  = $_FILES["file_photo"]["tmp_name"];
        move_uploaded_file($path, "../Assets/Files/Student/Photo/".$photo);

        $upQry = "UPDATE tbl_student 
                  SET student_name='$name', student_email='$email', student_rollno='$rollno', student_photo='$photo' 
                  WHERE student_id=" . $_SESSION['sid'];
    } else {
        $upQry = "UPDATE tbl_student 
                  SET student_name='$name', student_email='$email', student_rollno='$rollno' 
                  WHERE student_id=" . $_SESSION['sid'];
    }

    if ($con->query($upQry)) {
        ?>
        <script>
            alert("Profile Updated Successfully");
            window.location = "MyProfile.php";
        </script>
        <?php
    }
}

$selQry = "SELECT * FROM tbl_student WHERE student_id=" . $_SESSION["sid"];
$result = $con->query($selQry);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Profile</title>
</head>

<body>
<h3>Edit Profile</h3>
<form id="form1" name="form1" method="post" enctype="multipart/form-data">
  <table width="400" border="1" cellpadding="5">
    <tr>
      <td colspan="2" align="center">
        <img src="../Assets/Files/Student/Photo/<?php echo $data['student_photo'] ?>" width="120" height="120" alt="Profile Photo" />
      </td>
    </tr>
    <tr>
      <td width="150">Name</td>
      <td><input type="text" name="txt_name" id="txt_name" value="<?php echo $data['student_name'] ?>" required /></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input type="email" name="txt_email" id="txt_email" value="<?php echo $data['student_email'] ?>" required /></td>
    </tr>
    <tr>
      <td>Roll Number</td>
      <td><input type="text" name="txt_roll" id="txt_roll" value="<?php echo $data['student_rollno'] ?>" required /></td>
    </tr>
    <tr>
      <td>Update Photo</td>
      <td><input type="file" name="file_photo" id="file_photo" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Update" />
        <input type="reset" name="btn_reset" id="btn_reset" value="Reset" />
      </td>
    </tr>
  </table>
</form>
</body>
</html>

<?php
include('Foot.php');
?>