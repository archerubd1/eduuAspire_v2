<?php 
$page = "home";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) {
  die("DB Connection failed: " . $coni->connect_error);
}
?>

<main class="main">

  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Courses – PUC (Pre-University)</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">Courses PUC</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Courses Section -->
  <section id="courses-2" class="courses-2 section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">

        <!-- Filters -->
        <div class="col-lg-3">
          <div class="course-filters" data-aos="fade-right" data-aos-delay="100">
            <h4 class="filter-title">Filter Courses</h4>

            <!-- Year -->
            <div class="filter-group">
              <h5>PUC Year</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="year" value="All" checked><span class="checkmark"></span>All Years</label>
                <label class="filter-checkbox"><input type="radio" name="year" value="1st Year"><span class="checkmark"></span>1st Year</label>
                <label class="filter-checkbox"><input type="radio" name="year" value="2nd Year"><span class="checkmark"></span>2nd Year</label>
              </div>
            </div>

            <!-- Stream -->
            <div class="filter-group">
              <h5>Stream</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="stream" value="All" checked><span class="checkmark"></span>All Streams</label>
                <label class="filter-checkbox"><input type="radio" name="stream" value="Arts"><span class="checkmark"></span>Arts</label>
                <label class="filter-checkbox"><input type="radio" name="stream" value="Commerce"><span class="checkmark"></span>Commerce</label>
                <label class="filter-checkbox"><input type="radio" name="stream" value="Science"><span class="checkmark"></span>Science</label>
              </div>
            </div>

            <!-- Subjects -->
            <div class="filter-group">
              <h5>Subjects</h5>
              <div class="filter-options">

                <label class="filter-checkbox">
                  <input type="radio" name="subject" value="All" checked>
                  <span class="checkmark"></span>All Subjects
                </label>

                <h6 class="subject-group text-primary">Arts Stream</h6>
                <label class="filter-checkbox"><input type="radio" name="subject" value="History"><span class="checkmark"></span>History</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Political Science"><span class="checkmark"></span>Political Science</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Economics"><span class="checkmark"></span>Economics</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="English"><span class="checkmark"></span>English</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Hindi"><span class="checkmark"></span>Hindi</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Sociology"><span class="checkmark"></span>Sociology</label>

                <h6 class="subject-group text-success">Commerce Stream</h6>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Accountancy"><span class="checkmark"></span>Accountancy</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Business Studies"><span class="checkmark"></span>Business Studies</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Statistics"><span class="checkmark"></span>Statistics</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Secretarial Practice"><span class="checkmark"></span>Secretarial Practice</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Konkani"><span class="checkmark"></span>Konkani</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Kannada"><span class="checkmark"></span>Kannada</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Marathi"><span class="checkmark"></span>Marathi</label>

                <h6 class="subject-group text-danger">Science Stream</h6>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Physics"><span class="checkmark"></span>Physics</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Chemistry"><span class="checkmark"></span>Chemistry</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Mathematics"><span class="checkmark"></span>Mathematics</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Biology"><span class="checkmark"></span>Biology</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Practical Labs PCMB"><span class="checkmark"></span>Practical Labs (PCMB)</label>
                <label class="filter-checkbox"><input type="radio" name="subject" value="Science Activities"><span class="checkmark"></span>Science Activities</label>
              </div>
            </div>

            <!-- Mode -->
            <div class="filter-group">
              <h5>Course Mode</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="mode" value="All" checked><span class="checkmark"></span>All Modes</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="SPL"><span class="checkmark"></span>SPL (Self-Paced Learning)</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="ILT"><span class="checkmark"></span>ILT (Instructor-Led Training)</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="Hybrid"><span class="checkmark"></span>Hybrid (Live + Recorded)</label>
              </div>
            </div>

            <!-- Assessment -->
            <div class="filter-group">
              <h5>Assessment Type</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="assessment" value="All" checked><span class="checkmark"></span>All Types</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Practice Tests"><span class="checkmark"></span>Practice Tests</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Monthly Assessments"><span class="checkmark"></span>Monthly Assessments</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Semester Exams"><span class="checkmark"></span>Semester Exams</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Labs & Projects"><span class="checkmark"></span>Labs & Projects</label>
              </div>
            </div>
          </div>
        </div>

        <!-- Courses -->
        <div class="col-lg-9">
          <div class="courses-header" data-aos="fade-left" data-aos-delay="100">
            <div class="search-box">
              <i class="bi bi-search"></i>
              <input type="text" id="searchBox" placeholder="Search PUC courses...">
            </div>
            <div class="sort-dropdown">
              <select id="sortOrder">
                <option value="popular">Sort by: Most Popular</option>
                <option value="newest">Newest First</option>
                <option value="rating">Highest Rated</option>
              </select>
            </div>
          </div>

          <div class="courses-grid" data-aos="fade-up" data-aos-delay="200">
            <div class="row" id="coursesContainer">
              <div class="text-center py-5 text-muted">Loading courses...</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section><!-- /Courses Section -->
</main>

<style>
.subject-group {
  display: block;
  font-size: 0.9rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: 10px;
  padding-top: 6px;
  border-top: 1px solid #eee;
}
.subject-group.text-primary { color: #0d6efd; }
.subject-group.text-success { color: #198754; }
.subject-group.text-danger { color: #dc3545; }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const filters = document.querySelectorAll(".filter-checkbox input");
  const searchBox = document.getElementById("searchBox");
  const sortOrder = document.getElementById("sortOrder");
  const container = document.getElementById("coursesContainer");

  function fetchCourses() {
    const year = document.querySelector('input[name="year"]:checked')?.value || "All";
    const stream = document.querySelector('input[name="stream"]:checked')?.value || "All";
    const subject = document.querySelector('input[name="subject"]:checked')?.value || "All";
    const mode = document.querySelector('input[name="mode"]:checked')?.value || "All";
    const assessment = document.querySelector('input[name="assessment"]:checked')?.value || "All";
    const search = searchBox.value.trim().toLowerCase();
    const sort = sortOrder.value;

    fetch("get_courses_puc.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ year, stream, subject, mode, assessment, search, sort })
    })
    .then(res => res.json())
    .then(data => renderCourses(data))
    .catch(() => container.innerHTML = "<p class='text-center text-danger'>Error loading courses.</p>");
  }

  function renderCourses(courses) {
    container.innerHTML = "";
    if (!courses || courses.length === 0) {
      container.innerHTML = '<p class="text-center text-muted py-5">No courses found for selected filters.</p>';
      return;
    }

    courses.forEach(course => {
      const card = `
        <div class="col-lg-6 col-md-6 mb-4">
          <div class="course-card">
            <div class="course-image">
              <img src="assets/img/education/courses-3.webp" alt="${course.name}" class="img-fluid">
              <div class="course-badge">${course.stream}</div>
              <div class="course-mode">${course.course_mode.toUpperCase()} Mode</div>
            </div>
            <div class="course-content">
              <div class="course-meta">
                <span class="category">${course.subject}</span>
                <span class="level">${course.year}</span>
              </div>
              <h3>${course.name}</h3>
              <p>${course.info ? course.info.substring(0, 120) + '...' : ''}</p>
              <div class="course-stats">
                <div class="stat"><i class="bi bi-people"></i> ${course.learners} learners</div>
                <div class="rating"><i class="bi bi-star-fill"></i>${course.rating} (${course.reviews} reviews)</div>
              </div>
              <a href="enroll.html" class="btn-course">Join Course</a>
            </div>
          </div>
        </div>`;
      container.insertAdjacentHTML("beforeend", card);
    });
  }

  filters.forEach(f => f.addEventListener("change", fetchCourses));
  searchBox.addEventListener("keyup", () => setTimeout(fetchCourses, 500));
  sortOrder.addEventListener("change", fetchCourses);
  fetchCourses();
});
</script>

<?php include_once('footer.php'); ?>
