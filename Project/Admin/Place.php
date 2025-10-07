<?php 
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST["btn_submit"]))
{
	$district=trim($_POST["sel_district"]);
	$place=trim($_POST["txt_place"]);
	
	$chkQry = "SELECT * FROM tbl_place WHERE place_name='" . $place . "' AND district_id='" . $district . "'";
    $chkRes = $con->query($chkQry);
    if ($chkRes->num_rows > 0) {
        echo "<script>alert('Place already exists for this district!');window.location='Place.php';</script>";
    } else {
        $insQry="insert into tbl_place(place_name,district_id)
        values('".$place."','".$district."')";
        
        if($con->query($insQry))
        {
            ?>
            <script>
            alert("Data Inserted Successfully")
            window.location="Place.php"
            </script>
            <?php
        }
    }
}
if(isset($_GET["did"]))
{
	$delQry="delete from tbl_place where place_id='".$_GET["did"]."'";
	if($con->query($delQry))
	{
		?>
        <script>
		alert("Deleted Successfully")
		window.location="Place.php"
		</script>
	<?php 
	}
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Management</title>
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="container">

        <!-- 📦 Place Form Card -->
        <div class="form-container card p-4 shadow-sm mb-4">
            <h4 class="mb-3"><i class="fas fa-location-dot me-2 text-primary"></i>Manage Place</h4>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="sel_district" class="form-label"><i class="fas fa-map me-1"></i>District</label>
                    <select name="sel_district" id="sel_district" class="form-select" required>
                        <option value="">Select District</option>
                        <?php
                        $sel="select * from tbl_district ORDER BY district_name ASC";
                        $result=$con->query($sel);
                        if ($result && $result->num_rows > 0) {
                            while($row=$result->fetch_assoc())
                            { 
                                ?>
                                <option value="<?php echo $row['district_id']; ?>"><?php echo htmlspecialchars($row['district_name']); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="txt_place" class="form-label"><i class="fas fa-location-dot me-1"></i>Place Name</label>
                    <input 
                        type="text" 
                        name="txt_place" 
                        id="txt_place" 
                        class="form-control" 
                        required 
                        placeholder="Enter Place Name"
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

        <!-- 📋 Place List Table -->
        <div class="table-container card p-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-list me-2 text-info"></i>Place List</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;"><i class="fas fa-hashtag me-1"></i>SI NO</th>
                            <th><i class="fas fa-location-dot me-1"></i>Place Name</th>
                            <th><i class="fas fa-map-marker-alt me-1"></i>District</th>
                            <th style="width: 140px;"><i class="fas fa-cogs me-1"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                        $selQry="SELECT p.place_id, p.place_name, d.district_name FROM tbl_place p JOIN tbl_district d ON p.district_id = d.district_id ORDER BY p.place_name ASC";
                        $result=$con->query($selQry);
                        if ($result && $result->num_rows > 0) {
                            while($row=$result->fetch_assoc())
                            {
                                $i++;
                                ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($row["place_name"]); ?></td>
                                <td><?php echo htmlspecialchars($row["district_name"]); ?></td>
                                <td>
                                    <a href="Place.php?did=<?php echo $row["place_id"]; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this place?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="4" class="text-muted"><i class="fas fa-info-circle me-1"></i>No Places Found</td>
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