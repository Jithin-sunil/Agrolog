<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST['btn_submit']))
{
    $complaint_title = $_POST['complaint_title'];
    $complaint_content = $_POST['complaint_content'];
    
    $ins = "INSERT INTO tbl_complaint(complaint_title, complaint_content, student_id) 
            VALUES ('$complaint_title', '$complaint_content', ".$_SESSION['sid'].")";
    
    if($con->query($ins))
    {
        ?>
        <script>
        alert("Data Inserted");
        window.location="Complaint.php";
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
<title>Complaint</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="400" border="1" cellpadding="5">
    <tr>
      <td width="150">Title</td>
      <td><input type="text" name="complaint_title" id="complaint_title" required /></td>
    </tr>
    <tr>
      <td>Content</td>
      <td><textarea name="complaint_content" id="complaint_content" cols="45" rows="5" required></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Send" />
      </td>
    </tr>
  </table>

  <br />

  <table width="800" border="1" cellpadding="5">
    <tr>
      <th>#</th>
      <th>Title</th>
      <th>Content</th>
      <th>Reply</th>
    </tr>
    <?php 
    $selQry = "SELECT * FROM tbl_complaint WHERE student_id = ".$_SESSION['sid'];
    $i = 0;
    $result = $con->query($selQry);
    while($row = $result->fetch_assoc())
    {
        $i++;
    ?>
    <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo $row["complaint_title"]; ?></td>
      <td><?php echo $row["complaint_content"]; ?></td>
      <td><?php echo $row["complaint_reply"]; ?></td>
    </tr>
    <?php
    }
    ?>
  </table>
</form>
</body>
</html>

<?php
include('Foot.php');
?>