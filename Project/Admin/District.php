<?php 
include('../Assets/Connection/Connection.php');
include('Head.php');
$districtname=$districtid="";

if(isset($_POST['btn_district']))
{
	$district=trim($_POST['txt_district']);
	$districtid=$_POST["txt_hidden"];
	if($districtid!="")
	{
		$up="update tbl_district set district_name='".$district."' where district_id='".$districtid."'";
		if($con->query($up))
		{
	 ?>
    <script>
	alert("Data updated")
	window.location="District.php"
	</script>
    <?php
	
	}
	}
	else
	{
		$chkQry = "SELECT * FROM tbl_district WHERE district_name='" . $district . "'";
        $chkRes = $con->query($chkQry);
        if ($chkRes->num_rows > 0) {
            echo "<script>alert('District already exists!');window.location='District.php';</script>";
        } else {
            $ins="insert into tbl_district(district_name)values('".$district."')";
            if($con->query($ins))
            {
                ?>
                <script>
                alert("Data Inserted")
                window.location="District.php"
                </script>
                <?php
            }
        }
	}
}

if(isset($_GET["did"]))
{
	$delQry="delete from tbl_district where district_id='".$_GET["did"]."'";
	if($con->query($delQry))
	{
		?>
        <script>
		alert("Deleted Sucessfully")
		window.location="District.php"
		</script>
	<?php 
	}
}
if(isset($_GET["deid"]))
{
	$sel="Select * from tbl_district where district_id='".$_GET["deid"]."'";
	$res=$con->query($sel);
	if($res->num_rows > 0) {
        $data=$res->fetch_assoc();
        $districtname=$data["district_name"];
        $districtid=$data["district_id"];
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>District Management</title>
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="container">

        <!-- 📦 District Form Card -->
        <div class="form-container card p-4 shadow-sm mb-4">
            <h4 class="mb-3"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Manage District</h4>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="txt_district" class="form-label"><i class="fas fa-map me-1"></i>District Name</label>
                    <input type="hidden" name="txt_hidden" id="txt_hidden" value="<?php echo $districtid; ?>" />
                    <input 
                        type="text" 
                        name="txt_district" 
                        id="txt_district" 
                        class="form-control" 
                        value="<?php echo htmlspecialchars($districtname); ?>" 
                        required 
                        placeholder="Enter District Name"
                        pattern="^[A-Z][a-zA-Z\s]*$"
                        title="Only alphabets and spaces allowed. First letter must be capital."
                    />
                </div>
                <div class="text-center">
                    <button type="submit" name="btn_district" class="btn btn-success me-2 px-4">
                        <i class="fas fa-check me-1"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-secondary px-4">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- 📋 District List Table -->
        <div class="table-container card p-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-list me-2 text-info"></i>District List</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;"><i class="fas fa-hashtag me-1"></i>SI NO</th>
                            <th><i class="fas fa-map me-1"></i>District Name</th>
                            <th style="width: 140px;"><i class="fas fa-cogs me-1"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                        $selQry="select * from tbl_district ORDER BY district_name ASC";
                        $result=$con->query($selQry);
                        if ($result && $result->num_rows > 0) {
                            while($row=$result->fetch_assoc())
                            {
                                $i++;
                                ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($row["district_name"]); ?></td>
                                <td>
                                    <a href="District.php?did=<?php echo $row["district_id"]; ?>" 
                                       class="btn btn-danger btn-sm me-1"
                                       onclick="return confirm('Are you sure you want to delete this district?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </a>
                                    <a href="District.php?deid=<?php echo $row["district_id"]; ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="3" class="text-muted"><i class="fas fa-info-circle me-1"></i>No Districts Found</td>
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