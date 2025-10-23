<?php
$page = "instructors";
$fun  = "view_ins";

include_once('head_nav.php');
include_once('config.php');

// --- Get instructor ID safely ---
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("<div class='alert alert-danger'>Invalid instructor ID.</div>");
}

// --- Fetch instructor info ---
$sql = "
SELECT i.id, i.user_login, i.avatar, i.specialty, i.rating, i.total_reviews,
       u.name, u.surname, u.email, u.avatar AS user_avatar
FROM instructors i
LEFT JOIN users u ON u.login = i.user_login
WHERE i.id = $id
LIMIT 1
";

$res = mysqli_query($coni, $sql);
if (!$res || mysqli_num_rows($res) == 0) {
    die("<div class='alert alert-warning'>Instructor not found.</div>");
}
$ins = mysqli_fetch_assoc($res);

// --- Avatar handling ---
$photo = "assets/img/person/default-avatar.webp";
if (!empty($ins['avatar'])) {
    if (strpos($ins['avatar'], 'uploads/') === 0) {
        $photo = "../" . $ins['avatar'];
    } else {
        $photo = $ins['avatar'];
    }
} elseif (!empty($ins['user_avatar'])) {
    if (strpos($ins['user_avatar'], 'uploads/') === 0) {
        $photo = "../" . $ins['user_avatar'];
    } else {
        $photo = $ins['user_avatar'];
    }
}

// --- Full name fallback ---
$fullname = trim($ins['name'] . " " . $ins['surname']);
if ($fullname == "") $fullname = $ins['user_login'];

// --- Basic info ---
$specialty = !empty($ins['specialty']) ? htmlspecialchars($ins['specialty']) : "—";
$rating = isset($ins['rating']) ? number_format($ins['rating'], 1) : "4.5";
$reviews = isset($ins['total_reviews']) ? (int)$ins['total_reviews'] : 0;

// --- Fetch courses by this instructor ---
$courses_sql = "
SELECT l.id, l.name, l.info, l.duration,
       cm.price, cm.discount_price, cm.badge, cm.image
FROM lessons l
LEFT JOIN course_marketplace cm ON cm.lesson_id = l.id
WHERE l.creator_LOGIN = '" . mysqli_real_escape_string($coni, $ins['user_login']) . "'
ORDER BY l.id DESC
";
$courses_res = mysqli_query($coni, $courses_sql);
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>

  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card mb-4">
        <div class="card-body text-center">
          <img src="<?php echo htmlspecialchars($photo); ?>" alt="Instructor Photo" width="120" height="120" class="rounded-circle border mb-3">
          <h3><?php echo htmlspecialchars($fullname); ?></h3>
          <p class="text-muted">@<?php echo htmlspecialchars($ins['user_login']); ?></p>
          <p><strong>Specialty:</strong> <?php echo $specialty; ?></p>
          <p><i class="bx bx-star text-warning"></i> <?php echo $rating; ?> (<?php echo $reviews; ?> reviews)</p>
          <?php if (!empty($ins['email'])): ?>
            <p><i class="bx bx-envelope"></i> <?php echo htmlspecialchars($ins['email']); ?></p>
          <?php endif; ?>
          <a href="instructors-list.php" class="btn btn-secondary mt-2"><i class="bx bx-arrow-back"></i> Back to List</a>
        </div>
      </div>

      <!-- Courses by Instructor -->
      <div class="card">
        <div class="card-header">
          <h5><i class="bx bx-book me-2"></i> Courses by <?php echo htmlspecialchars($fullname); ?></h5>
        </div>
        <div class="card-body">
          <?php
          if ($courses_res && mysqli_num_rows($courses_res) > 0) {
              echo '<div class="table-responsive">
                      <table class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                          <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Course Title</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Badge</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>';
              while ($c = mysqli_fetch_assoc($courses_res)) {

                  // Fix image path
                  $img = "assets/img/education/default-course.webp";
                  if (!empty($c['image'])) {
                      if (strpos($c['image'], 'uploads/') === 0) {
                          $img = "../" . $c['image'];
                      } else {
                          $img = $c['image'];
                      }
                  }

                  $price_html = "₹" . number_format($c['price'], 2);
                  if (!empty($c['discount_price']) && $c['discount_price'] > 0) {
                      $price_html = "<span class='text-muted text-decoration-line-through'>₹" . number_format($c['price'], 2) . "</span> 
                                     <strong>₹" . number_format($c['discount_price'], 2) . "</strong>";
                  }

                  echo '
                    <tr>
                      <td>' . $c['id'] . '</td>
                      <td><img src="' . htmlspecialchars($img) . '" alt="Course" width="80" height="60" class="rounded"></td>
                      <td><strong>' . htmlspecialchars($c['name']) . '</strong><br><small>' . htmlspecialchars(substr($c['info'], 0, 60)) . '...</small></td>
                      <td>' . intval($c['duration']) . ' weeks</td>
                      <td>' . $price_html . '</td>
                      <td>' . htmlspecialchars($c['badge']) . '</td>
                      <td>
                        <a href="course-details.php?course=' . $c['id'] . '" class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                      </td>
                    </tr>';
              }
              echo '</tbody></table></div>';
          } else {
              echo '<div class="alert alert-warning text-center">No courses found for this instructor.</div>';
          }
          ?>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>
