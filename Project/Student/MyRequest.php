<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

$student_id = $_SESSION['sid'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Requests</title>
</head>

<body>

<h2>My Volunteer Requests</h2>
<table width="100%" border="1" cellpadding="5">
  <tr>
    <th>#</th>
    <th>Product</th>
    <th>Tower</th>
    <th>Details</th>
    <th>For Date</th>
    <th>Status</th>
  </tr>
  <?php
  $i = 0;
  $selQry = "SELECT vr.*, ar.*, p.product_name, p.product_photo, t.tower_name
             FROM tbl_acceptrequest ar
             INNER JOIN tbl_volunteerrequest vr ON ar.volunteerrequest_id = vr.volunteerrequest_id
             INNER JOIN tbl_producttower pt ON vr.producttower_id = pt.producttower_id
             INNER JOIN tbl_product p ON pt.product_id = p.product_id
             INNER JOIN tbl_tower t ON pt.tower_id = t.tower_id
             WHERE ar.student_id=$student_id";
  $result = $con->query($selQry);
  while($row = $result->fetch_assoc()){
      $i++;
  ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td>
      <?php echo $row['product_name']; ?><br />
      <img src="../Assets/Files/Photo/<?php echo $row['product_photo']; ?>" width="100" height="50" alt="Product Photo" />
    </td>
    <td><?php echo $row['tower_name']; ?></td>
    <td><?php echo $row['volunteerrequest_details']; ?></td>
    <td><?php echo $row['volunteerrequest_fordate']; ?></td>
    <td><?php echo ($row['volunteerrequest_status'] == 0) ? 'Pending' : 'Accepted'; ?></td>
  </tr>
  <?php } ?>
</table>

</body>
</html>

<?php
include('Foot.php');
?>