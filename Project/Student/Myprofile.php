<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

$selQry = "SELECT * FROM tbl_student WHERE student_id=" . $_SESSION["sid"];
$result = $con->query($selQry);
$data = $result->fetch_assoc();
?>

<div class="container my-profile-container">
    <h3 class="text-center profile-title">My Profile</h3>
    <br><br>
    <div class="card profile-card">
        <div class="card-body text-center">
            <img src="../Assets/Files/Student/Photo/<?php echo $data['student_photo'] ?>" class="profile-photo" alt="Profile Photo" />
            <h4 class="card-title mt-3"><?php echo $data["student_name"] ?></h4>
            <p class="card-text text-muted"><?php echo $data["student_email"] ?></p>
            <p class="card-text"><strong>Roll Number:</strong> <?php echo $data["student_rollno"] ?></p>
            <hr>
            <a href="EditProfile.php" class="btn btn-primary profile-btn">Edit Profile</a>
            <a href="ChangePassword.php" class="btn btn-secondary profile-btn">Change Password</a>
        </div>
    </div>
</div>
<style>
    .my-profile-container {
        max-width: 500px;
        margin: 50px auto;
    }
    .profile-title {
        margin-bottom: 30px;
    }
    .profile-card {
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .profile-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-top: -60px;
        border: 5px solid #fff;
    }
    .profile-card .card-title {
        font-size: 1.5rem;
        font-weight: 600;
    }
    .profile-card .card-text {
        font-size: 1rem;
    }
    .profile-btn {
        margin: 5px;
        padding: 8px 20px;
        border-radius: 5px;
    }
</style>

<?php
include('Foot.php');
?>