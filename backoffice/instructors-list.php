<?php
$page = "instructors";
$fun  = "all_ins";

include_once('head_nav.php');
include_once('config.php');

// --- Count total instructors ---
$totalInstructors = 0;
$countRes = mysqli_query($coni, "SELECT COUNT(*) AS cnt FROM instructors");
if ($countRes) {
    $rowCnt = mysqli_fetch_assoc($countRes);
    $totalInstructors = (int)$rowCnt['cnt'];
}
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>

  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <!-- Success Message -->
      <?php if (isset($_GET['msg']) && $_GET['msg'] === 'success'): ?>
        <div class="alert alert-success">
          ✅ <?php echo isset($_GET['text']) ? htmlspecialchars($_GET['text']) : 'Instructor action completed successfully.'; ?>
        </div>
      <?php endif; ?>

      <!-- Stats -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body text-center">
              <h5>Total Instructors</h5>
              <h2><?php echo $totalInstructors; ?></h2>
            </div>
          </div>
        </div>
      </div>

      <!-- Instructors Table -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bx bx-chalkboard me-2"></i> All Instructors</h5>
          <a href="add_instructor.php" class="btn btn-primary btn-sm">
            <i class="bx bx-plus-circle"></i> Add Instructor
          </a>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="instructorsTable" class="table table-hover table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Photo</th>
                  <th>Name / Login</th>
                  <th>Specialty</th>
                  <th>Rating</th>
                  <th>Courses</th>
                  <th>Learners</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php
              // --- Fetch instructors list ---
              $sql = "
                SELECT 
                  i.id, i.user_login, i.specialty, i.avatar, i.rating, i.total_reviews,
                  u.name, u.surname, u.avatar AS user_avatar,
                  (SELECT COUNT(*) FROM lessons l WHERE l.creator_LOGIN = i.user_login) AS total_courses,
                  (SELECT COUNT(*) 
                     FROM users_to_lessons utl 
                     JOIN lessons l2 ON utl.lessons_ID = l2.id 
                     WHERE l2.creator_LOGIN = i.user_login AND utl.user_type='student') AS total_learners
                FROM instructors i
                LEFT JOIN users u ON u.login = i.user_login
                ORDER BY i.id DESC
              ";

              $res = mysqli_query($coni, $sql);
              if ($res && mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {

                  // --- Avatar Handling (PHP 5.4 safe) ---
                  $photo = "assets/img/person/default-avatar.webp";

                  if (!empty($row['avatar'])) {
                      if (strpos($row['avatar'], 'uploads/') === 0) {
                          $photo = "../" . $row['avatar']; // Fix relative path for backoffice
                      } else {
                          $photo = $row['avatar'];
                      }
                  } elseif (!empty($row['user_avatar'])) {
                      if (strpos($row['user_avatar'], 'uploads/') === 0) {
                          $photo = "../" . $row['user_avatar'];
                      } else {
                          $photo = $row['user_avatar'];
                      }
                  }

                  // --- Name Fallback ---
                  $fullname = trim($row['name'] . " " . $row['surname']);
                  if ($fullname == '') $fullname = $row['user_login'];

                  // --- Specialty ---
                  $specialty = !empty($row['specialty']) ? htmlspecialchars($row['specialty']) : '—';

                  // --- Rating ---
                  $rating = isset($row['rating']) ? number_format($row['rating'], 1) : '4.5';
                  $reviews = isset($row['total_reviews']) ? (int)$row['total_reviews'] : 0;
                  $courses = isset($row['total_courses']) ? (int)$row['total_courses'] : 0;
                  $learners = isset($row['total_learners']) ? (int)$row['total_learners'] : 0;

                  echo '
                    <tr>
                      <td>' . $row['id'] . '</td>
                      <td><img src="' . htmlspecialchars($photo) . '" alt="Instructor" width="60" height="60" class="rounded-circle border"></td>
                      <td><strong>' . htmlspecialchars($fullname) . '</strong><br><small class="text-muted">@' . htmlspecialchars($row['user_login']) . '</small></td>
                      <td>' . $specialty . '</td>
                      <td><i class="bx bx-star text-warning"></i> ' . $rating . ' (' . $reviews . ' reviews)</td>
                      <td>' . $courses . '</td>
                      <td>' . $learners . '</td>
                      <td>
                        <a href="view_instructor.php?id=' . $row['id'] . '" class="btn btn-sm btn-info" title="View"><i class="bx bx-show"></i></a>
                        <a href="edit_instructor.php?id=' . $row['id'] . '" class="btn btn-sm btn-warning" title="Edit"><i class="bx bx-edit"></i></a>
                        <a href="delete_instructor.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Are you sure you want to delete this instructor?\')"><i class="bx bx-trash"></i></a>
                      </td>
                    </tr>
                  ';
                }
              } else {
                echo '<tr><td colspan="8" class="text-center text-muted">No instructors found.</td></tr>';
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function(){
  $('#instructorsTable').DataTable({
    "pageLength": 10,
    "lengthMenu": [5, 10, 20, 50],
    "order": [[0, "desc"]],
    "columnDefs": [{ "orderable": false, "targets": [1,7] }]
  });
});
</script>
