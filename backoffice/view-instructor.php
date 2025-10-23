<?php
$page = "instructors";
$fun  = "all_ins";
include_once('head_nav.php');
include_once('config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$res = $coni->query("
    SELECT i.*, u.name AS fullname, u.login 
    FROM instructors i
    LEFT JOIN users u ON u.login = i.user_login
    WHERE i.id=$id
    LIMIT 1
");
if (!$res || $res->num_rows == 0) {
    die("<div class='container p-5'><div class='alert alert-danger'>Instructor not found.</div></div>");
}
$row = $res->fetch_assoc();
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card mb-4">
        <div class="card-header">
          <h5><i class="bx bx-user me-2"></i> Instructor Profile</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 text-center">
              <img src="../<?= htmlspecialchars($row['avatar'] ?: 'assets/img/person/default-avatar.webp') ?>" class="img-fluid rounded-circle mb-3" width="150">
              <h5><?= htmlspecialchars($row['fullname'] ?: $row['user_login']) ?></h5>
              <small>@<?= htmlspecialchars($row['user_login']) ?></small>
            </div>
            <div class="col-md-9">
              <p><strong>Specialty:</strong> <?= htmlspecialchars($row['specialty'] ?: '—') ?></p>
              <p><strong>Bio:</strong> <?= nl2br(htmlspecialchars($row['bio'] ?: 'No bio available')) ?></p>
              <p><strong>Rating:</strong> <i class="bx bx-star text-warning"></i> <?= $row['rating'] ?> (<?= $row['total_reviews'] ?> reviews)</p>
             <p><strong>Status:</strong> 
<?= (isset($row['active']) ? $row['active'] : 1) 
      ? '<span class="badge bg-success">Active</span>' 
      : '<span class="badge bg-danger">Retired</span>' ?>
</p>

            </div>
          </div>
        </div>
      </div>

      <!-- Instructor Courses -->
      <div class="card">
        <div class="card-header"><h6>Courses by Instructor</h6></div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Course Title</th>
                <th>Category</th>
                <th>Learners</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $courses = $coni->query("
                SELECT l.id, l.name, d.name AS category,
                  (SELECT COUNT(*) FROM users_to_lessons utl WHERE utl.lessons_ID=l.id AND utl.user_type='student') AS learners
                FROM lessons l
                LEFT JOIN directions d ON d.id=l.directions_ID
                WHERE l.creator_LOGIN='" . $coni->real_escape_string($row['user_login']) . "'
              ");
              if ($courses && $courses->num_rows > 0) {
                while ($c = $courses->fetch_assoc()) {
                  echo "<tr>
                          <td>{$c['id']}</td>
                          <td>".htmlspecialchars($c['name'])."</td>
                          <td>".htmlspecialchars($c['category'] ?: '—')."</td>
                          <td>{$c['learners']}</td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='4' class='text-center'>No courses found</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>
