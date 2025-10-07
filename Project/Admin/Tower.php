<?php 
include('../Assets/Connection/Connection.php');
include('Head.php');

$tower_name = "";
$tower_id = "";

if(isset($_POST['btn_submit']))
{
    $tower_name = trim($_POST['tower_name']);
    $hidden_id = $_POST["txt_hidden"];

    if ($hidden_id != "") {
        // Update (though original doesn't have edit, but for consistency, I'll add it)
        $updQry = "UPDATE tbl_tower SET tower_name='" . $tower_name . "' WHERE tower_id='" . $hidden_id . "'";
        if ($con->query($updQry)) {
            echo "<script>alert('Tower Updated Successfully');window.location='Tower.php';</script>";
        }
    } else {
        // Check duplicate
        $chkQry = "SELECT * FROM tbl_tower WHERE tower_name='" . $tower_name . "'";
        $chkRes = $con->query($chkQry);
        if ($chkRes->num_rows > 0) {
            echo "<script>alert('Tower already exists!');window.location='Tower.php';</script>";
        } else {
            $ins = "INSERT INTO tbl_tower (tower_name) VALUES ('$tower_name')";
            if($con->query($ins))
            {
                ?>
                <script>
                alert("Data Inserted Successfully");
                window.location="Tower.php";
                </script>
                <?php
            }
        }
    }
}

if(isset($_GET["aid"]))
{
    $delQry = "DELETE FROM tbl_tower WHERE tower_id='".$_GET["aid"]."'";
    if($con->query($delQry))
    {
        ?>
        <script>
        alert("Deleted Successfully");
        window.location="Tower.php";
        </script>
        <?php 
    }
}

// Edit mode
if(isset($_GET["eid"]))
{
    $selQry = "SELECT * FROM tbl_tower WHERE tower_id='".$_GET["eid"]."'";
    $res = $con->query($selQry);
    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();
        $tower_name = $data["tower_name"];
        $tower_id = $data["tower_id"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tower Management</title>
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="container">

        <!-- 📦 Tower Form Card -->
        <div class="form-container card p-4 shadow-sm mb-4">
            <h4 class="mb-3"><i class="fas fa-building me-2 text-primary"></i>Manage Tower</h4>
            <form id="form1" name="form1" method="post" action="">
                <input type="hidden" name="txt_hidden" value="<?php echo $tower_id; ?>" />
                <div class="mb-3">
                    <label for="tower_name" class="form-label"><i class="fas fa-tower-cell me-1"></i>Tower Name</label>
                    <input 
                        type="text" 
                        name="tower_name" 
                        id="tower_name" 
                        class="form-control" 
                        value="<?php echo htmlspecialchars($tower_name); ?>" 
                        required 
                        placeholder="Enter Tower Name"
                        pattern="^[A-Z][a-zA-Z\s]*$"
                        title="Only alphabets and spaces allowed. First letter must be capital."
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

        <!-- 📋 Tower List Table -->
        <div class="table-container card p-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-list me-2 text-info"></i>Tower List</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;"><i class="fas fa-hashtag me-1"></i>SI NO</th>
                            <th><i class="fas fa-building me-1"></i>Tower Name</th>
                            <th style="width: 140px;"><i class="fas fa-cogs me-1"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $selQry = "SELECT * FROM tbl_tower ORDER BY tower_name ASC";
                        $i = 0;
                        $result = $con->query($selQry);
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc())
                            {
                                $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($row["tower_name"]); ?></td>
                            <td>
                                <a href="Tower.php?aid=<?php echo $row['tower_id']; ?>" 
                                   class="btn btn-danger btn-sm me-1"
                                   onclick="return confirm('Are you sure you want to delete this tower?');">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </a>
                                <a href="Tower.php?eid=<?php echo $row['tower_id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="3" class="text-muted"><i class="fas fa-info-circle me-1"></i>No Towers Found</td>
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