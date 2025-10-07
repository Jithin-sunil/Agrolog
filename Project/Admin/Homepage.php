<?php
include('Head.php');
include('../Assets/Connection/Connection.php');

// Fetch counts
$studentCount     = $con->query("SELECT COUNT(*) as c FROM tbl_student")->fetch_assoc()['c'];
$towerCount       = $con->query("SELECT COUNT(*) as c FROM tbl_tower")->fetch_assoc()['c'];
$requestCount     = $con->query("SELECT COUNT(*) as c FROM tbl_volunteerrequest")->fetch_assoc()['c'];
?>

<div class="row">
  <!-- Students -->
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm p-3">
      <div class="d-flex align-items-center">
        <div class="bg-primary text-white rounded-circle p-3 me-3">
          <i class="fas fa-users fs-4"></i>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Total Students</h6>
          <h4 class="fw-bold mb-0"><?php echo $studentCount; ?></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Towers -->
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm p-3">
      <div class="d-flex align-items-center">
        <div class="bg-success text-white rounded-circle p-3 me-3">
          <i class="fas fa-building fs-4"></i>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Total Towers</h6>
          <h4 class="fw-bold mb-0"><?php echo $towerCount; ?></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Requests -->
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm p-3">
      <div class="d-flex align-items-center">
        <div class="bg-warning text-white rounded-circle p-3 me-3">
          <i class="fas fa-tasks fs-4"></i>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Total Requests</h6>
          <h4 class="fw-bold mb-0"><?php echo $requestCount; ?></h4>
        </div>
      </div>
    </div>
  </div>

  
</div>

<!-- Recent Products -->
<div class="col-lg-12">
  <div class="card w-100">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Recent Products</h5>
      <div class="row">
        <?php
        $products = $con->query("SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT 4");
        while($row = $products->fetch_assoc()) {
        ?>
        <div class="col-sm-6 col-xl-3">
          <div class="card overflow-hidden rounded-2">
            <img src="../Assets/Files/Photo/<?php echo $row['product_photo']; ?>" class="card-img-top" alt="Product Photo" style="height: 200px; object-fit: cover;">
            <div class="card-body pt-3 p-4">
              <h6 class="fw-semibold fs-4"><?php echo htmlspecialchars($row['product_name']); ?></h6>
              <p class="mb-1">Details: <?php echo htmlspecialchars(substr($row['product_details'], 0, 50)) . (strlen($row['product_details']) > 50 ? '...' : ''); ?></p>
              <p class="mb-1">Status: <?php echo ($row['product_status'] == 0) ? 'Active' : 'Inactive'; ?></p>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Recent Requests -->
  <div class="col-lg-6">
    <div class="card w-100">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Recent Requests</h5>
        <div class="table-responsive">
          <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
              <tr>
                <th>ID</th>
                <th>Details</th>
                <th>Product</th>
                <th>Tower</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $qry = $con->query("SELECT vr.*, p.product_name, t.tower_name 
                                  FROM tbl_volunteerrequest vr
                                  INNER JOIN tbl_producttower pt ON vr.producttower_id=pt.producttower_id 
                                  INNER JOIN tbl_product p ON pt.product_id=p.product_id
                                  INNER JOIN tbl_tower t ON pt.tower_id=t.tower_id
                                  ORDER BY vr.volunteerrequest_id DESC LIMIT 5");
              while($r = $qry->fetch_assoc()) {
                $status = ($r['volunteerrequest_status']==0) ? 'Pending' : (($r['volunteerrequest_status']==1) ? 'Accepted' : 'Rejected');
              ?>
              <tr>
                <td><?php echo $r['volunteerrequest_id']; ?></td>
                <td><?php echo htmlspecialchars(substr($r['volunteerrequest_details'], 0, 30)) . '...'; ?></td>
                <td><?php echo htmlspecialchars($r['product_name']); ?></td>
                <td><?php echo htmlspecialchars($r['tower_name']); ?></td>
                <td>
                  <span class="badge bg-<?php echo ($status=='Accepted')?'success':(($status=='Rejected')?'danger':'warning'); ?>">
                    <?php echo $status; ?>
                  </span>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Latest Complaints -->
  <div class="col-lg-6">
    <div class="card w-100">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Latest Complaints</h5>
        <div class="table-responsive">
          <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
              <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Title</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $complaints = $con->query("SELECT c.*, s.student_name 
                                         FROM tbl_complaint c 
                                         INNER JOIN tbl_student s ON c.student_id=s.student_id 
                                         ORDER BY c.complaint_id DESC LIMIT 5");
              while($c = $complaints->fetch_assoc()) {
                $cstatus = (!empty($c['complaint_reply'])) ? "Replied" : "Pending";
              ?>
              <tr>
                <td><?php echo $c['complaint_id']; ?></td>
                <td><?php echo htmlspecialchars($c['student_name']); ?></td>
                <td><?php echo htmlspecialchars($c['complaint_title']); ?></td>
                <td><?php echo $cstatus; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include('Foot.php');
?>