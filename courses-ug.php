<?php 
$page = "ug";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) {
  die("DB Connection failed: " . $coni->connect_error);
}

// ===== Dynamic hierarchy: Academia → UG → [Programs] =====
$directionId = 0;        // Academia
$subcategoryId = 0;      // UG
$subsubcategoryIds = []; // Programs (BBA, B.Com, etc.)

$q = $coni->query("SELECT id, name, parent_direction_ID FROM directions WHERE active=1");
while ($r = $q->fetch_assoc()) {
  $name = strtolower(trim($r['name']));
  if ($name === 'academia') $directionId = (int)$r['id'];
  if ($name === 'ug' || $name === 'undergraduate' || $name === 'undergraduate programs') {
    $subcategoryId = (int)$r['id'];
  }
  if ((int)$r['parent_direction_ID'] === $subcategoryId) {
    $subsubcategoryIds[strtolower($r['name'])] = (int)$r['id'];
  }
}
?>

<main class="main">
  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1>Courses – Undergraduate Programs (UG)</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li class="current">Courses UG</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- UG Courses Section -->
  <section class="courses-2 section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">

        <!-- Sidebar Filters -->
        <div class="col-lg-3">
          <div class="course-filters shadow-sm rounded p-3" data-aos="fade-right" data-aos-delay="100">
            <h4 class="filter-title text-primary fw-bold mb-3">Filter UG Courses</h4>

            <!-- Program -->
            <div class="filter-group mb-3">
              <h5>Program / Stream</h5>
              <div class="filter-options">
                <label class="filter-checkbox">
                  <input type="radio" name="program" value="All" checked>
                  <span class="checkmark"></span>All Programs
                </label>
                <?php foreach ($subsubcategoryIds as $programName => $programId): ?>
                  <label class="filter-checkbox">
                    <input type="radio" name="program" value="<?= htmlspecialchars(ucwords($programName)) ?>">
                    <span class="checkmark"></span><?= htmlspecialchars(ucwords($programName)) ?>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Year -->
            <div class="filter-group mb-3">
              <h5>UG Year</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="year" value="All" checked><span class="checkmark"></span>All Years</label>
                <label class="filter-checkbox"><input type="radio" name="year" value="1st Year"><span class="checkmark"></span>1st Year</label>
                <label class="filter-checkbox"><input type="radio" name="year" value="2nd Year"><span class="checkmark"></span>2nd Year</label>
                <label class="filter-checkbox"><input type="radio" name="year" value="3rd Year"><span class="checkmark"></span>3rd Year</label>
              </div>
            </div>

            <!-- Mode -->
            <div class="filter-group mb-3">
              <h5>Course Mode</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="mode" value="All" checked><span class="checkmark"></span>All Modes</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="SPL"><span class="checkmark"></span>SPL (Self-Paced)</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="ILT"><span class="checkmark"></span>ILT (Instructor-Led)</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="Hybrid"><span class="checkmark"></span>Hybrid</label>
              </div>
            </div>

            <!-- Assessment -->
            <div class="filter-group mb-3">
              <h5>Assessment Type</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="assessment" value="All" checked><span class="checkmark"></span>All Types</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Online Quiz"><span class="checkmark"></span>Online Quiz</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Project"><span class="checkmark"></span>Projects</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Exams"><span class="checkmark"></span>Exams</label>
              </div>
            </div>
          </div>
        </div>

        <!-- Courses Display -->
        <div class="col-lg-9">
          <div class="courses-header d-flex justify-content-between align-items-center mb-3">
            <div class="search-box"><i class="bi bi-search"></i><input type="text" id="searchBox" placeholder="Search UG courses..."></div>
            <div class="sort-dropdown">
              <select id="sortOrder" class="form-select">
                <option value="popular">Most Popular</option>
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

  const direction = <?= (int)$directionId ?>;     // Academia
  const subcategory = <?= (int)$subcategoryId ?>; // UG
  const subsubMap = <?= json_encode($subsubcategoryIds) ?>; // Programs (BBA, B.Com, etc.)

  function fetchCourses() {
    const program = document.querySelector('input[name="program"]:checked')?.value || "All";
    const year = document.querySelector('input[name="year"]:checked')?.value || "All";
    const mode = document.querySelector('input[name="mode"]:checked')?.value || "All";
    const assessment = document.querySelector('input[name="assessment"]:checked')?.value || "All";
    const search = searchBox.value.trim();
    const sort = sortOrder.value;

    // map program to subsubcategory ID
    const subsubcategory = (program && program !== "All" && subsubMap[program.toLowerCase()]) 
      ? subsubMap[program.toLowerCase()] 
      : 0;

    fetch("get_courses_dynamic.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        direction,
        subcategory,
        subsubcategory,
        program,
        year,
        mode,
        assessment,
        search,
        sort
      })
    })
    .then(res => res.json())
    .then(data => {
      console.log("UG data:", data);
      renderCourses(data);
    })
    .catch(() => container.innerHTML = "<p class='text-center text-danger'>Error loading courses.</p>");
  }

  function renderCourses(courses) {
    container.innerHTML = "";
    if (!courses || !courses.length) {
      container.innerHTML = '<p class="text-center text-muted py-5">No UG programs found for selected filters.</p>';
      return;
    }

    courses.forEach(c => {
      const img = c.image || "assets/img/education/courses-3.webp";
      const badge = c.badge ? `<div class='course-badge'>${c.badge}</div>` : "";
      const mode = c.course_mode ? `<div class='course-mode'>${c.course_mode}</div>` : "";
      const hierarchy = `
        <div class="hierarchy-btns mt-2">
          <button class="btn btn-outline-primary btn-sm">${c.direction_name || ''}</button>
          <button class="btn btn-outline-secondary btn-sm">${c.sub_direction_name || ''}</button>
          <button class="btn btn-outline-success btn-sm">${c.board || ''}</button>
        </div>`;

      container.insertAdjacentHTML("beforeend", `
        <div class="col-lg-6 col-md-6 mb-4">
          <div class="course-card shadow-sm">
            <div class="course-image position-relative">
              <img src="${img}" alt="${c.name}" class="img-fluid">
              ${badge}${mode}
            </div>
            <div class="course-content p-3">
              ${hierarchy}
              <h5 class="fw-bold mt-2">${c.name}</h5>
              <p class="text-muted small">${c.info ? c.info.substring(0, 120) + '...' : ''}</p>
              <div class="course-stats small text-muted">
                <i class="bi bi-people"></i> ${c.learners || 0} learners &nbsp;
                <i class="bi bi-star-fill text-warning"></i> ${c.rating || '4.5'} (${c.reviews || 0})
              </div>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="text-success fw-bold">₹${c.price}</span>
                <div>
                  <a href="course-details.php?id=${c.id}" class="btn btn-outline-primary btn-sm me-2">View</a>
                  <a href="enroll.php?id=${c.id}" class="btn btn-primary btn-sm">Enroll</a>
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
