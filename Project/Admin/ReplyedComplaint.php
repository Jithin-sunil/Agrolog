<?php 
include('../Assets/Connection/Connection.php');
include('Head.php');

$complaint_id = "";
$reply_content = "";
$edit_mode = false;

if(isset($_POST['btn_update_reply'])) {
    $complaint_id = $_POST['hidden_complaint_id'];
    $new_reply = trim($_POST['txt_reply']);
    
    $updateQry = "UPDATE tbl_complaint SET complaint_reply = '" . $new_reply . "' WHERE complaint_id = '" . $complaint_id . "'";
    if($con->query($updateQry)) {
        echo "<script>alert('Reply Updated Successfully');window.location='Complaint.php';</script>";
    } else {
        echo "<script>alert('Error updating reply');</script>";
    }
}

if(isset($_GET['eid'])) {
    $editQry = "SELECT * FROM tbl_complaint WHERE complaint_id = '" . $_GET['eid'] . "'";
    $editRes = $con->query($editQry);
    if($editRes->num_rows > 0) {
        $editData = $editRes->fetch_assoc();
        $complaint_id = $editData['complaint_id'];
        $reply_content = $editData['complaint_reply'];
        $edit_mode = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management</title>
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="container">

        <!-- 📝 Reply Update Form (Hidden by default, shown on edit) -->
        <?php if($edit_mode): ?>
        <div class="form-container card p-4 shadow-sm mb-4">
            <h4 class="mb-3"><i class="fas fa-reply me-2 text-primary"></i>Update Reply</h4>
            <form method="post" action="">
                <input type="hidden" name="hidden_complaint_id" value="<?php echo $complaint_id; ?>" />
                <div class="mb-3">
                    <label for="txt_reply" class="form-label"><i class="fas fa-comment-dots me-1"></i>Reply</label>
                    <textarea 
                        name="txt_reply" 
                        id="txt_reply" 
                        class="form-control" 
                        rows="4"
                        required
                    ><?php echo htmlspecialchars($reply_content); ?></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" name="btn_update_reply" class="btn btn-success me-2 px-4">
                        <i class="fas fa-check me-1"></i> Update Reply
                    </button>
                    <a href="Complaint.php" class="btn btn-secondary px-4">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- 📋 Complaints List Table -->
        <div class="table-container card p-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-exclamation-triangle me-2 text-warning"></i>Complaints List</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;"><i class="fas fa-hashtag me-1"></i>#</th>
                            <th style="width: 150px;"><i class="fas fa-user me-1"></i>Student</th>
                            <th style="width: 150px;"><i class="fas fa-heading me-1"></i>Title</th>
                            <th><i class="fas fa-align-left me-1"></i>Details</th>
                            <th style="width: 150px;"><i class="fas fa-reply me-1"></i>Reply</th>
                            <th style="width: 120px;"><i class="fas fa-cogs me-1"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $selQry = "SELECT c.*, s.student_name FROM tbl_complaint c JOIN tbl_student s ON c.student_id = s.student_id ORDER BY c.complaint_id DESC";
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
                            <td><?php echo htmlspecialchars($row["complaint_title"]); ?></td>
                            <td><?php echo htmlspecialchars($row["complaint_content"]); ?></td>
                            <td><?php echo htmlspecialchars($row["complaint_reply"] ?? 'No Reply Yet'); ?></td>
                            <td>
                                <a href="Complaint.php?eid=<?php echo $row['complaint_id']; ?>" 
                                   class="btn btn-primary btn-sm"
                                   <?php if($edit_mode && $complaint_id == $row['complaint_id']) echo 'style="display:none;"'; ?>>
                                    <i class="fas fa-edit me-1"></i> Edit Reply
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="6" class="text-muted"><i class="fas fa-info-circle me-1"></i>No Complaints Found</td>
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