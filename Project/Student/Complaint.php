<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST['btn_submit']))
{
    $complaint_title = $_POST['complaint_title'];
    $complaint_content = $_POST['complaint_content'];
    
    $ins = "INSERT INTO tbl_complaint(complaint_title, complaint_content, student_id) 
            VALUES ('$complaint_title', '$complaint_content', ".$_SESSION['sid'].")";
    
    if($con->query($ins))
    {
        ?>
        <script>
        alert("Data Inserted");
        window.location="Complaint.php";
        </script>
        <?php
    }
}
?>

<div class="container complaint-container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card complaint-form-card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Submit a Complaint</h4>
                </div>
                <div class="card-body">
                    <form id="form1" name="form1" method="post" action="">
                        <div class="form-group">
                            <label for="complaint_title">Title</label>
                            <input type="text" name="complaint_title" id="complaint_title" class="form-control" required  />
                        </div>
                        <div class="form-group">
                            <label for="complaint_content">Content</label>
                            <textarea name="complaint_content" id="complaint_content" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="text-center">
                            <input type="submit" name="btn_submit" id="btn_submit" value="Send" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card complaint-history-card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Complaint History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Reply</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $selQry = "SELECT * FROM tbl_complaint WHERE student_id = ".$_SESSION['sid'];
                                $i = 0;
                                $result = $con->query($selQry);
                                while($row = $result->fetch_assoc())
                                {
                                    $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row["complaint_title"]; ?></td>
                                    <td><?php echo $row["complaint_content"]; ?></td>
                                    <td><?php echo $row["complaint_reply"] ? $row["complaint_reply"] : 'No reply yet'; ?></td>
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
    .complaint-container {
        padding-bottom: 50px;
    }
    .complaint-form-card, .complaint-history-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .card-title {
        font-weight: 600;
    }
    .complaint-form-card .form-group {
        margin-bottom: 1.5rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<?php
include('Foot.php');
?>