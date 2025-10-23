<?php
$page = "dashboard";
$fun  = "dashboard";

include_once('head_nav.php');
include_once('config.php'); // uses $coni

// Enable mysqli error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// ====== DASHBOARD STATS ======

// 1️⃣ Total Marketplace Courses
$totalCourses = (int) $coni->query("SELECT COUNT(*) AS c FROM course_marketplace WHERE is_active=1")->fetch_assoc()['c'];

// 2️⃣ Total Lessons
$totalLessons = (int) $coni->query("SELECT COUNT(*) AS c FROM lessons WHERE active=1")->fetch_assoc()['c'];

// 3️⃣ Total Instructors
$totalInstructors = (int) $coni->query("SELECT COUNT(*) AS c FROM instructors")->fetch_assoc()['c'];

// 4️⃣ Total Learners (Students)
$totalStudents = (int) $coni->query("SELECT COUNT(*) AS c FROM learners")->fetch_assoc()['c'];

// 5️⃣ Revenue (sum of paid courses enrolled)
$revenueQuery = $coni->query("
  SELECT IFNULL(SUM(l.price), 0) AS total
  FROM enrollments e
  JOIN lessons l ON e.course_id = l.id
");
$revenue = (float) $revenueQuery->fetch_assoc()['total'];

// 6️⃣ Enrollments Today
$todayEnrollments = (int) $coni->query("
  SELECT COUNT(*) AS c FROM enrollments 
  WHERE DATE(enrolled_at) = CURDATE()
")->fetch_assoc()['c'];

// 7️⃣ Active Students This Week
$activeStudents = (int) $coni->query("
  SELECT COUNT(DISTINCT learner_id) AS c FROM enrollments
  WHERE YEARWEEK(enrolled_at, 1) = YEARWEEK(CURDATE(), 1)
")->fetch_assoc()['c'];

// Dummy placeholders for now
$refunds = 5;
$reviews = 0; // You can replace when review table is ready
$completionRate = 68; // placeholder %
$supportTickets = 4;  // placeholder
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>

  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <!-- ===== Row 1: Summary Metrics ===== -->
      <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-book-open display-4 text-primary"></i>
              <h5>Marketplace Courses</h5>
              <h3><?= $totalCourses ?></h3>
              <small class="text-muted">Active listings</small>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-library display-4 text-success"></i>
              <h5>Lessons</h5>
              <h3><?= $totalLessons ?></h3>
              <small class="text-muted">Published content</small>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-chalkboard display-4 text-warning"></i>
              <h5>Instructors</h5>
              <h3><?= $totalInstructors ?></h3>
              <small class="text-muted">Active educators</small>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-user display-4 text-danger"></i>
              <h5>Learners</h5>
              <h3><?= $totalStudents ?></h3>
              <small class="text-muted">Registered users</small>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== Row 2: Enrollments & Revenue ===== -->
      <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-plus-circle display-4 text-info"></i>
              <h5>Enrollments Today</h5>
              <h3><?= $todayEnrollments ?></h3>
              <small class="text-muted">New signups today</small>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-rocket display-4 text-success"></i>
              <h5>Active Students</h5>
              <h3><?= $activeStudents ?></h3>
              <small class="text-muted">Active this week</small>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-wallet display-4 text-primary"></i>
              <h5>Revenue</h5>
              <h3>₹ <?= number_format($revenue, 2) ?></h3>
              <small class="text-muted">From enrollments</small>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-undo display-4 text-danger"></i>
              <h5>Refunds</h5>
              <h3><?= $refunds ?></h3>
              <small class="text-muted">Pending requests</small>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== Row 3: Engagement & Support ===== -->
      <div class="row mb-4">

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-star display-4 text-warning"></i>
              <h5>Reviews</h5>
              <h3><?= $reviews ?></h3>
              <small class="text-muted">User feedback</small>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-check-circle display-4 text-success"></i>
              <h5>Completion Rate</h5>
              <h3><?= $completionRate ?>%</h3>
              <small class="text-muted">Average progress</small>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="bx bx-message-detail display-4 text-danger"></i>
              <h5>Support Tickets</h5>
              <h3><?= $supportTickets ?></h3>
              <small class="text-muted">Open issues</small>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <?php include_once('footer.php'); ?>
</div>
