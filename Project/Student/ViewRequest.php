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

<div class="container view-requests-container mt-5">
    <div class="card available-requests-card">
        <div class="card-header">
            <h2 class="card-title mb-0">Available Volunteer Requests</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
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
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $selQry = "SELECT *
                                 FROM tbl_volunteerrequest vr
                                 INNER JOIN tbl_producttower pt ON vr.producttower_id = pt.producttower_id
                                 INNER JOIN tbl_product p ON pt.product_id = p.product_id
                                 INNER JOIN tbl_tower t ON pt.tower_id = t.tower_id
                                 WHERE vr.volunteerrequest_status=0";  
                        $result = $con->query($selQry);
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc())
                            {
                                $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($row['volunteerrequest_details']); ?><br />
                                <small class="text-muted"><?php echo htmlspecialchars($row['product_details']); ?></small>
                            </td>
                            <td>
                                <img src="../Assets/Files/Photo/<?php echo $row['product_photo']; ?>" class="request-product-image" alt="Product Photo" />
                            </td>
                            <td><?php echo htmlspecialchars($row['tower_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['volunteerrequest_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['volunteerrequest_fordate']); ?></td>
                            <td>
                                <a href="ViewRequest.php?rid=<?php echo $row['volunteerrequest_id']; ?>" 
                                   class="btn btn-success btn-sm request-action-btn"
                                   onclick="return confirm('Send request for this volunteer task?');">
                                   Request
                                </a>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="8" class="text-center">No available volunteer requests at the moment.</td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    .view-requests-container {
        padding-bottom: 50px;
    }
    .available-requests-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .card-title {
        font-weight: 600;
    }
    .request-product-image {
        width: 120px;
        height: auto;
        border-radius: 5px;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .request-action-btn {
        white-space: nowrap;
    }
</style>

<?php
include('Foot.php');
?>