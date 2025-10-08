<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

$student_id = $_SESSION['sid'];
?>

<div class="container my-requests-container mt-5">
    <div class="card requests-table-card">
        <div class="card-header">
            <h2 class="card-title mb-0">My Volunteer Requests</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Tower</th>
                            <th>Details</th>
                            <th>For Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
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
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()){
                                $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <?php echo htmlspecialchars($row['product_name']); ?><br />
                                <img src="../Assets/Files/Photo/<?php echo $row['product_photo']; ?>" class="product-image" alt="Product Photo" />
                            </td>
                            <td><?php echo htmlspecialchars($row['tower_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['volunteerrequest_details']); ?></td>
                            <td><?php echo htmlspecialchars($row['volunteerrequest_fordate']); ?></td>
                            <td>
                                <span class="status-badge <?php echo ($row['volunteerrequest_status'] == 0) ? 'status-pending' : 'status-accepted'; ?>">
                                    <?php echo ($row['volunteerrequest_status'] == 0) ? 'Pending' : 'Accepted'; ?>
                                </span>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">You have no volunteer requests.</td>
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
    .my-requests-container {
        padding-bottom: 50px;
    }
    .requests-table-card {
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
    .product-image {
        width: 100px;
        height: auto;
        border-radius: 5px;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        color: #fff;
        font-weight: 500;
    }
    .status-pending {
        background-color: #ffc107;
    }
    .status-accepted {
        background-color: #28a745;
    }
</style>

<?php
include('Foot.php');
?>