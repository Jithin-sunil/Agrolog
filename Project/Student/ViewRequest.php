<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

$student_id = $_SESSION['sid'];
if(isset($_GET['rid']))
{
    $vr_id = $_GET['rid'];

    $check = $con->query("SELECT * FROM tbl_acceptrequest WHERE student_id=$student_id AND volunteerrequest_id=$vr_id");
    if($check->num_rows == 0){
        $ins = "INSERT INTO tbl_acceptrequest(student_id, volunteerrequest_id) VALUES ($student_id, $vr_id)";
        if($con->query($ins)){
            ?>
            <script>
            alert("Request Sent Successfully");
            window.location="ViewRequest.php";
            </script>
            <?php
        }
    } else {
        ?>
        <script>
        alert("You have already requested this volunteer task");
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
<title>Available Volunteer Requests</title>
</head>

<body>

<h2>Available Volunteer Requests</h2>
<table width="100%" border="1" cellpadding="5">
  <tr>
    <th>#</th>
    <th>Product</th>
    <th>Details</th>
    <th>Photo</th>
    <th>Tower</th>
    <th>Request Date</th>
    <th>For Date</th>
    <th>Action</th>
  </tr>
  <?php
  $i = 0;
  $selQry = "SELECT *
             FROM tbl_volunteerrequest vr
             INNER JOIN tbl_producttower pt ON vr.producttower_id = pt.producttower_id
             INNER JOIN tbl_product p ON pt.product_id = p.product_id
             INNER JOIN tbl_tower t ON pt.tower_id = t.tower_id
             WHERE vr.volunteerrequest_status=0";  
  $result = $con->query($selQry);
  while($row = $result->fetch_assoc())
  {
      $i++;
  ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $row['product_name']; ?></td>
    <td><?php echo $row['volunteerrequest_details']; ?><br />
        <small><?php echo $row['product_details']; ?></small>
    </td>
    <td>
      <img src="../Assets/Files/Photo/<?php echo $row['product_photo']; ?>" 
           width="120" height="60" alt="Product Photo" />
    </td>
    <td><?php echo $row['tower_name']; ?></td>
    <td><?php echo $row['volunteerrequest_date']; ?></td>
    <td><?php echo $row['volunteerrequest_fordate']; ?></td>
    <td>
      <a href="ViewRequest.php?rid=<?php echo $row['volunteerrequest_id']; ?>" 
         onclick="return confirm('Send request for this volunteer task?');">
         Request
      </a>
    </td>
  </tr>
  <?php } ?>
</table>

</body>
</html>

<?php
include('Foot.php');
?>