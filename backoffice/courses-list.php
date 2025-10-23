<?php
$page = "courses";
$fun  = "all_courses";
include_once('head_nav.php');
include_once('config.php');

// Count total marketplace & lessons
$q1 = mysqli_query($coni, "SELECT COUNT(*) AS cnt FROM course_marketplace WHERE is_active=1");
$r1 = mysqli_fetch_assoc($q1);
$totalCourses = (int)$r1['cnt'];

$q2 = mysqli_query($coni, "SELECT COUNT(*) AS cnt FROM lessons WHERE active=1");
$r2 = mysqli_fetch_assoc($q2);
$totalLessons = (int)$r2['cnt'];

// Fetch all courses with joined details
$sql = "
SELECT 
  l.id AS course_id,
  l.name,
  l.duration,
  l.price,
  l.course_mode,
  l.created,
  cm.discount_price,
  cm.badge,
  cm.image,
  i.user_login,
  i.specialty,
  d.name AS category_name,
  (SELECT COUNT(*) FROM users_to_lessons utl WHERE utl.lessons_ID=l.id AND utl.user_type='student') AS students,
  (SELECT COUNT(*) FROM course_metadata m WHERE m.course_id = l.id) AS has_metadata
FROM lessons l
LEFT JOIN course_marketplace cm ON cm.lesson_id = l.id
LEFT JOIN instructors i ON i.user_login = l.creator_LOGIN
LEFT JOIN directions d ON d.id = l.directions_ID
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
              <h5>Total Courses</h5>
              <h2><?php echo $totalCourses; ?></h2>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5>Total Lessons</h5>
              <h2><?php echo $totalLessons; ?></h2>
            </div>
          </div>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-center">
          <a href="add_course.php" class="btn btn-primary btn-lg">
            <i class="bx bx-plus-circle me-1"></i> Add New Course
          </a>
        </div>
      </div>

      <!-- Courses Table -->
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bx bx-book-open me-2"></i> All Marketplace Courses</h5>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="coursesTable" class="table table-striped table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>#</th>
				   <th>Actions</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Mode</th>
                  <th>Duration (wks)</th>
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
                  $discount = ($c['discount_price'] > 0) ? number_format($c['discount_price'], 2) : '-';
                  $instructor = $c['user_login'] ? htmlspecialchars($c['user_login']) : '<em>N/A</em>';
                  $meta_icon = ($c['has_metadata'] > 0)
                    ? '<span class="text-success fw-bold">✅</span>'
                    : '<span class="text-danger fw-bold">❌</span>';

                  $createdDisplay = '-';
                  if (!empty($c['created']) && is_numeric($c['created'])) {
                    $createdDisplay = date("d M Y", $c['created']);
                  }

                  echo '<tr>
                    <td>' . $i++ . '</td>
					 <td>
                      <a href="course-details.php?course=' . $c['course_id'] . '" target="_blank" class="btn btn-sm btn-outline-info" title="View"><i class="bx bx-show"></i></a>
                      <a href="add_course.php?edit=' . $c['course_id'] . '" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="bx bx-edit"></i></a>
                      <a href="edit_metadata.php?course=' . $c['course_id'] . '" class="btn btn-sm btn-outline-primary" title="Edit Metadata"><i class="bx bx-data"></i></a>
                      <button class="btn btn-sm btn-outline-danger" onclick="deleteCourse(' . $c['course_id'] . ')" title="Delete"><i class="bx bx-trash"></i></button>
                    </td>
                    <td><strong>' . htmlspecialchars($c['name']) . '</strong></td>
                    <td>' . htmlspecialchars($c['category_name'] ?: '—') . '</td>
                    <td>' . htmlspecialchars($c['course_mode']) . '</td>
                    <td>' . htmlspecialchars($c['duration']) . '</td>
                    <td>₹' . $price . '</td>
                    <td>' . ($discount != '-' ? '₹' . $discount : '-') . '</td>
                    <td><span class="badge bg-info">' . htmlspecialchars($c['badge']) . '</span></td>
                    <td>' . $instructor . '</td>
                    <td class="text-center">' . (int)$c['students'] . '</td>
                    <td class="text-center">' . $meta_icon . '</td>
                    <td>' . $createdDisplay . '</td>
                   
                  </tr>';
                }
              } else {
                echo '<tr><td colspan="13" class="text-center">No courses found.</td></tr>';
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

<script>
$(document).ready(function() {
  $('#coursesTable').DataTable({
    "pageLength": 10,
    "order": [[11, 'desc']],
    "lengthMenu": [5, 10, 25, 50, 100],
    "language": {
      "search": "🔍 Search:",
      "lengthMenu": "Show _MENU_ per page",
      "info": "Showing _START_ to _END_ of _TOTAL_ courses"
    }
  });
});

function deleteCourse(id) {
  if (!confirm("Are you sure you want to delete this course?")) return;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax_delete_course.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      try {
        var res = JSON.parse(xhr.responseText);
        alert(res.message);
        if (res.success) location.reload();
      } catch (e) {
        alert("Unexpected error deleting course.");
      }
    }
  };
  xhr.send("id=" + encodeURIComponent(id));
}
</script>
