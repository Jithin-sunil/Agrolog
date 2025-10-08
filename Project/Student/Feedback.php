<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST['btn_submit']))
{
    $feedback_content = $_POST['feedback_content'];
    
    $ins = "INSERT INTO tbl_feedback(feedback_content, student_id) VALUES ('$feedback_content', ".$_SESSION['sid'].")";
    
    if($con->query($ins))
    {
        ?>
        <script>
        alert("Data Inserted");
        window.location="Feedback.php";
        </script>
        <?php
    }
}
?>

<div class="container feedback-container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card feedback-form-card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Submit Feedback</h4>
                </div>
                <div class="card-body">
                    <form id="form1" name="form1" method="post" action="">
                        <div class="form-group">
                            <label for="feedback_content">Your Feedback</label>
                            <textarea name="feedback_content" id="feedback_content" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="text-center mt-4">
                            <input type="submit" name="btn_submit" id="btn_submit" value="Send" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card feedback-history-card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Feedback History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $selQry = "SELECT * FROM tbl_feedback WHERE student_id = ".$_SESSION['sid'];
                                $i = 0;
                                $result = $con->query($selQry);
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc())
                                    {
                                        $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo htmlspecialchars($row["feedback_content"]); ?></td>
                                </tr>
                                <?php
                                    }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="2" class="text-center">No feedback submitted yet.</td>
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
    </div>
</div>
<style>
    .feedback-container {
        padding-bottom: 50px;
    }
    .feedback-form-card, .feedback-history-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        height: 100%;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .card-title {
        font-weight: 600;
    }
    .feedback-form-card .form-group {
        margin-bottom: 1.5rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<?php
include('Foot.php');
?>