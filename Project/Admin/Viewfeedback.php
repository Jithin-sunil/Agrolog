<?php 
include('../Assets/Connection/Connection.php');
include('Head.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="container">

        <!-- 📋 Feedback List Table -->
        <div class="table-container card p-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-comments me-2 text-success"></i>Feedback List</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;"><i class="fas fa-hashtag me-1"></i>#</th>
                            <th style="width: 150px;"><i class="fas fa-user me-1"></i>Student</th>
                            <th><i class="fas fa-comment me-1"></i>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $selQry = "SELECT f.*, s.student_name FROM tbl_feedback f JOIN tbl_student s ON f.student_id = s.student_id ORDER BY f.feedback_id DESC";
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
                            <td><?php echo htmlspecialchars($row["feedback_content"]); ?></td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="3" class="text-muted"><i class="fas fa-info-circle me-1"></i>No Feedback Found</td>
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