<?php 
include('../Assets/Connection/Connection.php');
include('Head.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Accept Requests</title>
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="container">

        <!-- 📋 Accept Requests List Table -->
        <div class="table-container card p-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-check-circle me-2 text-success"></i>Accept Requests List</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;"><i class="fas fa-hashtag me-1"></i>#</th>
                            <th style="width: 150px;"><i class="fas fa-user me-1"></i>Student</th>
                            <th><i class="fas fa-align-left me-1"></i>Volunteer Request Details</th>
                            <th style="width: 120px;"><i class="fas fa-box me-1"></i>Product</th>
                            <th style="width: 120px;"><i class="fas fa-building me-1"></i>Tower</th>
                            <th style="width: 120px;"><i class="fas fa-calendar me-1"></i>Request Date</th>
                            <th style="width: 120px;"><i class="fas fa-calendar-day me-1"></i>For Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $selQry = "SELECT ar.*, s.student_name, vr.volunteerrequest_details, vr.volunteerrequest_date, vr.volunteerrequest_fordate, p.product_name, t.tower_name
                                   FROM tbl_acceptrequest ar
                                   INNER JOIN tbl_student s ON ar.student_id = s.student_id
                                   INNER JOIN tbl_volunteerrequest vr ON ar.volunteerrequest_id = vr.volunteerrequest_id
                                   INNER JOIN tbl_producttower pt ON vr.producttower_id = pt.producttower_id
                                   INNER JOIN tbl_product p ON pt.product_id = p.product_id
                                   INNER JOIN tbl_tower t ON pt.tower_id = t.tower_id
                                   ORDER BY ar.acceptrequest_id DESC";
                        $i = 0;
                        $result = $con->query($selQry);
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc())
                            {
                                $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($row["student_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["volunteerrequest_details"]); ?></td>
                            <td><?php echo htmlspecialchars($row["product_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["tower_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["volunteerrequest_date"]); ?></td>
                            <td><?php echo htmlspecialchars($row["volunteerrequest_fordate"]); ?></td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="7" class="text-muted"><i class="fas fa-info-circle me-1"></i>No Accept Requests Found</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php
include('Foot.php');
?>