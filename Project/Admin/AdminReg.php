<?php
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST['submit']))
{
    $admin_name = $_POST['admin_name'];
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];

    $ins = "INSERT INTO tbl_admin (admin_name, admin_email, admin_password) 
            VALUES ('$admin_name', '$admin_email', '$admin_password')";

    if($con->query($ins))
    {
        ?>
        <script>
        alert("Data inserted");
        window.location="AdminReg.php";
        </script>
        <?php
    }
}

if(isset($_GET["aid"]))
{
    $delQry = "DELETE FROM tbl_admin WHERE admin_id=".$_GET["aid"];
    if($con->query($delQry))
    {
        ?>
        <script>
        alert("Deleted Successfully");
        window.location="AdminReg.php";
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
<title>Admin Registration</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">

<table width="400" border="1" cellpadding="5">
  <tr>
    <td>Name</td>
    <td><input type="text" name="admin_name" id="admin_name" required /></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="email" name="admin_email" id="admin_email" required /></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="password" name="admin_password" id="admin_password" required /></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input type="submit" name="submit" id="submit" value="Submit" />
    </td>
  </tr>
</table>

<br />

<table width="500" border="1" cellpadding="5">
  <tr>
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
  </tr>
  <?php 
  $selQry = "SELECT * FROM tbl_admin";
  $i = 0;
  $result = $con->query($selQry);
  while($row = $result->fetch_assoc())
  {
      $i++;
  ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $row["admin_name"]; ?></td>
    <td><?php echo $row["admin_email"]; ?></td>
    <td><a href="AdminReg.php?aid=<?php echo $row["admin_id"]; ?>" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a></td>
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