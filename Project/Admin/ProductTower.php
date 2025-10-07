<?php
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST['btn_submit']))
{
    $tower_id   = $_POST['tower_id'];
    $product_id = $_GET['pid'];

    // Check for duplicate mapping
    $chkQry = "SELECT * FROM tbl_producttower WHERE tower_id='" . $tower_id . "' AND product_id='" . $product_id . "'";
    $chkRes = $con->query($chkQry);
    if ($chkRes->num_rows > 0) {
        echo "<script>alert('This tower is already mapped to the product!');window.location='ProductTower.php?pid=" . $_GET['pid'] . "';</script>";
    } else {
        $ins = "INSERT INTO tbl_producttower (tower_id, product_id) VALUES ('$tower_id', '$product_id')";
        if($con->query($ins)){
            ?>
            <script>
            alert("Mapping Inserted Successfully");
            window.location="ProductTower.php?pid=<?php echo $_GET['pid']?>";
            </script>
            <?php
        } else {
            ?>
            <script>
            alert("Error inserting data");
            </script>
            <?php
        }
    }
}

if(isset($_GET["aid"]))
{
    $aid = $_GET["aid"];
    $delQry = "DELETE FROM tbl_producttower WHERE producttower_id='" . $aid . "'";
    if($con->query($delQry)){
        ?>
        <script>
        alert("Mapping Deleted Successfully");
        window.location="ProductTower.php?pid=<?php echo $_GET['pid']?>";
        </script>
        <?php
    } else {
        ?>
        <script>
        alert("Error deleting");
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
    <title>Product Tower Management</title>
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="container">

        <!-- 📦 Mapping Form Card -->
        <div class="form-container card p-4 shadow-sm mb-4">
            <h4 class="mb-3"><i class="fas fa-link me-2 text-primary"></i>Map Product to Tower</h4>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="tower_id" class="form-label"><i class="fas fa-building me-1"></i>Select Tower</label>
                    <select name="tower_id" id="tower_id" class="form-select" required>
                        <option value="">Select Tower</option>
                        <?php
                        $towerQry = $con->query("SELECT * FROM tbl_tower ORDER BY tower_name ASC");
                        if ($towerQry && $towerQry->num_rows > 0) {
                            while($tower = $towerQry->fetch_assoc()){
                                ?>
                                <option value="<?php echo $tower['tower_id']; ?>"><?php echo htmlspecialchars($tower['tower_name']); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
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

        <!-- 📋 Mapped Towers Table -->
        <div class="table-container card p-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-list me-2 text-info"></i>Mapped Towers for this Product</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;"><i class="fas fa-hashtag me-1"></i></th>
                            <th style="width: 200px;"><i class="fas fa-building me-1"></i>Tower Name</th>
                            <th style="width: 200px;"><i class="fas fa-box me-1"></i>Product Name</th>
                            <th style="width: 180px;"><i class="fas fa-cogs me-1"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $selQry = "SELECT * 
                                   FROM tbl_producttower pt
                                   INNER JOIN tbl_tower t ON pt.tower_id = t.tower_id
                                   INNER JOIN tbl_product p ON pt.product_id = p.product_id
                                   WHERE pt.product_id='".$_GET['pid']."' ORDER BY t.tower_name ASC";
                        $result = $con->query($selQry);
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()){
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo htmlspecialchars($row['tower_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                    <td>
                                        <a href="ProductTower.php?aid=<?php echo $row['producttower_id']; ?>&pid=<?php echo $_GET['pid']; ?>" 
                                           class="btn btn-danger btn-sm me-1"
                                           onclick="return confirm('Are you sure you want to delete this mapping?');">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </a>
                                        <a href="VolunteerRequest.php?ptid=<?php echo $row['producttower_id']?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-users me-1"></i> Volunteer Request
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="4" class="text-muted"><i class="fas fa-info-circle me-1"></i>No Mappings Found</td>
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