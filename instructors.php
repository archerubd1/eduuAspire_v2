<?php 
$page = "instructors";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) die("DB Connection failed: " . $coni->connect_error);

// Fetch instructors and their profiles
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
  ORDER BY i.rating DESC
";

$result = $coni->query($sql);
?>

<main class="main">

  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Meet Our Instructors</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li class="current">Instructors</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- Instructors Section -->
  <section id="instructors" class="instructors section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
      
      <?php 
      if ($result && $result->num_rows > 0) {
        $delay = 200;
        while ($row = $result->fetch_assoc()) {

          // Extract fields
          $id = $row['id'];
          $name = ucfirst($row['user_login']);
         // $avatar = $row['avatar'] && file_exists($row['avatar']) ? $row['avatar'] : "assets/img/education/teacher-placeholder.webp";
		 $avatarPath = 'backoffice/' . $row['avatar'];
		$avatar = !empty($row['avatar']) && file_exists($avatarPath)
		? $avatarPath
		: "assets/img/education/teacher-placeholder.webp";

          $specialty = $row['specialty'] ? $row['specialty'] : "Instructor";
          $rating = $row['rating'] ? $row['rating'] : "4.5";
          $reviews = $row['total_reviews'] ? $row['total_reviews'] : "0";
          $qualification = $row['qualification'] ? $row['qualification'] : "N/A";
          $experience = $row['experience_years'] ? $row['experience_years'] . " Years" : "Experience N/A";
          $languages = $row['languages_known'] ? $row['languages_known'] : "English";
          $achievements = $row['achievements'] ? $row['achievements'] : "";
          $bio = $row['bio'] ? substr($row['bio'], 0, 120) . '...' : "Experienced " . strtolower($specialty) . " educator passionate about skill development.";
          $linkedin = $row['linkedin_url'] ? $row['linkedin_url'] : "#";
          $facebook = $row['facebook_url'] ? $row['facebook_url'] : "#";
          $youtube = $row['youtube_url'] ? $row['youtube_url'] : "#";
      ?>

      <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
        <div class="instructor-card h-100 shadow-sm border rounded-3">
          
          <div class="instructor-image position-relative">
           <img src="<?php echo htmlspecialchars($avatar); ?>" class="img-fluid rounded-top" alt="<?php echo htmlspecialchars($name); ?>">
            <div class="overlay-content">
              <div class="rating-stars">
                <?php 
                  $starCount = floor($rating);
                  for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $starCount) echo '<i class="bi bi-star-fill"></i>';
                    elseif ($i - $rating < 1) echo '<i class="bi bi-star-half"></i>';
                    else echo '<i class="bi bi-star"></i>';
                  }
                ?>
                <span><?php echo $rating; ?></span>
              </div>
              <div class="course-count">
                <i class="bi bi-book"></i>
                <span><?php echo $reviews; ?> Reviews</span>
              </div>
            </div>
          </div>

          <div class="instructor-info p-3">
            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($name); ?></h5>
            <p class="specialty text-primary mb-2"><?php echo htmlspecialchars($specialty); ?></p>
            <p class="description small text-muted"><?php echo htmlspecialchars($bio); ?></p>

            <div class="stats-grid mt-3 mb-2 d-flex justify-content-between">
              <div class="stat text-center">
                <span class="number d-block"><?php echo htmlspecialchars($qualification); ?></span>
                <span class="label small">Qualification</span>
              </div>
              <div class="stat text-center">
                <span class="number d-block"><?php echo htmlspecialchars($experience); ?></span>
                <span class="label small">Experience</span>
              </div>
            </div>

            <?php if ($achievements) { ?>
              <p class="small text-muted mt-2"><strong>Achievements:</strong> <?php echo htmlspecialchars($achievements); ?></p>
            <?php } ?>

            <div class="action-buttons mt-3 d-flex justify-content-between align-items-center">
              <a href="instructor-profile.php?id=<?php echo $id; ?>" class="btn btn-outline-primary btn-sm">View Profile</a>
              <div class="social-links">
                <?php if ($linkedin != "#") echo '<a href="'.$linkedin.'" target="_blank"><i class="bi bi-linkedin"></i></a>'; ?>
                <?php if ($facebook != "#") echo '<a href="'.$facebook.'" target="_blank"><i class="bi bi-facebook"></i></a>'; ?>
                <?php if ($youtube != "#") echo '<a href="'.$youtube.'" target="_blank"><i class="bi bi-youtube"></i></a>'; ?>
              </div>
            </div>

          </div>
        </div>
      </div>

      <?php 
        $delay += 50;
        } // end while
      } else {
        echo '<div class="col-12 text-center text-muted py-5">No instructors found.</div>';
      }
      ?>

      </div>
    </div>
  </section>
</main>

<?php include_once('footer.php'); ?>
