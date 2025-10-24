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
      <h1 class="mb-2 mb-lg-0">Courses – Undergraduate Programs (UG)</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">Courses UG</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <section id="courses-ug" class="courses-2 section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">

        <!-- Filters Sidebar -->
        <div class="col-lg-3">
          <div class="course-filters" data-aos="fade-right" data-aos-delay="100">
            <h4 class="filter-title">Filter UG Courses</h4>

            <!-- Year -->
            <div class="filter-group">
              <h5>UG Year</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="year" value="All" checked><span class="checkmark"></span>All Years</label>
                <label class="filter-checkbox"><input type="radio" name="year" value="1st Year"><span class="checkmark"></span>1st Year</label>
                <label class="filter-checkbox"><input type="radio" name="year" value="2nd Year"><span class="checkmark"></span>2nd Year</label>
                <label class="filter-checkbox"><input type="radio" name="year" value="3rd Year"><span class="checkmark"></span>3rd Year</label>
              </div>
            </div>

            <!-- Program -->
            <div class="filter-group">
              <h5>Program</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="program" value="All" checked><span class="checkmark"></span>All Programs</label>
                <label class="filter-checkbox"><input type="radio" name="program" value="BCA"><span class="checkmark"></span>BCA</label>
                <label class="filter-checkbox"><input type="radio" name="program" value="BBA"><span class="checkmark"></span>BBA</label>
                <label class="filter-checkbox"><input type="radio" name="program" value="BCom"><span class="checkmark"></span>B.Com</label>
                <label class="filter-checkbox"><input type="radio" name="program" value="BA"><span class="checkmark"></span>B.A</label>
              </div>
            </div>

            <!-- Mode -->
            <div class="filter-group">
              <h5>Course Mode</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="mode" value="All" checked><span class="checkmark"></span>All Modes</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="SPL"><span class="checkmark"></span>SPL (Self-Paced)</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="ILT"><span class="checkmark"></span>ILT (Instructor-Led)</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="Hybrid"><span class="checkmark"></span>Hybrid</label>
              </div>
            </div>

            <!-- Assessment -->
            <div class="filter-group">
              <h5>Assessment Type</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="assessment" value="All" checked><span class="checkmark"></span>All Types</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Practice Tests"><span class="checkmark"></span>Practice Tests</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Monthly Assessments"><span class="checkmark"></span>Monthly Assessments</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Project"><span class="checkmark"></span>Projects</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Online Quiz"><span class="checkmark"></span>Online Quiz</label>
              </div>
            </div>
          </div>
        </div>

        <!-- Courses Grid -->
        <div class="col-lg-9">
          <div class="courses-header">
            <div class="search-box">
              <i class="bi bi-search"></i>
              <input type="text" id="searchBox" placeholder="Search UG courses...">
            </div>
            <div class="sort-dropdown">
              <select id="sortOrder">
                <option value="popular">Sort by: Most Popular</option>
                <option value="newest">Newest First</option>
                <option value="rating">Highest Rated</option>
              </select>
            </div>
          </div>

          <div class="courses-grid">
            <div class="row" id="coursesContainer">
              <div class="text-center py-5 text-muted">Loading courses...</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</main>

<style>
.subject-group {
  display:block;
  font-size:0.9rem;
  font-weight:600;
  margin-top:10px;
  padding-top:6px;
  border-top:1px solid #eee;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function(){
  const filters = document.querySelectorAll(".filter-checkbox input");
  const searchBox = document.getElementById("searchBox");
  const sortOrder = document.getElementById("sortOrder");
  const container = document.getElementById("coursesContainer");

  function fetchCourses() {
    const year = document.querySelector('input[name="year"]:checked')?.value || "All";
    const program = document.querySelector('input[name="program"]:checked')?.value || "All";
    const mode = document.querySelector('input[name="mode"]:checked')?.value || "All";
    const assessment = document.querySelector('input[name="assessment"]:checked')?.value || "All";
    const search = searchBox.value.trim();
    const sort = sortOrder.value;

    // Academic (direction=1), UG (subcategory=4)
    fetch("get_courses_dynamic.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        direction: 1,
        subcategory: 4,
        board: "UG",
        program,
        year,
        mode,
        assessment,
        search,
        sort
      })
    })
    .then(res => res.json())
    .then(data => renderCourses(data))
    .catch(() => container.innerHTML = "<p class='text-center text-danger'>Error loading courses.</p>");
  }

  function renderCourses(courses) {
    container.innerHTML = "";
    if (!courses || courses.length === 0) {
      container.innerHTML = '<p class="text-center text-muted py-5">No UG programs found for selected filters.</p>';
      return;
    }

    courses.forEach(course => {
      const card = `
        <div class="col-lg-6 col-md-6 mb-4">
          <div class="course-card">
            <div class="course-image">
              <img src="assets/img/education/courses-3.webp" alt="${course.name}" class="img-fluid">
              <div class="course-badge">${course.board}</div>
              <div class="course-mode">${course.course_mode} Mode</div>
            </div>
            <div class="course-content">
              <div class="course-meta">
                <span class="category">${course.direction_name}</span>
                <span class="level">${course.assessment_type}</span>
              </div>
              <h3>${course.name}</h3>
              <p>${course.info ? course.info.substring(0,120) + '...' : ''}</p>
              <div class="course-stats">
                <div class="stat"><i class="bi bi-people"></i> ${course.learners} learners</div>
                <div class="rating"><i class="bi bi-star-fill"></i>${course.rating} (${course.reviews} reviews)</div>
              </div>
              <div class="course-actions d-flex gap-2">
                <a href="course-details.php?id=${course.id}" class="btn-course">View Details</a>
                <a href="enroll.php?id=${course.id}" class="btn-course">Enroll Now</a>
              </div>
            </div>
          </div>
        </div>`;
      container.insertAdjacentHTML("beforeend", card);
    });
  }

  filters.forEach(f => f.addEventListener("change", fetchCourses));
  searchBox.addEventListener("keyup", () => setTimeout(fetchCourses, 500));
  sortOrder.addEventListener("change", fetchCourses);

  fetchCourses(); // Initial load
});
</script>

<?php include_once('footer.php'); ?>
