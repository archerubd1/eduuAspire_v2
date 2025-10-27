<?php
$page = "marketplace";
$fun  = "market_dashboard";
include_once('head_nav.php');
include_once('config.php');

// ---- Fetch metrics ---- //
$totalCourses = 0;
$totalInstructors = 0;
$totalEnrollments = 0;
$totalRevenue = 0;
$avgRating = 0;

// Active courses
$q1 = mysqli_query($coni, "SELECT COUNT(*) AS cnt FROM course_marketplace WHERE is_active=1");
if ($q1) { $r = mysqli_fetch_assoc($q1); $totalCourses = (int)$r['cnt']; }

// Instructors
$q2 = mysqli_query($coni, "SELECT COUNT(*) AS cnt FROM instructors WHERE active=1");
if ($q2) { $r = mysqli_fetch_assoc($q2); $totalInstructors = (int)$r['cnt']; }

// Enrollments
$q3 = mysqli_query($coni, "SELECT COUNT(*) AS cnt FROM users_to_lessons WHERE user_type='student'");
if ($q3) { $r = mysqli_fetch_assoc($q3); $totalEnrollments = (int)$r['cnt']; }

// Revenue
$q4 = mysqli_query($coni, "
  SELECT SUM(
    CASE WHEN cm.discount_price > 0 THEN cm.discount_price ELSE cm.price END
  ) AS total
  FROM course_marketplace cm
  JOIN users_to_lessons u ON u.lessons_id = cm.lesson_id
");
if ($q4) { $r = mysqli_fetch_assoc($q4); $totalRevenue = (float)$r['total']; }

// Average rating
$q5 = mysqli_query($coni, "SELECT ROUND(AVG(rating),1) AS avg_rating FROM marketplace_reviews WHERE status='approved'");
if ($q5) { $r = mysqli_fetch_assoc($q5); $avgRating = $r['avg_rating'] ? $r['avg_rating'] : 0; }

// Top courses
$topCourses = mysqli_query($coni, "
  SELECT l.name, COUNT(u.id) AS learners
  FROM users_to_lessons u
  JOIN lessons l ON u.lessons_id = l.id
  GROUP BY u.lessons_id
  ORDER BY learners DESC
  LIMIT 5
");

// Top instructors
$topInstructors = mysqli_query($coni, "
  SELECT CONCAT(i.first_name,' ',i.last_name) AS name, COUNT(l.id) AS courses
  FROM instructors i
  JOIN lessons l ON l.creator_login = i.user_login
  GROUP BY i.id
  ORDER BY courses DESC
  LIMIT 5
");
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="bx bx-store-alt me-2"></i>EduuAspire Marketplace Dashboard</h4>
        <a href="marketplace-courses.php" class="btn btn-primary"><i class="bx bx-book"></i> Manage Courses</a>
      </div>

      <!-- KPI Cards -->
      <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-3">
          <div class="card shadow-sm border-primary text-center">
            <div class="card-body">
              <i class="bx bx-book-open text-primary fs-2"></i>
              <h5 class="mt-2 mb-1"><?php echo $totalCourses; ?></h5>
              <p class="text-muted small mb-0">Active Marketplace Courses</p>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="card shadow-sm border-success text-center">
            <div class="card-body">
              <i class="bx bx-user-voice text-success fs-2"></i>
              <h5 class="mt-2 mb-1"><?php echo $totalInstructors; ?></h5>
              <p class="text-muted small mb-0">Active Instructors</p>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="card shadow-sm border-info text-center">
            <div class="card-body">
              <i class="bx bx-group text-info fs-2"></i>
              <h5 class="mt-2 mb-1"><?php echo $totalEnrollments; ?></h5>
              <p class="text-muted small mb-0">Total Enrollments</p>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="card shadow-sm border-warning text-center">
            <div class="card-body">
              <i class="bx bx-rupee text-warning fs-2"></i>
              <h5 class="mt-2 mb-1">₹<?php echo number_format($totalRevenue,2); ?></h5>
              <p class="text-muted small mb-0">Estimated Revenue</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Ratings and Chart -->
      <div class="row g-4 mb-4">
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body text-center">
              <h6 class="mb-3"><i class="bx bx-star text-warning me-2"></i>Average Course Rating</h6>
              <h2 class="text-warning"><?php echo $avgRating ? $avgRating.' ★' : '—'; ?></h2>
              <p class="text-muted small">Based on approved marketplace reviews</p>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h6 class="mb-3"><i class="bx bx-line-chart text-info me-2"></i>Enrollment Growth</h6>
              <canvas id="enrollmentChart" height="100"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Top Performers -->
      <div class="row g-4">
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h6 class="mb-3"><i class="bx bx-trophy text-primary me-2"></i>Top 5 Courses by Enrollments</h6>
              <ul class="list-group">
                <?php
                if ($topCourses && mysqli_num_rows($topCourses) > 0) {
                  while ($t = mysqli_fetch_assoc($topCourses)) {
                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">'
                      . htmlspecialchars($t['name'])
                      . '<span class="badge bg-primary rounded-pill">' . $t['learners'] . ' learners</span></li>';
                  }
                } else {
                  echo '<li class="list-group-item text-muted">No enrollment data available.</li>';
                }
                ?>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h6 class="mb-3"><i class="bx bx-user-circle text-success me-2"></i>Top 5 Instructors by Courses</h6>
              <ul class="list-group">
                <?php
                if ($topInstructors && mysqli_num_rows($topInstructors) > 0) {
                  while ($i = mysqli_fetch_assoc($topInstructors)) {
                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">'
                      . htmlspecialchars($i['name'])
                      . '<span class="badge bg-success rounded-pill">' . $i['courses'] . ' courses</span></li>';
                  }
                } else {
                  echo '<li class="list-group-item text-muted">No instructor data available.</li>';
                }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('enrollmentChart').getContext('2d');
var enrollmentChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Apr','May','Jun','Jul','Aug','Sep','Oct'],
    datasets: [{
      label: 'Enrollments',
      data: [10,20,25,35,45,55,70], // static placeholder
      borderColor: '#0dcaf0',
      borderWidth: 2,
      fill: true,
      backgroundColor: 'rgba(13,202,240,0.1)',
      tension: 0.4
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      y: { beginAtZero: true },
      x: { grid: { display: false } }
    }
  }
});
</script>
