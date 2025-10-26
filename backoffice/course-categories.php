<?php
// ============================================
// File: course-categories.php
// Realigned DataTable + Inline Add Form Version
// ============================================

$page = "courses";
$fun  = "categories";
include_once('head_nav.php');
include_once('config.php');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// ===== FETCH DATA =====
$sql = "
  SELECT 
    d.id, d.name, d.direction_type, d.academic_level, d.featured, d.active,
    p.name AS parent_name
  FROM directions d
  LEFT JOIN directions p ON p.id = d.parent_direction_ID
  ORDER BY d.direction_type DESC, d.name ASC
";
$res = $coni->query($sql);

// ===== RECURSIVE DROPDOWN BUILDER =====
function buildHierarchy($parent_id = null, $prefix = '') {
    global $coni;
    $stmt = $coni->prepare("SELECT id, name FROM directions WHERE parent_direction_ID " . 
                           (is_null($parent_id) ? "IS NULL" : "= ?") . 
                           " ORDER BY name ASC");
    if (!is_null($parent_id)) $stmt->bind_param('i', $parent_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $prefix . htmlspecialchars($row['name']) . '</option>';
        buildHierarchy($row['id'], $prefix . '→ ');
    }
    $stmt->close();
}
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>

  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="bx bx-category me-2"></i> Course Categories</h4>
      </div>

      <!-- INLINE ADD CATEGORY FORM -->
      <div class="card border-primary mb-4">
        <div class="card-header bg-primary text-white">
          <i class="bx bx-plus-circle me-2"></i> Add / Link New Direction
        </div>
        <div class="card-body">
		<p><br></p>
          <div id="form-msg"></div>
          <form id="categoryForm">
            <div class="row mb-3">
              <div class="col-md-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>

              <div class="col-md-3">
                <label class="form-label">Type</label>
                <select name="direction_type" class="form-select" required>
                  <option value="">Select Type</option>
                  <option value="Category">Category</option>
                  <option value="Subcategory">Subcategory</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">Academic Level</label>
                <input type="text" name="academic_level" class="form-control" placeholder="e.g. K12, UG, PG">
              </div>

              <div class="col-md-3">
                <label class="form-label">Parent Direction (optional)</label>
                <select name="parent_direction_ID" id="parentSelect" class="form-select">
                  <option value="">None (Top Level)</option>
                  <?php buildHierarchy(); ?>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-3">
                <label class="form-label">Featured</label>
                <select name="featured" class="form-select">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Active</label>
                <select name="active" class="form-select">
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2"></textarea>
              </div>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-success px-4">
                <i class="bx bx-check-circle me-1"></i> Save
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- TABLE -->
      <div class="card">
        <div class="card-header bg-light">
          <h5 class="mb-0"><i class="bx bx-table me-2"></i> Directions List</h5>
        </div>

        <div class="card-body">
          <table id="categoriesTable" class="table table-bordered table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Academic Level</th>
                <th>Parent</th>
                <th>Featured</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= htmlspecialchars($row['name']) ?></td>
                  <td><span class="badge bg-info"><?= $row['direction_type'] ?></span></td>
                  <td><?= htmlspecialchars($row['academic_level']) ?></td>
                  <td><?= $row['parent_name'] ? htmlspecialchars($row['parent_name']) : "—" ?></td>
                  <td><?= $row['featured'] ? "⭐" : "—" ?></td>
                  <td><?= $row['active'] ? "<span class='badge bg-success'>Active</span>" : "<span class='badge bg-danger'>Inactive</span>" ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
 

<?php include_once('footer.php'); ?>

<!-- DATATABLES JS & CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
  // Initialize DataTable
  $('#categoriesTable').DataTable({
    pageLength: 10,
    order: [[0, 'asc']],
    language: { search: "🔍 Search:" }
  });

  // Auto-change type based on parent
  $("#parentSelect").on("change", function() {
    const type = $(this).val() ? "Subcategory" : "Category";
    $("select[name='direction_type']").val(type);
  });

  // AJAX form submission
  $("#categoryForm").on("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("ajax_add_category.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      const box = $("#form-msg");
      if (data.success) {
        box.html('<div class="alert alert-success">✅ ' + data.message + '</div>');
        setTimeout(() => location.reload(), 800);
      } else {
        box.html('<div class="alert alert-danger">❌ ' + data.message + '</div>');
      }
    })
    .catch(err => {
      $("#form-msg").html('<div class="alert alert-danger">⚠️ Error: ' + err + '</div>');
    });
  });
});
</script>
