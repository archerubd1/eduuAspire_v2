<?php
$page = "instructors";
$fun  = "list";

include_once('head_nav.php');
include_once('config.php'); // $coni = new mysqli(...);

// --- Handle Search, Sort & Pagination ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort   = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$order  = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
$pageNo = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit  = 10;
$offset = ($pageNo - 1) * $limit;

// --- Build Base Query ---
$where = "";
if ($search != '') {
    $search_like = '%' . $search . '%';
    $where = "WHERE i.first_name LIKE ? OR i.last_name LIKE ? OR i.user_login LIKE ? OR i.email LIKE ? OR i.specialty LIKE ?";
}

// --- Count total for pagination ---
if ($where != '') {
    $count_stmt = $coni->prepare("
        SELECT COUNT(*) FROM instructors i
        LEFT JOIN instructor_profiles p ON i.id = p.instructor_id
        $where
    ");
    $count_stmt->bind_param("sssss", $search_like, $search_like, $search_like, $search_like, $search_like);
} else {
    $count_stmt = $coni->prepare("SELECT COUNT(*) FROM instructors i");
}
$count_stmt->execute();
$count_stmt->bind_result($totalRows);
$count_stmt->fetch();
$count_stmt->close();
$totalPages = ceil($totalRows / $limit);

// --- Fetch instructors ---
if ($where != '') {
    $stmt = $coni->prepare("
        SELECT i.*, p.qualification, p.experience_years, p.languages_known
        FROM instructors i
        LEFT JOIN instructor_profiles p ON i.id = p.instructor_id
        $where
        ORDER BY $sort $order
        LIMIT ?, ?
    ");
    $stmt->bind_param("sssssii", $search_like, $search_like, $search_like, $search_like, $search_like, $offset, $limit);
} else {
    $stmt = $coni->prepare("
        SELECT i.*, p.qualification, p.experience_years, p.languages_known
        FROM instructors i
        LEFT JOIN instructor_profiles p ON i.id = p.instructor_id
        ORDER BY $sort $order
        LIMIT ?, ?
    ");
    $stmt->bind_param("ii", $offset, $limit);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5><i class="bx bx-group me-2"></i> Instructors List</h5>
          <form class="d-flex" method="get" action="">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control form-control-sm me-2" placeholder="Search instructor...">
            <button class="btn btn-sm btn-primary" type="submit"><i class="bx bx-search"></i></button>
          </form>
        </div>

        <div class="card-body table-responsive">
          <table class="table table-striped align-middle">
            <thead>
              <tr>
			   <th>Actions</th>
                <th><a href="?sort=first_name&order=<?php echo $order == 'ASC' ? 'desc' : 'asc'; ?>">Name</a></th>
                
                <th>Mobile</th>
                <th>Specialty</th>
                <th>Qualification</th>
                <th>Experience</th>
                <th>Rating</th>
                <th>Students</th>
                <th>Verified</th>
				<th>Status</th>
				<th>Last Updated</th>
               
               
              </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
				 <td>
  <a href="view_instructor.php?id=<?php echo $row['id']; ?>" title="View Profile" class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>&nbsp;
  <a href="edit_instructor.php?id=<?php echo $row['id']; ?>" title="Edit Details" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>&nbsp;
  
  <?php if ($row['status'] == 'active'): ?>
    <button type="button" class="btn btn-sm btn-danger" onclick="toggleInstructorStatus(<?php echo $row['id']; ?>)">
      <i class="bx bx-block"></i> Suspend
    </button>
  <?php else: ?>
    <button type="button" class="btn btn-sm btn-success" onclick="toggleInstructorStatus(<?php echo $row['id']; ?>)">
      <i class="bx bx-refresh"></i> Reactivate
    </button>
  <?php endif; ?>
</td>
                  <td>
                    <img src="<?php echo htmlspecialchars($row['avatar']); ?>" width="35" height="35" class="rounded-circle me-2">
                    <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>
                  </td>
                  
                  <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                  <td><?php echo htmlspecialchars($row['specialty']); ?></td>
                  <td><?php echo htmlspecialchars($row['qualification']); ?></td>
                  <td><?php echo (int)$row['experience_years']; ?> yrs</td>
                  <td><?php echo number_format($row['rating'], 1); ?></td>
                  <td><?php echo (int)$row['total_students']; ?></td>
                  <td><?php echo $row['verified'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>'; ?></td>
				  <td>
  <?php
    if ($row['status'] == 'active') echo '<span class="badge bg-success">Active</span>';
    elseif ($row['status'] == 'suspended') echo '<span class="badge bg-danger">Suspended</span>';
    else echo '<span class="badge bg-secondary">Inactive</span>';
  ?>
</td>

   <td><?php echo htmlspecialchars($row['last_updated']); ?></td>
              
                 
				  
				 

                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="11" class="text-center text-muted">No instructors found.</td></tr>
            <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer d-flex justify-content-between align-items-center">
          <div>Page <?php echo $pageNo; ?> of <?php echo $totalPages; ?></div>
          <nav>
            <ul class="pagination pagination-sm mb-0">
              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $pageNo) echo 'active'; ?>">
                  <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
        </div>

      </div>
    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>

<script>
// Export table to CSV
function exportTableToCSV(filename) {
  var csv = [];
  var rows = document.querySelectorAll("table tr");
  for (var i = 0; i < rows.length; i++) {
    var cols = rows[i].querySelectorAll("td, th");
    var row = [];
    for (var j = 0; j < cols.length; j++)
      row.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
    csv.push(row.join(","));
  }
  var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
  var link = document.createElement("a");
  link.download = filename;
  link.href = window.URL.createObjectURL(csvFile);
  link.style.display = "none";
  document.body.appendChild(link);
  link.click();
}

// Delete instructor (AJAX)
function deleteInstructor(id) {
  if (!confirm("Are you sure you want to delete this instructor?")) return;
  fetch("ajax_delete_instructor.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + id
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.success) location.reload();
  })
  .catch(err => alert("Error: " + err));
}

function toggleInstructorStatus(id) {
  const confirmMsg = "Are you sure you want to change this instructor's status?";
  if (!confirm(confirmMsg)) return;

  fetch("ajax_toggle_instructor_status.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + id
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.success) location.reload();
  })
  .catch(err => alert("Error: " + err));
}

</script>
