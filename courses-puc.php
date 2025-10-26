<?php 
$page = "puc";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) {
  die("DB Connection failed: " . $coni->connect_error);
}

// ===== Dynamic hierarchy mapping =====
$directionId = 0;        // Academia
$subcategoryId = 0;      // PUC
$subsubcategoryIds = []; // Boards: CBSE, ICSE, State PUC

$q = $coni->query("SELECT id, name, parent_direction_ID FROM directions WHERE active=1");
while ($r = $q->fetch_assoc()) {
  $name = strtolower(trim($r['name']));
  if ($name === 'academia') $directionId = (int)$r['id'];
  if ($name === 'puc') $subcategoryId = (int)$r['id'];

  // Boards under PUC
  if (in_array($r['parent_direction_ID'], [$subcategoryId])) {
    $subsubcategoryIds[strtolower($r['name'])] = (int)$r['id'];
  }
}
?>

<main class="main">
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1>Courses – PUC (Pre-University)</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li class="current">Courses PUC</li>
        </ol>
      </nav>
    </div>
  </div>

  <section class="courses-2 section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">

        <!-- Sidebar Filters -->
        <div class="col-lg-3">
          <div class="course-filters shadow-sm rounded p-3" data-aos="fade-right" data-aos-delay="100">
            <h4 class="filter-title fw-bold text-primary mb-3">Filter Courses</h4>

            <!-- Curriculum / Board -->
            <div class="filter-group mb-3">
              <h5>Board / Curriculum</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="board" value="All" checked><span class="checkmark"></span>All</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="CBSE"><span class="checkmark"></span>CBSE</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="ICSE"><span class="checkmark"></span>ICSE</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="State PUC"><span class="checkmark"></span>State PUC</label>
              </div>
            </div>

            <!-- Year -->
            <div class="filter-group mb-3">
              <h5>Class Level</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="year" value="All" checked><span class="checkmark"></span>All Levels</label>
                <label class="filter-checkbox"><input type="radio" name="year" value="XI"><span class="checkmark"></span>Class XI</label>
                <label class="filter-checkbox"><input type="radio" name="year" value="XII"><span class="checkmark"></span>Class XII</label>
              </div>
            </div>

            <!-- Mode -->
            <div class="filter-group mb-3">
              <h5>Course Mode</h5>
              <label class="filter-checkbox"><input type="radio" name="mode" value="All" checked><span class="checkmark"></span>All</label>
              <label class="filter-checkbox"><input type="radio" name="mode" value="SPL"><span class="checkmark"></span>SPL (Self-Paced)</label>
              <label class="filter-checkbox"><input type="radio" name="mode" value="ILT"><span class="checkmark"></span>ILT (Instructor-Led)</label>
              <label class="filter-checkbox"><input type="radio" name="mode" value="Hybrid"><span class="checkmark"></span>Hybrid</label>
            </div>

            <!-- Assessment -->
            <div class="filter-group mb-3">
              <h5>Assessment Type</h5>
              <label class="filter-checkbox"><input type="radio" name="assessment" value="All" checked><span class="checkmark"></span>All</label>
              <label class="filter-checkbox"><input type="radio" name="assessment" value="Online Quiz"><span class="checkmark"></span>Online Quiz</label>
              <label class="filter-checkbox"><input type="radio" name="assessment" value="Project"><span class="checkmark"></span>Projects</label>
              <label class="filter-checkbox"><input type="radio" name="assessment" value="Exams"><span class="checkmark"></span>Exams</label>
            </div>
          </div>
        </div>

        <!-- Main Course Listing -->
        <div class="col-lg-9">
          <div class="courses-header d-flex justify-content-between align-items-center mb-3">
            <div class="search-box">
              <i class="bi bi-search"></i>
              <input type="text" id="searchBox" placeholder="Search PUC courses...">
            </div>
            <div class="sort-dropdown">
              <select id="sortOrder" class="form-select">
                <option value="popular">Sort by: Popular</option>
                <option value="newest">Newest</option>
                <option value="rating">Top Rated</option>
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

<script>
document.addEventListener("DOMContentLoaded", function(){
  const filters = document.querySelectorAll(".filter-checkbox input");
  const searchBox = document.getElementById("searchBox");
  const sortOrder = document.getElementById("sortOrder");
  const container = document.getElementById("coursesContainer");

  const direction = <?= (int)$directionId ?>;       // Academia
  const subcategory = <?= (int)$subcategoryId ?>;   // PUC

  const subsubMap = <?= json_encode($subsubcategoryIds) ?>; // Board sub-levels map

  function fetchCourses() {
    const board = document.querySelector('input[name="board"]:checked')?.value || "All";
    const mode = document.querySelector('input[name="mode"]:checked')?.value || "All";
    const assessment = document.querySelector('input[name="assessment"]:checked')?.value || "All";
    const year = document.querySelector('input[name="year"]:checked')?.value || "All";
    const search = searchBox.value.trim();
    const sort = sortOrder.value;

    // Decide subsubcategoryId dynamically
    const subsubcategory = (board && board !== "All" && subsubMap[board.toLowerCase()]) 
      ? subsubMap[board.toLowerCase()] 
      : 0;

    fetch("get_courses_dynamic.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        direction,
        subcategory,
        subsubcategory, // new param for 3rd level
        board,
        mode,
        assessment,
        year,
        search,
        sort
      })
    })
    .then(res => res.json())
    .then(data => {
      console.log("PUC course data:", data);
      renderCourses(data);
    })
    .catch(err => {
      console.error(err);
      container.innerHTML = "<p class='text-center text-danger'>Error loading courses.</p>";
    });
  }

  function renderCourses(courses) {
    container.innerHTML = "";
    if (!courses || !courses.length) {
      container.innerHTML = '<p class="text-center text-muted py-5">No courses found for selection.</p>';
      return;
    }

    courses.forEach(course => {
      const img = course.image || "assets/img/education/courses-3.webp";
      const badge = course.badge ? `<div class="course-badge">${course.badge}</div>` : "";
      const mode = course.course_mode ? `<div class="course-mode">${course.course_mode}</div>` : "";
      const hierarchy = `
        <div class="hierarchy-btns mt-2">
          <button class="btn btn-outline-primary btn-sm">${course.direction_name || ''}</button>
          <button class="btn btn-outline-secondary btn-sm">${course.sub_direction_name || ''}</button>
          <button class="btn btn-outline-success btn-sm">${course.board || ''}</button>
        </div>`;

      container.insertAdjacentHTML("beforeend", `
        <div class="col-lg-6 col-md-6 mb-4">
          <div class="course-card shadow-sm">
            <div class="course-image position-relative">
              <img src="${img}" alt="${course.name}" class="img-fluid">
              ${badge}${mode}
            </div>
            <div class="course-content p-3">
              ${hierarchy}
              <h5 class="fw-bold mt-2">${course.name}</h5>
              <p class="text-muted small">${course.info ? course.info.substring(0, 120) + '...' : ''}</p>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="text-success fw-bold">₹${course.price}</span>
                <div>
                  <a href="course-details.php?id=${course.id}" class="btn btn-outline-primary btn-sm me-2">View</a>
                  <a href="enroll.php?id=${course.id}" class="btn btn-primary btn-sm">Enroll</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      `);
    });
  }

  filters.forEach(f => f.addEventListener("change", fetchCourses));
  searchBox.addEventListener("keyup", () => setTimeout(fetchCourses, 400));
  sortOrder.addEventListener("change", fetchCourses);
  fetchCourses();
});
</script>

<?php include_once('footer.php'); ?>
