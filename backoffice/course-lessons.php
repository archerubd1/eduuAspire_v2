<?php
$page = "courses";
$fun  = "lessons";
include_once('head_nav.php');
include_once('config.php');

// --- Fetch all active courses with their lesson and topic counts ---
$sql = "
SELECT 
  l.id AS course_id,
  l.name AS course_name,
  COUNT(DISTINCT m.id) AS lesson_count,
  COUNT(DISTINCT c.id) AS topic_count,
  (SELECT COUNT(*) FROM users_to_lessons utl WHERE utl.lessons_id = l.id AND utl.user_type='student') AS learners_count,
  l.course_mode,
  l.active,
  d.name AS direction_name,
  sd.name AS sub_direction_name
FROM lessons l
LEFT JOIN directions d ON l.direction_id = d.id
LEFT JOIN directions sd ON l.sub_direction_id = sd.id
LEFT JOIN modules m ON m.course_id = l.id
LEFT JOIN content c ON c.module_id = m.id
WHERE l.active = 1
GROUP BY l.id
ORDER BY l.id DESC
";

$courses = mysqli_query($coni, $sql);
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="bx bx-layer me-2"></i> Course → Lessons → Topics Overview</h4>
        <a href="add_course.php" class="btn btn-primary">
          <i class="bx bx-plus-circle"></i> Add New Course
        </a>
      </div>

      <!-- Main Table -->
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bx bx-book-content me-2"></i>Courses, Lessons & Topics Summary</h5>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="courseLessonsTable" class="table table-striped table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Course Title</th>
                  <th>Direction</th>
                  <th>Sub-Direction</th>
                  <th>Mode</th>
                  <th># Lessons</th>
                  <th># Topics</th>
                  <th># Learners</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php
              if ($courses && mysqli_num_rows($courses) > 0) {
                $i = 1;
                while ($row = mysqli_fetch_assoc($courses)) {
                  $status = $row['active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Suspended</span>';
                  $learners = (int)$row['learners_count'];

                  echo "<tr>
                    <td>{$i}</td>
                    <td><strong>" . htmlspecialchars($row['course_name']) . "</strong></td>
                    <td>" . htmlspecialchars($row['direction_name'] ?: '—') . "</td>
                    <td>" . htmlspecialchars($row['sub_direction_name'] ?: '—') . "</td>
                    <td>" . htmlspecialchars($row['course_mode'] ?: '—') . "</td>
                    <td class='text-center'>{$row['lesson_count']}</td>
                    <td class='text-center'>{$row['topic_count']}</td>
                    <td class='text-center'>{$learners}</td>
                    <td class='text-center'>$status</td>
                    <td class='text-center text-nowrap'>
                      <div class='btn-group' role='group'>
                        <a href='view_curriculum.php?course={$row['course_id']}' 
                           class='btn btn-sm btn-outline-info' title='View Curriculum (Lessons & Topics)'>
                           <i class='bx bx-show'></i>
                        </a>
                        <a href='edit_curriculum.php?course={$row['course_id']}' 
                           class='btn btn-sm btn-outline-primary' title='Edit Lessons & Topics'>
                           <i class='bx bx-edit'></i>
                        </a>
                        <button class='btn btn-sm btn-outline-warning' 
                           onclick='suspendCourse({$row['course_id']}, {$learners})' 
                           title='Suspend Course'>
                           <i class='bx bx-pause-circle'></i>
                        </button>
                      </div>
                    </td>
                  </tr>";
                  $i++;
                }
              } else {
                echo "<tr><td colspan='10' class='text-center text-muted py-4'>No active courses found.</td></tr>";
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
.btn-outline-primary:hover i { color: #0d6efd; }
.btn-outline-warning:hover i { color: #ffc107; }
.table .btn-group { display: inline-flex; gap: 2px; }
</style>

<script>
$(document).ready(function() {
  $('#courseLessonsTable').DataTable({
    pageLength: 10,
    order: [[0, 'asc']],
    lengthMenu: [5, 10, 25, 50],
    language: {
      search: "🔍 Search Courses:",
      lengthMenu: "Show _MENU_ per page",
      info: "Showing _START_ to _END_ of _TOTAL_ courses"
    }
  });
});

// Suspend course logic
function suspendCourse(courseId, learners) {
  if (learners > 0) {
    alert("❌ Cannot suspend this course — learners are enrolled.");
    return;
  }
  if (!confirm("Are you sure you want to suspend this course?")) return;

  $.post("ajax_suspend_
