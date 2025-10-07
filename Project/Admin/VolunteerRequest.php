<?php 
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST['btn_submit']))
{
    $details  = trim($_POST['volunteerrequest_details']);
    $producttower_id = $_GET['ptid'];
    $fordate  = $_POST['volunteerrequest_fordate'];
    
    // Check for similar request on same date
    $chkQry = "SELECT * FROM tbl_volunteerrequest WHERE producttower_id='" . $producttower_id . "' AND volunteerrequest_fordate='" . $fordate . "'";
    $chkRes = $con->query($chkQry);
    if ($chkRes->num_rows > 0) {
        echo "<script>alert('Request for this date already exists!');window.location='VolunteerRequest.php?ptid=" . $_GET['ptid'] . "';</script>";
    } else {
        $ins = "INSERT INTO tbl_volunteerrequest
                (volunteerrequest_details, producttower_id, volunteerrequest_date, volunteerrequest_fordate)
                VALUES ('$details', '$producttower_id', CURDATE(), '$fordate')";
        if($con->query($ins))
        {
            ?>
            <script>
            alert("Volunteer Request Submitted Successfully");
            window.location="VolunteerRequest.php?ptid=<?php echo $_GET['ptid']; ?>";
            </script>
            <?php
        } else {
            echo "<script>alert('Error submitting request');</script>";
        }
    }
}

if(isset($_GET["did"]))
{
    $delQry="DELETE FROM tbl_volunteerrequest WHERE volunteerrequest_id='".$_GET["did"]."'";
    if($con->query($delQry))
    {
        ?>
        <script>
        alert("Deleted Successfully");
        window.location="VolunteerRequest.php?ptid=<?php echo $_GET['ptid']; ?>";
        </script>
        <?php 
    } else {
        echo "<script>alert('Error deleting request');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Request Management</title>
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="container">

        <!-- 📝 Volunteer Request Form Card -->
        <div class="form-container card p-4 shadow-sm mb-4">
            <h4 class="mb-3"><i class="fas fa-hands-helping me-2 text-primary"></i>Create Volunteer Request</h4>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="volunteerrequest_details" class="form-label"><i class="fas fa-align-left me-1"></i>Details</label>
                    <textarea 
                        name="volunteerrequest_details" 
                        id="volunteerrequest_details" 
                        class="form-control" 
                        rows="5" 
                        required
                        placeholder="Enter volunteer request details..."
                    ></textarea>
                </div>
                <div class="mb-3">
                    <label for="volunteerrequest_fordate" class="form-label"><i class="fas fa-calendar-day me-1"></i>For Date</label>
                    <input 
                        type="date" 
                        name="volunteerrequest_fordate" 
                        id="volunteerrequest_fordate" 
                        class="form-control" 
                        min="<?php echo date('Y-m-d')?>"
                        required 
                    />
                </div>
                <div class="text-center">
                    <button type="submit" name="btn_submit" class="btn btn-success me-2 px-4">
                        <i class="fas fa-check me-1"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-secondary px-4">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- 📋 Volunteer Request List Table -->
        <div class="table-container card p-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-list me-2 text-info"></i>Volunteer Request List</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;"><i class="fas fa-hashtag me-1"></i>#</th>
                            <th><i class="fas fa-align-left me-1"></i>Details</th>
                            <th style="width: 120px;"><i class="fas fa-box me-1"></i>Product</th>
                            <th style="width: 120px;"><i class="fas fa-building me-1"></i>Tower</th>
                            <th style="width: 120px;"><i class="fas fa-calendar me-1"></i>Request Date</th>
                            <th style="width: 120px;"><i class="fas fa-calendar-day me-1"></i>For Date</th>
                            <th style="width: 100px;"><i class="fas fa-info-circle me-1"></i>Status</th>
                            <th style="width: 120px;"><i class="fas fa-cogs me-1"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $selQry = "SELECT vr.*, p.product_name, t.tower_name 
                                   FROM tbl_volunteerrequest vr
                                   INNER JOIN tbl_producttower pt ON vr.producttower_id = pt.producttower_id
                                   INNER JOIN tbl_product p ON pt.product_id = p.product_id
                                   INNER JOIN tbl_tower t ON pt.tower_id = t.tower_id
                                   WHERE vr.producttower_id = '" . $_GET['ptid'] . "'
                                   ORDER BY vr.volunteerrequest_id DESC";
                        $result = $con->query($selQry);
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc())
                            {
                                $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($row['volunteerrequest_details']); ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['tower_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['volunteerrequest_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['volunteerrequest_fordate']); ?></td>
                            <td>
                                <span class="badge <?php echo $row['volunteerrequest_status'] == 0 ? 'bg-warning' : 'bg-success'; ?>">
                                    <?php echo $row['volunteerrequest_status'] == 0 ? 'Pending' : 'Accepted'; ?>
                                </span>
                            </td>
                            <td>
                                <a href="VolunteerRequest.php?did=<?php echo $row['volunteerrequest_id']; ?>&ptid=<?php echo $_GET['ptid']; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this request?');">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php } 
                        } else {
                        ?>
                        <tr>
                            <td colspan="8" class="text-muted"><i class="fas fa-info-circle me-1"></i>No Requests Found</td>
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