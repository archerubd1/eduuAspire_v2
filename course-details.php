<?php
$page = "course-details";
include_once('head-nav.php');
include_once('config.php');

// --- DB check ---
if (isset($coni) && $coni->connect_error) {
    die("DB Connection failed: " . $coni->connect_error);
}

// --- get course id ---
$course_id = isset($_GET['course']) ? intval($_GET['course']) : 0;
if ($course_id <= 0) {
    echo '<div class="container mt-5"><div class="alert alert-warning">Invalid course ID.</div></div>';
    include_once('footer.php');
    exit;
}

// --- Fetch course, marketplace, instructor, metadata ---
$sql = "
SELECT 
  l.id AS lesson_id,
  l.name AS title,
  l.info AS description,
  l.duration,
  l.price AS base_price,
  l.course_mode,
  cm.subtitle,
  cm.badge,
  cm.image,
  cm.discount_price,
  i.user_login,
  i.specialty,
  i.avatar,
  IFNULL(i.rating, 4.5) AS rating,
  IFNULL(i.total_reviews, 0) AS total_reviews,
  m.overview,
  m.modules,
  m.skills,
  m.objectives,
  m.audience,
  m.brochure_path
FROM lessons l
LEFT JOIN course_marketplace cm ON cm.lesson_id = l.id
LEFT JOIN instructors i ON i.user_login = l.creator_LOGIN
LEFT JOIN course_metadata m ON m.course_id = l.id
WHERE l.id = " . intval($course_id) . "
LIMIT 1
";

$res = mysqli_query($coni, $sql);
$course = ($res && mysqli_num_rows($res) > 0) ? mysqli_fetch_assoc($res) : null;

if (!$course) {
  echo '<div class="container mt-5"><div class="alert alert-danger">Course not found.</div></div>';
  include_once('footer.php');
  exit;
}

// --- variables (safe output where needed) ---
$title       = htmlspecialchars($course['title']);
$subtitle    = htmlspecialchars($course['subtitle']);
$mode        = strtoupper(trim($course['course_mode'])) ?: 'SPL';
$badge       = htmlspecialchars($course['badge']);
$image       = !empty($course['image']) ? $course['image'] : 'assets/img/education/default-course.webp';
$price       = floatval($course['base_price']);
$discount    = floatval($course['discount_price']);
$final_price = ($discount > 0 && $discount < $price) ? $discount : $price;
$rating      = number_format(floatval($course['rating']), 1);
$reviews     = intval($course['total_reviews']);
$brochure    = !empty($course['brochure_path']) ? $course['brochure_path'] : null;

// --- Prepare overview, skills, objectives, audience ---
$overview = trim($course['overview']) ? trim($course['overview']) : trim($course['description']);
$skills = array();
if (trim($course['skills']) != '') {
    $lines = preg_split("/\r\n|\n|\r/", trim($course['skills']));
    foreach ($lines as $l) {
        $l = trim($l);
        if ($l != '') $skills[] = $l;
    }
}
$objectives = trim($course['objectives']);
$audience = trim($course['audience']);

// --- Fetch modules and topics from modules & content tables (module = lesson, content = topics) ---
$lessons = array();
$mod_q = "SELECT id, module_title, module_description FROM modules WHERE course_id = " . intval($course_id) . " ORDER BY module_order ASC, id ASC";
$mod_r = mysqli_query($coni, $mod_q);
if ($mod_r && mysqli_num_rows($mod_r) > 0) {
    while ($mod = mysqli_fetch_assoc($mod_r)) {
        $module_id = intval($mod['id']);
        $module_title = $mod['module_title'];
        $module_desc = $mod['module_description'];

        $topics = array();
        $topic_q = "SELECT id, topic_title, topic_description FROM content WHERE module_id = " . $module_id . " ORDER BY topic_order ASC, id ASC";
        $topic_r = mysqli_query($coni, $topic_q);
        if ($topic_r && mysqli_num_rows($topic_r) > 0) {
            while ($t = mysqli_fetch_assoc($topic_r)) {
                $topics[] = array(
                    'title' => $t['topic_title'],
                    'description' => $t['topic_description']
                );
            }
        }

        $lessons[] = array(
            'title' => $module_title,
            'description' => $module_desc,
            'topics' => $topics
        );
    }
}
?>

<!-- ===== Page markup (keeps your original layout & structure) ===== -->
<main class="main">

  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0"><?php echo $title; ?></h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li class="current">Course Details</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Course Details Section -->
  <section id="course-details" class="course-details section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row">
        <div class="col-lg-8">

          <!-- Course Hero -->
          <div class="course-hero" data-aos="fade-up" data-aos-delay="200">
            <div class="hero-content">
              <div class="course-badge">
                <?php if ($badge): ?><span class="category"><?php echo $badge; ?></span><?php endif; ?>
                <span class="level"><?php echo htmlspecialchars($course['specialty'] ? $course['specialty'] : $mode); ?></span>
              </div>
              <h1><?php echo $title; ?></h1>
              <?php if ($subtitle): ?><p class="course-subtitle"><?php echo $subtitle; ?></p><?php endif; ?>

              <?php if ($mode == 'SPL'): ?>
                <div class="alert alert-info p-3 mb-3">
                  <i class="bi bi-clock-history me-2"></i><strong>Self-Paced Learning:</strong>
                  Learn anytime, anywhere, at your own pace.
                </div>
              <?php else: ?>
                <div class="instructor-card d-flex align-items-center bg-light rounded-3 p-3 mb-4 shadow-sm">
                  <img src="<?php echo htmlspecialchars($course['avatar'] ?: 'assets/img/person/default-avatar.webp'); ?>" class="rounded-circle me-3" width="70" height="70" alt="Instructor">
                  <div>
                    <h5 class="mb-1"><?php echo htmlspecialchars($course['user_login'] ?: 'Instructor'); ?></h5>
                    <small class="text-muted d-block mb-1"><?php echo htmlspecialchars($course['specialty']); ?></small>
                    <div class="text-warning small">
                      <?php
                        $full = floor($course['rating']);
                        for ($i=0; $i<$full; $i++) echo '<i class="bi bi-star-fill"></i>';
                        if ($course['rating'] - $full >= 0.5) echo '<i class="bi bi-star-half"></i>';
                      ?>
                      <span class="text-muted">(<?php echo $rating; ?> / <?php echo $reviews; ?> reviews)</span>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

            </div>

            <div class="hero-image">
              <img src="<?php echo htmlspecialchars($image); ?>" alt="Course Preview" class="img-fluid">
              <div class="play-overlay">
                <button class="play-btn">
                  <i class="bi bi-play-fill"></i>
                </button>
                <span>Watch Preview</span>
              </div>
            </div>
          </div><!-- End Course Hero -->

          <!-- Course Navigation Tabs -->
          <div class="course-nav-tabs" data-aos="fade-up" data-aos-delay="300">
            <ul class="nav nav-tabs" id="course-detailsCourseTab" role="tablist">
              <li class="nav-item">
                <button class="nav-link active" id="course-detailsoverview-tab" data-bs-toggle="tab" data-bs-target="#course-detailsoverview" type="button" role="tab">
                  <i class="bi bi-layout-text-window-reverse"></i>
                  Overview
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="course-detailscurriculum-tab" data-bs-toggle="tab" data-bs-target="#course-detailscurriculum" type="button" role="tab">
                  <i class="bi bi-list-ul"></i>
                  Curriculum
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="course-detailsreviews-tab" data-bs-toggle="tab" data-bs-target="#course-detailsreviews" type="button" role="tab">
                  <i class="bi bi-star"></i>
                  Reviews
                </button>
              </li>
            </ul>

            <div class="tab-content" id="course-detailsCourseTabContent">

              <!-- Overview Tab -->
              <div class="tab-pane fade show active" id="course-detailsoverview" role="tabpanel">

                <div class="overview-section">
                  <h3>Course Description</h3>
                  <p><?php echo nl2br(htmlspecialchars($overview)); ?></p>
                </div>

                <?php if (!empty($skills)): ?>
                <div class="skills-grid">
                  <h3>Skills You'll Gain</h3>
                  <div class="row">
                    <?php
                      // split skills into two roughly equal columns
                      $chunks = array_chunk($skills, ceil(count($skills)/2));
                      foreach ($chunks as $chunk) {
                        echo '<div class="col-md-6">';
                        foreach ($chunk as $sk) {
                          echo '<div class="skill-item mb-3 d-flex">';
                          echo '<div class="skill-icon me-3"><i class="bi bi-check2"></i></div>';
                          echo '<div class="skill-content"><h5 class="mb-0">'.htmlspecialchars($sk).'</h5></div>';
                          echo '</div>';
                        }
                        echo '</div>';
                      }
                    ?>
                  </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($objectives)): ?>
                <div class="mt-4">
                  <h3>Learning Objectives</h3>
                  <p><?php echo nl2br(htmlspecialchars($objectives)); ?></p>
                </div>
                <?php endif; ?>

                <?php if (!empty($audience)): ?>
                <div class="mt-4">
                  <h3>Target Audience</h3>
                  <p><?php echo nl2br(htmlspecialchars($audience)); ?></p>
                </div>
                <?php endif; ?>

              </div><!-- End Overview Tab -->

              <!-- Curriculum Tab -->
              <div class="tab-pane fade" id="course-detailscurriculum" role="tabpanel">

                <div class="curriculum-overview">
                  <div class="curriculum-stats">
                    <div class="stat"><i class="bi bi-collection-play"></i><span><?php echo count($lessons); ?> Sections</span></div>
                    <?php
                      $lectureCount = 0;
                      foreach ($lessons as $L) $lectureCount += max(0, count($L['topics']));
                    ?>
                    <div class="stat"><i class="bi bi-play-circle"></i><span><?php echo $lectureCount; ?> Lectures</span></div>
                    <div class="stat"><i class="bi bi-clock"></i><span><?php echo htmlspecialchars($course['duration']); ?> hours</span></div>
                  </div>
                </div>

                <div class="accordion" id="curriculumAccordion">
                  <?php
                  if (empty($lessons)) {
                      echo '<p>No curriculum available.</p>';
                  } else {
                      $idx = 1;
                      foreach ($lessons as $lesson) {
                          $firstOpen = ($idx === 1) ? 'show' : '';
                          $collapsed = ($idx === 1) ? '' : 'collapsed';
                          echo '<div class="accordion-item curriculum-module">';
                          echo '<h2 class="accordion-header">';
                          echo '<button class="accordion-button '.$collapsed.'" type="button" data-bs-toggle="collapse" data-bs-target="#module'.$idx.'">';
                          echo '<div class="module-info">';
                          echo '<span class="module-title">'.htmlspecialchars($lesson['title']).'</span>';
                          $topicCount = count($lesson['topics']);
                          echo '<span class="module-meta">'.$topicCount.' lessons • N/A</span>';
                          echo '</div>';
                          echo '</button>';
                          echo '</h2>';
                          echo '<div id="module'.$idx.'" class="accordion-collapse collapse '.$firstOpen.'" data-bs-parent="#curriculumAccordion">';
                          echo '<div class="accordion-body">';
                          if (!empty($lesson['description'])) {
                              echo '<p class="mb-3">'.htmlspecialchars($lesson['description']).'</p>';
                          }
                          if (!empty($lesson['topics'])) {
                              echo '<div class="lessons-list">';
                              foreach ($lesson['topics'] as $t) {
                                  echo '<div class="lesson d-flex justify-content-between align-items-center mb-2">';
                                  echo '<div><i class="bi bi-play-circle me-2"></i><span class="lesson-title">'.htmlspecialchars($t['title']).'</span></div>';
                                  echo '<div class="lesson-time text-muted">—</div>';
                                  echo '</div>';
                              }
                              echo '</div>';
                          } else {
                              echo '<p class="text-muted">No topics listed for this module.</p>';
                          }
                          echo '</div></div></div>';
                          $idx++;
                      }
                  }
                  ?>
                </div>

              </div><!-- End Curriculum Tab -->

              <!-- Reviews Tab -->
              <div class="tab-pane fade" id="course-detailsreviews" role="tabpanel">

                <div class="reviews-summary">
                  <div class="rating-overview">
                    <div class="overall-rating">
                      <div class="rating-number"><?php echo $rating; ?></div>
                      <div class="rating-stars">
                        <?php
                          $rfull = floor($rating);
                          for ($s=0;$s<$rfull;$s++) echo '<i class="bi bi-star-fill"></i>';
                          if ($rating - $rfull >= 0.5) echo '<i class="bi bi-star-half"></i>';
                        ?>
                      </div>
                      <div class="rating-text"><?php echo number_format($reviews); ?> reviews</div>
                    </div>
                  </div>
                </div>

                <div class="reviews-list">
                  <p>No reviews yet. Be the first to share your learning experience!</p>
                </div>

              </div><!-- End Reviews Tab -->

            </div>
          </div><!-- End Course Navigation Tabs -->

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">

          <!-- Enrollment Card -->
          <div class="enrollment-card" data-aos="fade-up" data-aos-delay="200">

            <div class="card-header">
              <div class="price-display">
                <span class="current-price">₹<?php echo number_format($final_price, 2); ?></span>
                <?php if ($discount > 0 && $discount < $price): ?>
                  <span class="original-price">₹<?php echo number_format($price, 2); ?></span>
                  <span class="discount"><?php echo round((($price - $discount)/$price)*100); ?>% OFF</span>
                <?php endif; ?>
              </div>
              <div class="enrollment-count">
                <i class="bi bi-people"></i>
                <span><?php echo rand(1000, 5000); ?> students enrolled</span>
              </div>
            </div>

            <div class="card-body">
              <div class="course-highlights">
                <div class="highlight-item"><i class="bi bi-trophy"></i><span>Certificate included</span></div>
                <div class="highlight-item"><i class="bi bi-clock-history"></i><span><?php echo htmlspecialchars($course['duration']); ?> hours content</span></div>
                <div class="highlight-item"><i class="bi bi-download"></i><span>Downloadable resources</span></div>
                <div class="highlight-item"><i class="bi bi-infinity"></i><span>Lifetime access</span></div>
                <div class="highlight-item"><i class="bi bi-phone"></i><span>Mobile access</span></div>
              </div>

              <div class="action-buttons mt-3">
                <button class="btn btn-primary w-100 mb-2">Enroll Now</button>

                <!-- Download Brochure replaces Add to Wishlist -->
                <?php if ($brochure): ?>
                  <a href="<?php echo htmlspecialchars($brochure); ?>" class="btn btn-outline-secondary w-100" download>
                    <i class="bi bi-file-earmark-arrow-down me-1"></i> Download Brochure
                  </a>
                <?php else: ?>
                  <button class="btn btn-outline-secondary w-100" disabled>
                    <i class="bi bi-file-earmark-arrow-down me-1"></i> Brochure not available
                  </button>
                <?php endif; ?>
              </div>

              <div class="guarantee mt-3">
                <i class="bi bi-shield-check"></i>
                <span>30-day money-back guarantee</span>
              </div>
			  
			  
			  
			   <!-- Course Details -->
          <div class="course-details-card mt-4" data-aos="fade-up" data-aos-delay="300">
            <h4>Course Details</h4>

            <div class="detail-grid">
              <div class="detail-row">
                <span class="detail-label">Duration</span>
                <span class="detail-value"><?php echo htmlspecialchars($course['duration']); ?> hrs</span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Mode</span>
                <span class="detail-value"><?php echo htmlspecialchars($mode); ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Skill Level</span>
                <span class="detail-value"><?php echo htmlspecialchars($course['specialty'] ?: 'All levels'); ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Language</span>
                <span class="detail-value">English</span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Quizzes</span>
                <span class="detail-value">—</span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Assignments</span>
                <span class="detail-value">—</span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Updated</span>
                <span class="detail-value"><?php echo date("F Y"); ?></span>
              </div>
            </div>
          </div><!-- End Course Details -->

          <!-- Share Course -->
          <div class="share-course-card mt-4" data-aos="fade-up" data-aos-delay="400">
            <h4>Share This Course</h4>
            <div class="social-links">
              <a href="#" class="social-link facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="social-link twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="social-link linkedin"><i class="bi bi-linkedin"></i></a>
              <a href="#" class="social-link email"><i class="bi bi-envelope"></i></a>
            </div>
          </div><!-- End Share Course -->
		  
		  
            </div>

          </div><!-- End Enrollment Card -->

         

        </div><!-- End Right Column -->

      </div>

    </div>

  </section><!-- /Course Details Section -->

</main>

<?php include_once('footer.php'); ?>
