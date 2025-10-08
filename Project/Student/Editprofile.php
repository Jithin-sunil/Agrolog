<?php
session_start();
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST['btn_submit']))
{
    $name   = $_POST["txt_name"];
    $email  = $_POST["txt_email"];
    $rollno = $_POST["txt_roll"];

    if(!empty($_FILES["file_photo"]["name"])) {
        $photo = $_FILES["file_photo"]["name"];
        $path  = $_FILES["file_photo"]["tmp_name"];
        move_uploaded_file($path, "../Assets/Files/Student/Photo/".$photo);

        $upQry = "UPDATE tbl_student 
                  SET student_name='$name', student_email='$email', student_rollno='$rollno', student_photo='$photo' 
                  WHERE student_id=" . $_SESSION['sid'];
    } else {
        $upQry = "UPDATE tbl_student 
                  SET student_name='$name', student_email='$email', student_rollno='$rollno' 
                  WHERE student_id=" . $_SESSION['sid'];
    }

    if ($con->query($upQry)) {
        ?>
        <script>
            alert("Profile Updated Successfully");
            window.location = "MyProfile.php";
        </script>
        <?php
    }
}

$selQry = "SELECT * FROM tbl_student WHERE student_id=" . $_SESSION["sid"];
$result = $con->query($selQry);
$data = $result->fetch_assoc();
?>

<div class="container edit-profile-container">
    <h3 class="text-center">Edit Profile</h3>
    <form id="form1" name="form1" method="post" enctype="multipart/form-data" class="edit-profile-form">
        <div class="text-center mb-4">
            <img src="../Assets/Files/Student/Photo/<?php echo $data['student_photo'] ?>" class="profile-photo-edit" alt="Profile Photo" />
        </div>
        <div class="form-group">
            <label for="txt_name">Name</label>
            <input type="text" name="txt_name" id="txt_name" class="form-control" value="<?php echo $data['student_name'] ?>" required title="Name Allows Only Alphabets,Spaces and First Letter Must Be Capital Letter" pattern="^[A-Z]+[a-zA-Z ]*$" />
        </div>
        <div class="form-group">
            <label for="txt_email">Email</label>
            <input type="email" name="txt_email" id="txt_email" class="form-control" value="<?php echo $data['student_email'] ?>" required />
        </div>
        <div class="form-group">
            <label for="txt_roll">Roll Number</label>
            <input type="text" name="txt_roll" id="txt_roll" class="form-control" value="<?php echo $data['student_rollno'] ?>" required />
        </div>
        <div class="form-group">
            <label for="file_photo">Update Photo</label>
            <input type="file" name="file_photo" id="file_photo" class="form-control-file" />
        </div>
        <div class="form-group text-center">
            <input type="submit" name="btn_submit" id="btn_submit" value="Update" class="btn btn-primary" />
            <input type="reset" name="btn_reset" id="btn_reset" value="Reset" class="btn btn-secondary" />
        </div>
    </form>
</div>
<style>
    .edit-profile-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .edit-profile-form .form-group {
        margin-bottom: 20px;
    }
    .edit-profile-form label {
        font-weight: 600;
    }
    .profile-photo-edit {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #eee;
    }
    .form-control-file {
        display: block;
        width: 100%;
    }
</style>

<?php
include('Foot.php');
?>