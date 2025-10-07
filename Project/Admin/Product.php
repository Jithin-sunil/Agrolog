<?php
include('../Assets/Connection/Connection.php');
include('Head.php');

if(isset($_POST['btn_submit']))
{
    $product_name    = trim($_POST['product_name']);
    $product_details = trim($_POST['product_details']);

    $Photo = $_FILES['file_photo']['name'];
    $Path  = $_FILES['file_photo']['tmp_name'];

    if (!empty($Photo)) {
        move_uploaded_file($Path, '../Assets/Files/Photo/'.$Photo);
    }

    // Check for duplicate product name
    $chkQry = "SELECT * FROM tbl_product WHERE product_name='" . $product_name . "'";
    $chkRes = $con->query($chkQry);
    if ($chkRes->num_rows > 0) {
        echo "<script>alert('Product already exists!');window.location='Product.php';</script>";
    } else {
        $ins = "INSERT INTO tbl_product (product_name, product_details, product_photo) 
                VALUES ('$product_name', '$product_details', '$Photo')";

        if($con->query($ins))
        {
            ?>
            <script>
            alert("Data Inserted Successfully");
            window.location="Product.php";
            </script>
            <?php
        }
    }
}

if(isset($_GET["aid"]))
{
    $delQry = "DELETE FROM tbl_product WHERE product_id='".$_GET["aid"]."'";
    if($con->query($delQry))
    {
        ?>
        <script>
        alert("Deleted Successfully");
        window.location="Product.php";
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
    <title>Product Management</title>
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="container">

        <!-- 📦 Product Form Card -->
        <div class="form-container card p-4 shadow-sm mb-4">
            <h4 class="mb-3"><i class="fas fa-box me-2 text-primary"></i>Manage Product</h4>
            <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                <div class="mb-3">
                    <label for="product_name" class="form-label"><i class="fas fa-tag me-1"></i>Product Name</label>
                    <input 
                        type="text" 
                        name="product_name" 
                        id="product_name" 
                        class="form-control" 
                        required 
                        placeholder="Enter Product Name"
                        pattern="^[A-Z][a-zA-Z\s]*$"
                        title="Only alphabets and spaces allowed. First letter must be capital."
                    />
                </div>
                <div class="mb-3">
                    <label for="product_details" class="form-label"><i class="fas fa-info-circle me-1"></i>Product Details</label>
                    <input 
                        type="text" 
                        name="product_details" 
                        id="product_details" 
                        class="form-control" 
                        required 
                        placeholder="Enter Product Details"
                    />
                </div>
                <div class="mb-3">
                    <label for="file_photo" class="form-label"><i class="fas fa-image me-1"></i>Product Photo</label>
                    <input 
                        type="file" 
                        name="file_photo" 
                        id="file_photo" 
                        class="form-control" 
                        accept="image/*"
                        required 
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

        <!-- 📋 Product List Table -->
        <div class="table-container card p-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-list me-2 text-info"></i>Product List</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;"><i class="fas fa-hashtag me-1"></i></th>
                            <th style="width: 200px;"><i class="fas fa-tag me-1"></i>Name</th>
                            <th><i class="fas fa-info-circle me-1"></i>Details</th>
                            <th style="width: 150px;"><i class="fas fa-image me-1"></i>Photo</th>
                            <th style="width: 200px;"><i class="fas fa-cogs me-1"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $selQry = "SELECT * FROM tbl_product ORDER BY product_name ASC";
                        $i = 0;
                        $result = $con->query($selQry);
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc())
                            {
                                $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($row["product_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["product_details"]); ?></td>
                            <td>
                                <?php if (!empty($row["product_photo"])): ?>
                                    <img src="../Assets/Files/Photo/<?php echo htmlspecialchars($row["product_photo"]); ?>" 
                                         width="120" height="60" class="img-thumbnail" alt="Product Photo" />
                                <?php else: ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="Product.php?aid=<?php echo $row["product_id"]; ?>" 
                                   class="btn btn-danger btn-sm me-1"
                                   onclick="return confirm('Are you sure you want to delete this product?');">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </a>
                                <a href="ProductTower.php?pid=<?php echo $row['product_id']; ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-th me-1"></i> Product Tower
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-muted"><i class="fas fa-info-circle me-1"></i>No Products Found</td>
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