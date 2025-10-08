<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST["btn_submit"]))
{
    $currentPassword = $_POST["txt_password"];
    $newPassword     = $_POST["txt_newpassword"];
    $rePassword      = $_POST["txt_repassword"];

    $selQry = "SELECT * FROM tbl_student WHERE student_id=" . $_SESSION['sid'];
    $res = $con->query($selQry);
    $data = $res->fetch_assoc();

    if($data['student_password'] == $currentPassword)  
    {
        if($newPassword == $rePassword)
        {
            $upQry = "UPDATE tbl_student 
                      SET student_password='$newPassword' 
                      WHERE student_id=" . $_SESSION['sid'];
            if($con->query($upQry))
            {
                ?>
                <script>
                    alert("Password Updated Successfully");
                    window.location = "MyProfile.php";
                </script>
                <?php 
            }
        }
        else
        {
            ?>
            <script>
                alert("The new passwords do not match.");
            </script>
            <?php
        }
    }
    else
    {
        ?>
        <script>
            alert("The current password you entered is incorrect.");
        </script>
        <?php
    }
}
?>

<div class="container change-password-container">
    <h3 class="text-center">Change Password</h3>
    <form id="form1" name="form1" method="post" action="" class="change-password-form">
        <div class="form-group">
            <label for="txt_password">Current Password</label>
            <input type="password" name="txt_password" id="txt_password" class="form-control" required />
        </div>
        <div class="form-group">
            <label for="txt_newpassword">New Password</label>
            <input type="password" name="txt_newpassword" id="txt_newpassword" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
        </div>
        <div class="form-group">
            <label for="txt_repassword">Confirm New Password</label>
            <input type="password" name="txt_repassword" id="txt_repassword" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
        </div>
        <div class="form-group text-center">
            <input type="submit" name="btn_submit" id="btn_submit" value="Update Password" class="btn btn-primary" />
        </div>
    </form>
</div>
<style>
    .change-password-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .change-password-form .form-group {
        margin-bottom: 20px;
    }
    .change-password-form label {
        font-weight: 600;
        margin-bottom: 5px;
    }
    .change-password-form .btn-primary {
        padding: 10px 20px;
        border-radius: 5px;
    }
</style>

<?php
include('Foot.php');
?>