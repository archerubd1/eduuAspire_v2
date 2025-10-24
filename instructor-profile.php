<?php
include_once('config.php');

if ($coni->connect_error) die("DB Connection failed: " . $coni->connect_error);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch Instructor Details
$sql = "
  SELECT 
    i.id,
    i.user_login,
    i.avatar,
    i.specialty,
    i.rating,
    i.total_reviews,
    p.qualification,
    p.experience_years,
    p.languages_known,
    p.achievements,
    p.linkedin_url,
    p.facebook_url,
    p.youtube_url,
    p.bio
  FROM instructors i
  LEFT JOIN instructor_profiles p ON i.id = p.instructor_id
  WHERE i.id = $id
  LIMIT 1
";

$res = $coni->query($sql);
if (!$res || $res->num_rows == 0) {
  die("<h3 style='text-align:center;margin-top:80px;'>Instructor not found.</h3>");
}
$row = $res->fetch_assoc();

$name = ucfirst($row['user_login']);
//$avatar = !empty($row['avatar']) ? $row['avatar'] : "assets/img/education/teacher-placeholder.webp";
 $avatarPath = 'backoffice/' . $row['avatar'];
		$avatar = !empty($row['avatar']) && file_exists($avatarPath)
		? $avatarPath
		: "assets/img/education/teacher-placeholder.webp";
$specialty = !empty($row['specialty']) ? $row['specialty'] : "Expert Instructor";
$qualification = !empty($row['qualification']) ? $row['qualification'] : "N/A";
$experience = !empty($row['experience_years']) ? $row['experience_years'] . " Years" : "Experience N/A";
$languages = !empty($row['languages_known']) ? $row['languages_known'] : "English";
$rating = !empty($row['rating']) ? $row['rating'] : "4.5";
$total_reviews = !empty($row['total_reviews']) ? $row['total_reviews'] : "0";
$bio = !empty($row['bio']) ? $row['bio'] : "This instructor is part of our expert teaching network in Goa.";
$achievements = !empty($row['achievements']) ? $row['achievements'] : "";
$linkedin = !empty($row['linkedin_url']) ? $row['linkedin_url'] : "#";
$facebook = !empty($row['facebook_url']) ? $row['facebook_url'] : "#";
$youtube = !empty($row['youtube_url']) ? $row['youtube_url'] : "#";

// Fetch Courses
$courses = $coni->query("SELECT id, name, learners, rating, course_mode FROM lessons WHERE creator_LOGIN='" . $coni->real_escape_string($row['user_login']) . "' AND publish=1 LIMIT 3");

// Fetch Reviews
$reviews = $coni->query("SELECT reviewer_name, reviewer_role, rating, review_text FROM instructor_reviews WHERE instructor_id=$id ORDER BY id DESC LIMIT 3");
?>


<?php include_once('head-nav.php'); ?>

  <main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1>Instructor Profile</h1>
        <nav class="breadcrumbs"><ol><li><a href="index.php">Home</a></li><li class="current"><?php echo htmlspecialchars($name); ?></li></ol></nav>
      </div>
    </div>

    <section id="instructor-profile" class="instructor-profile section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-12">
            <div class="instructor-hero-banner" data-aos="zoom-out" data-aos-delay="200">
              <div class="hero-background">
                <img src="assets/img/education/showcase-4.webp" alt="Background" class="img-fluid">
                <div class="hero-overlay"></div>
              </div>
              <div class="hero-content">
                <div class="instructor-avatar">
                  <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Instructor" class="img-fluid">
                  <div class="status-badge"><i class="bi bi-patch-check-fill"></i><span>Verified</span></div>
                </div>
                <div class="instructor-info">
                  <h2><?php echo htmlspecialchars($name); ?></h2>
                  <p class="title"><?php echo htmlspecialchars($specialty); ?></p>
                  <div class="credentials">
                    <span class="credential"><?php echo htmlspecialchars($qualification); ?></span>
                    <span class="credential"><?php echo htmlspecialchars($experience); ?></span>
                    <span class="credential">Languages: <?php echo htmlspecialchars($languages); ?></span>
                  </div>
                  <div class="rating-overview">
                    <div class="stars">
                      <?php
                      $stars = floor($rating);
                      for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $stars) echo '<i class="bi bi-star-fill"></i>';
                        elseif ($i - $rating < 1) echo '<i class="bi bi-star-half"></i>';
                        else echo '<i class="bi bi-star"></i>';
                      }
                      ?>
                    </div>
                    <span class="rating-text"><?php echo $rating; ?> rating from <?php echo $total_reviews; ?> reviews</span>
                  </div>
                  <div class="contact-actions">
                    <a href="mailto:info@eduuaspire.online" class="btn-contact"><i class="bi bi-envelope"></i> Contact Instructor</a>
                    <div class="social-media">
                      <?php if ($linkedin != '#') echo '<a href="'.$linkedin.'" target="_blank"><i class="bi bi-linkedin"></i></a>'; ?>
                      <?php if ($facebook != '#') echo '<a href="'.$facebook.'" target="_blank"><i class="bi bi-facebook"></i></a>'; ?>
                      <?php if ($youtube != '#') echo '<a href="'.$youtube.'" target="_blank"><i class="bi bi-youtube"></i></a>'; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row gy-5 mt-4">
          <div class="col-lg-8">
            <div class="content-tabs" data-aos="fade-right" data-aos-delay="300">

              <ul class="nav nav-tabs custom-tabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#about"><i class="bi bi-person"></i> About</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#courses"><i class="bi bi-book"></i> Courses</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews"><i class="bi bi-star"></i> Reviews</button></li>
              </ul>

              <div class="tab-content custom-tab-content">

                <!-- About -->
                <div class="tab-pane fade show active" id="about">
                  <div class="about-content">
                    <div class="bio-section">
                      <h4>Professional Biography</h4>
                      <p><?php echo nl2br(htmlspecialchars($bio)); ?></p>
                    </div>

                    <div class="expertise-grid">
                      <h4>Core Expertise</h4>
                      <div class="skills-grid">
                        <?php
                        $skills = explode(',', $specialty);
                        foreach ($skills as $s)
                          echo '<div class="skill-item"><i class="bi bi-check-circle"></i><span>' . htmlspecialchars(trim($s)) . '</span></div>';
                        ?>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Courses -->
                <div class="tab-pane fade" id="courses">
                  <div class="courses-grid">
                    <?php
                    if ($courses && $courses->num_rows > 0) {
                      while ($c = $courses->fetch_assoc()) {
                        echo '<div class="course-item">
                                <div class="course-thumb"><img src="assets/img/education/courses-5.webp" class="img-fluid"><div class="course-level">'.htmlspecialchars($c['course_mode']).'</div></div>
                                <div class="course-info">
                                  <h5>'.htmlspecialchars($c['name']).'</h5>
                                  <div class="course-stats"><span><i class="bi bi-people"></i> '.$c['learners'].' learners</span><span><i class="bi bi-star-fill"></i> '.$c['rating'].'</span></div>
                                </div>
                              </div>';
                      }
                    } else {
                      echo '<p class="text-muted">No courses found for this instructor.</p>';
                    }
                    ?>
                  </div>
                </div>

                <!-- Reviews -->
                <div class="tab-pane fade" id="reviews">
                  <div class="reviews-container">
                    <?php
                    if ($reviews && $reviews->num_rows > 0) {
                      while ($r = $reviews->fetch_assoc()) {
                        echo '<div class="review-card">
                                <div class="review-header">
                                  <img src="assets/img/person/person-f-12.webp" class="reviewer-avatar">
                                  <div class="reviewer-info">
                                    <h6>'.htmlspecialchars($r['reviewer_name']).'</h6>
                                    <p>'.htmlspecialchars($r['reviewer_role']).'</p>
                                    <div class="review-rating">';
                        for ($i = 1; $i <= 5; $i++) {
                          if ($i <= floor($r['rating'])) echo '<i class="bi bi-star-fill"></i>';
                          elseif ($i - $r['rating'] < 1) echo '<i class="bi bi-star-half"></i>';
                          else echo '<i class="bi bi-star"></i>';
                        }
                        echo '</div></div></div><p>"'.nl2br(htmlspecialchars($r['review_text'])).'"</p></div>';
                      }
                    } else {
                      echo '<p class="text-muted">No reviews available yet.</p>';
                    }
                    ?>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="sidebar-widgets" data-aos="fade-left" data-aos-delay="300">
              <div class="stats-widget">
                <h4>Teaching Impact</h4>
                <div class="stats-grid">
                  <div class="stat-box"><div class="stat-icon"><i class="bi bi-people"></i></div><div class="stat-content"><h5><?php echo rand(500,5000); ?></h5><p>Total Students</p></div></div>
                  <div class="stat-box"><div class="stat-icon"><i class="bi bi-book"></i></div><div class="stat-content"><h5><?php echo rand(5,15); ?></h5><p>Active Courses</p></div></div>
                  <div class="stat-box"><div class="stat-icon"><i class="bi bi-award"></i></div><div class="stat-content"><h5><?php echo $rating; ?></h5><p>Average Rating</p></div></div>
                  <div class="stat-box"><div class="stat-icon"><i class="bi bi-clock"></i></div><div class="stat-content"><h5><?php echo $experience; ?></h5><p>Experience</p></div></div>
                </div>
              </div>

              <div class="achievements-widget">
                <h4>Recognition &amp; Awards</h4>
                <p><?php echo nl2br(htmlspecialchars($achievements ? $achievements : 'No awards listed yet.')); ?></p>
              </div>

              <div class="contact-widget">
                <h4>Get in Touch</h4>
                <div class="contact-info">
                  <div class="contact-item"><i class="bi bi-envelope"></i><span>info@eduuaspire.online</span></div>
                  <div class="contact-item"><i class="bi bi-geo-alt"></i><span>Goa, India</span></div>
                </div>
                <div class="office-hours">
                  <h6>Office Hours</h6>
                  <p>Mon–Fri<br>10:00 AM - 5:00 PM</p>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </section>
  </main>

<?php include_once('footer.php'); ?>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
