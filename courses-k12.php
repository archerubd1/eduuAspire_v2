<?php 
$page = "coursek12";
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
      <h1 class="mb-2 mb-lg-0">Courses – K-12</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">Courses K-12</li>
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

            <!-- Board -->
            <div class="filter-group">
              <h5>Board / Curriculum</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="board" value="All" checked><span class="checkmark"></span>All Boards</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="CBSE"><span class="checkmark"></span>CBSE</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="ICSE"><span class="checkmark"></span>ICSE</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Goa Board"><span class="checkmark"></span>Goa Board</label>
              </div>
            </div>

            <!-- Class -->
            <div class="filter-group">
              <h5>Class Level</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="class" value="All" checked><span class="checkmark"></span>All Classes</label>
                <label class="filter-checkbox"><input type="radio" name="class" value="Class V"><span class="checkmark"></span>Class V</label>
                <label class="filter-checkbox"><input type="radio" name="class" value="Class VI"><span class="checkmark"></span>Class VI</label>
                <label class="filter-checkbox"><input type="radio" name="class" value="Class VII"><span class="checkmark"></span>Class VII</label>
                <label class="filter-checkbox"><input type="radio" name="class" value="Class VIII"><span class="checkmark"></span>Class VIII</label>
                <label class="filter-checkbox"><input type="radio" name="class" value="Class IX"><span class="checkmark"></span>Class IX</label>
                <label class="filter-checkbox"><input type="radio" name="class" value="Class X"><span class="checkmark"></span>Class X</label>
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
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Board Prep Series"><span class="checkmark"></span>Board Prep Series</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Exams"><span class="checkmark"></span>Exams</label>
              </div>
            </div>
          </div>
        </div>

        <!-- Courses -->
        <div class="col-lg-9">
          <div class="courses-header">
            <div class="search-box">
              <i class="bi bi-search"></i>
              <input type="text" id="searchBox" placeholder="Search K-12 courses...">
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

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const filters = document.querySelectorAll(".filter-checkbox input");
  const searchBox = document.getElementById("searchBox");
  const sortOrder = document.getElementById("sortOrder");
  const container = document.getElementById("coursesContainer");

  function fetchCourses() {
    const board = document.querySelector('input[name="board"]:checked')?.value || "All";
    const classLevel = document.querySelector('input[name="class"]:checked')?.value || "All";
    const mode = document.querySelector('input[name="mode"]:checked')?.value || "All";
    const assessment = document.querySelector('input[name="assessment"]:checked')?.value || "All";
    const search = searchBox.value.trim();
    const sort = sortOrder.value;

    // Academic direction=1, Subcategory=2 (K12)
    fetch("get_courses_dynamic.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        direction: 1,
        subcategory: 2,
        board,
        class: classLevel,
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
      container.innerHTML = '<p class="text-center text-muted py-5">No courses found for selected filters.</p>';
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
              <p>${course.info ? course.info.substring(0, 120) + '...' : ''}</p>
              <div class="course-stats">
                <div class="stat"><i class="bi bi-people"></i> ${course.learners} learners</div>
                <div class="rating"><i class="bi bi-star-fill"></i>${course.rating} (${course.reviews} reviews)</div>
              </div>
              <div class="course-actions d-flex gap-2">
                <a href="course-details.php?id=${course.id}" class="btn-course">View Course Details</a>
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

  fetchCourses();
});
</script>

<?php include_once('footer.php'); ?>
