<?php 
include('../Assets/Connection/Connection.php');
include('Head.php');

$categoryName = "";
$categoryId = "";

// Insert or Update
if (isset($_POST['btn_category'])) {
    $category = trim($_POST['txt_category']);
    $hiddenId = $_POST["txt_hidden"];

    if ($hiddenId != "") {
        $updQry = "UPDATE tbl_category SET category_name='" . $category . "' WHERE category_id='" . $hiddenId . "'";
        if ($con->query($updQry)) {
            echo "<script>alert('Category Updated Successfully');window.location='Category.php';</script>";
        }
    } else {
        $chkQry = "SELECT * FROM tbl_category WHERE category_name='" . $category . "'";
        $chkRes = $con->query($chkQry);
        if ($chkRes->num_rows > 0) {
            echo "<script>alert('Category already exists!');window.location='Category.php';</script>";
        } else {
            $ins = "INSERT INTO tbl_category(category_name) VALUES ('" . $category . "')";
            if ($con->query($ins)) {
                echo "<script>alert('Category Inserted Successfully');window.location='Category.php';</script>";
            }
        }
    }
}

// Delete
if (isset($_GET['cid'])) {
    $delQry = "DELETE FROM tbl_category WHERE category_id='" . $_GET['cid'] . "'";
    if ($con->query($delQry)) {
        echo "<script>alert('Category Deleted Successfully');window.location='Category.php';</script>";
    }
}

// Edit
if (isset($_GET['eid'])) {
    $selQry = "SELECT * FROM tbl_category WHERE category_id='" . $_GET['eid'] . "'";
    $row = $con->query($selQry);
    if ($row->num_rows > 0) {
        $data = $row->fetch_assoc();
        $categoryName = $data['category_name'];
        $categoryId = $data['category_id'];
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <!-- Bootstrap CSS -->
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="container">

        <!-- 📦 Category Form Card -->
        <div class="form-container card p-4 shadow-sm mb-4">
            <h4 class="mb-3"><i class="fas fa-tags me-2 text-primary"></i>Manage Category</h4>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="txt_category" class="form-label"><i class="fas fa-tag me-1"></i>Category Name</label>
                    <input type="hidden" name="txt_hidden" value="<?php echo $categoryId; ?>" />
                    <input 
                        type="text" 
                        name="txt_category" 
                        id="txt_category" 
                        class="form-control" 
                        value="<?php echo htmlspecialchars($categoryName); ?>" 
                        required 
                        placeholder="Enter Category Name"
                        pattern="^[A-Z][a-zA-Z\s]*$"
                        title="Only alphabets and spaces allowed. First letter must be capital."
                    />
                </div>
                <div class="text-center">
                    <button type="submit" name="btn_category" class="btn btn-success me-2 px-4">
                        <i class="fas fa-check me-1"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-secondary px-4">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- 📋 Category List Table -->
        <div class="table-container card p-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-list me-2 text-info"></i>Category List</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;"><i class="fas fa-hashtag me-1"></i>SI NO</th>
                            <th><i class="fas fa-tag me-1"></i>Category Name</th>
                            <th style="width: 140px;"><i class="fas fa-cogs me-1"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $selQry = "SELECT * FROM tbl_category ORDER BY category_name ASC";
                        $result = $con->query($selQry);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td>
                                <a href="Category.php?cid=<?php echo $row['category_id']; ?>" 
                                   class="btn btn-danger btn-sm me-1"
                                   onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </a>
                                <a href="Category.php?eid=<?php echo $row['category_id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="3" class="text-muted"><i class="fas fa-info-circle me-1"></i>No Categories Found</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
</body>
</html>

<?php
include('Foot.php');
?>