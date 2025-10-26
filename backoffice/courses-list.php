<?php
$page = "courses";
$fun  = "all_courses";
include_once('head_nav.php');
include_once('config.php');

// --- Stats ---
$totalCourses = 0;
$totalLessons = 0;

$q1 = mysqli_query($coni, "SELECT COUNT(*) AS cnt FROM course_marketplace WHERE is_active = 1");
if ($q1) $totalCourses = (int)mysqli_fetch_assoc($q1)['cnt'];

$q2 = mysqli_query($coni, "SELECT COUNT(*) AS cnt FROM lessons WHERE active = 1");
if ($q2) $totalLessons = (int)mysqli_fetch_assoc($q2)['cnt'];

// --- Unified course listing query ---
$sql = "
SELECT 
  l.id AS course_id,
  l.name,
  l.info,
  l.duration,
  l.price,
  l.course_mode,
  l.created,
  l.board,
  l.assessment_type,
  d.name AS direction_name,
  sd.name AS sub_direction_name,
  cm.discount_price,
  cm.badge,
  cm.image,
  i.user_login AS instructor_login,
  i.first_name,
  i.last_name,
  i.specialty,
  (SELECT COUNT(*) FROM users_to_lessons utl WHERE utl.lessons_id = l.id AND utl.user_type='student') AS students,
  (SELECT COUNT(*) FROM course_metadata m WHERE m.course_id = l.id) AS has_metadata
FROM lessons l
LEFT JOIN directions d ON l.direction_id = d.id
LEFT JOIN directions sd ON l.sub_direction_id = sd.id
LEFT JOIN course_marketplace cm ON cm.lesson_id = l.id
LEFT JOIN users_to_lessons ul ON ul.lessons_id = l.id
LEFT JOIN instructors i ON i.user_login = ul.users_login
WHERE l.active = 1
GROUP BY l.id
ORDER BY l.created DESC
";

$courses = mysqli_query($coni, $sql);
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <!-- Stats Summary -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h6 class="text-muted mb-1">Total Marketplace Courses</h6>
              <h2 class="fw-bold text-primary mb-0"><?php echo $totalCourses; ?></h2>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h6 class="text-muted mb-1">Total Lessons</h6>
              <h2 class="fw-bold text-success mb-0"><?php echo $totalLessons; ?></h2>
            </div>
          </div>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-center">
          <a href="add_course.php" class="btn btn-primary btn-lg shadow-sm">
            <i class="bx bx-plus-circle me-1"></i> Add New Course
          </a>
        </div>
      </div>

      <!-- Courses Table -->
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bx bx-book-open me-2"></i>All Active Courses</h5>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="coursesTable" class="table table-striped table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th class="text-center">Actions</th>
                  <th>Title</th>
                  <th>Direction</th>
                  <th>Sub-Direction</th>
                  <th>Board</th>
                  <th>Mode</th>
                  <th>Assessment</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th>Badge</th>
                  <th>Instructor</th>
                  <th>Students</th>
                  <th>Metadata</th>
                  <th>Created</th>
                </tr>
              </thead>
              <tbody>
              <?php
              if ($courses && mysqli_num_rows($courses) > 0) {
                $i = 1;
                while ($c = mysqli_fetch_assoc($courses)) {
                  $price = number_format($c['price'], 2);
                  $discount = ($c['discount_price'] > 0) ? '₹' . number_format($c['discount_price'], 2) : '—';
                  $instructor = ($c['first_name'] || $c['last_name'])
                    ? htmlspecialchars(trim($c['first_name'] . ' ' . $c['last_name']))
                    : ($c['instructor_login'] ?: '<em>N/A</em>');
                  $meta_icon = ($c['has_metadata'] > 0)
                    ? '<span class="text-success fw-bold">✅</span>'
                    : '<span class="text-danger fw-bold">❌</span>';

                  $createdDisplay = '-';
                  if (!empty($c['created'])) {
                    $createdDisplay = is_numeric($c['created'])
                      ? date("d M Y", (int)$c['created'])
                      : htmlspecialchars($c['created']);
                  }
              ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td class="text-nowrap text-center">
                    <div class="btn-group" role="group" aria-label="Course Actions">
                      <a href="../course-details.php?id=<?= $c['course_id'] ?>" target="_blank"
                         class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="View Course">
                         <i class="bx bx-show"></i>
                      </a>
                      <a href="edit_course.php?edit=<?= $c['course_id'] ?>"
                         class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Course">
                         <i class="bx bx-edit"></i>
                      </a>
                      <a href="edit_metadata.php?course=<?= $c['course_id'] ?>"
                         class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit Metadata">
                         <i class="bx bx-data"></i>
                      </a>
                     <button class="btn btn-sm btn-outline-warning" onclick="suspendCourse(<?= $c['course_id'] ?>)" data-bs-toggle="tooltip"  title="Suspend / Retire Course">
  <i class="bx bx-pause-circle"></i>
</button>

                    </div>
                  </td>
                  <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                  <td><?= htmlspecialchars($c['direction_name'] ?: '—') ?></td>
                  <td><?= htmlspecialchars($c['sub_direction_name'] ?: '—') ?></td>
                  <td><?= htmlspecialchars($c['board'] ?: '—') ?></td>
                  <td><?= htmlspecialchars($c['course_mode'] ?: '—') ?></td>
                  <td><?= htmlspecialchars($c['assessment_type'] ?: '—') ?></td>
                  <td>₹<?= $price ?></td>
                  <td><?= $discount ?></td>
                  <td><span class="badge bg-info text-dark"><?= htmlspecialchars($c['badge'] ?: '—') ?></span></td>
                  <td><?= $instructor ?></td>
                  <td class="text-center"><?= (int)$c['students'] ?></td>
                  <td class="text-center"><?= $meta_icon ?></td>
                  <td><?= $createdDisplay ?></td>
                </tr>
              <?php
                }
              } else {
                echo '<tr><td colspan="15" class="text-center text-muted py-4">No courses found in the system.</td></tr>';
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- CTA Styling -->
<style>
.btn-group .btn {
  border-radius: 6px !important;
  margin: 0 2px;
  transition: all 0.2s ease-in-out;
}
.btn-group .btn i {
  font-size: 1.1rem;
}
.btn-outline-info:hover i { color: #0dcaf0; }
.btn-outline-secondary:hover i { color: #6c757d; }
.btn-outline-primary:hover i { color: #0d6efd; }
.btn-outline-danger:hover i { color: #dc3545; }
.table .btn-group { display: inline-flex; gap: 2px; }
</style>

<script>
$(document).ready(function() {
  $('#coursesTable').DataTable({
    pageLength: 10,
    order: [[14, 'desc']],
    lengthMenu: [5, 10, 25, 50, 100],
    language: {
      search: "🔍 Search:",
      lengthMenu: "Show _MENU_ entries per page",
      info: "Showing _START_ to _END_ of _TOTAL_ courses"
    }
  });

  // Enable Bootstrap tooltips
  $('[data-bs-toggle="tooltip"]').tooltip();
});


function suspendCourse(id) {
  if (!confirm("Are you sure you want to retire/suspend this course?")) return;
  
  $.post("ajax_suspend_course.php", { id: id }, function(res) {
    try {
      const data = JSON.parse(res);
      alert(data.message);
      if (data.success) location.reload();
    } catch (e) {
      alert("Unexpected error while suspending course.");
    }
  });
}



function deleteCourse(id) {
  if (!confirm("Are you sure you want to disable/suspend this course?")) return;
  $.post("ajax_delete_course.php", { id: id }, function(res) {
    try {
      const data = JSON.parse(res);
      alert(data.message);
      if (data.success) location.reload();
    } catch (e) {
      alert("Unexpected error while deleting course.");
    }
  });
}
</script>
