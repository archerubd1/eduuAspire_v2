<?php 
$page = "coursek12";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) {
  die("DB Connection failed: " . $coni->connect_error);
}

// ✅ Dynamically fetch IDs
$directionId = 0;
$subcategoryId = 0;
$q = $coni->query("SELECT id, name, parent_direction_ID FROM directions WHERE active=1");
while ($r = $q->fetch_assoc()) {
  $name = strtolower(trim($r['name']));
  if ($name === 'academia') $directionId = (int)$r['id'];
  if ($name === 'k12' || $name === 'k-12') $subcategoryId = (int)$r['id'];
}
?>

<main class="main">
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Courses – K-12</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li class="current">Courses K-12</li>
        </ol>
      </nav>
    </div>
  </div>

  <section id="courses-2" class="courses-2 section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-3">
          <!-- Filter Sidebar (unchanged) -->
          <?php /* (retain full existing filter HTML) */ ?>
        </div>

        <div class="col-lg-9">
          <div class="courses-header d-flex justify-content-between align-items-center mb-3">
            <div class="search-box">
              <i class="bi bi-search"></i>
              <input type="text" id="searchBox" placeholder="Search K-12 courses...">
            </div>
            <div class="sort-dropdown">
              <select id="sortOrder" class="form-select">
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

<script>
document.addEventListener("DOMContentLoaded", function () {
  const filters = document.querySelectorAll(".filter-checkbox input");
  const searchBox = document.getElementById("searchBox");
  const sortOrder = document.getElementById("sortOrder");
  const container = document.getElementById("coursesContainer");

  const direction = <?= (int)$directionId ?>;
  const subcategory = <?= (int)$subcategoryId ?>;

  function fetchCourses() {
    const board = document.querySelector('input[name="board"]:checked')?.value || "All";
    const classLevel = document.querySelector('input[name="class"]:checked')?.value || "All";
    const mode = document.querySelector('input[name="mode"]:checked')?.value || "All";
    const assessment = document.querySelector('input[name="assessment"]:checked')?.value || "All";
    const search = searchBox.value.trim();
    const sort = sortOrder.value;

    fetch("get_courses_dynamic.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        direction,
        subcategory,
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
      container.innerHTML = '<p class="text-center text-muted py-5">No courses found.</p>';
      return;
    }

    courses.forEach(course => {
      const image = course.image || "assets/img/education/default-course.webp";
      const badge = course.badge ? `<span class="course-badge">${course.badge}</span>` : "";
      const instructor = course.instructor_name
        ? `<div class="d-flex align-items-center mt-3">
             <img src="${course.instructor_avatar}" class="rounded-circle border me-2" width="40" height="40">
             <small class="fw-semibold">${course.instructor_name}</small>
           </div>` : "";

      const hierarchy = `
        <div class="hierarchy-btns mt-2">
          <button class="btn btn-outline-primary btn-sm">${course.direction_name || ''}</button>
          <button class="btn btn-outline-secondary btn-sm">${course.sub_direction_name || ''}</button>
          <button class="btn btn-outline-success btn-sm">${course.board || ''}</button>
        </div>`;

      const card = `
        <div class="col-lg-6 col-md-6 mb-4">
          <div class="course-card shadow-sm">
            <div class="course-image position-relative">
              <img src="${image}" alt="${course.name}">
              ${badge}
              <div class="course-mode">${course.course_mode || ''}</div>
            </div>
            <div class="course-content p-3">
              ${hierarchy}
              <h5 class="fw-bold mt-2">${course.name}</h5>
              <p class="text-muted small">${course.info ? course.info.substring(0, 120) + '...' : ''}</p>
              ${instructor}
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="text-success fw-bold">₹${course.price}</span>
                <div>
                  <a href="course-details.php?id=${course.id}" class="btn btn-outline-primary btn-sm me-2">View</a>
                  <a href="enroll.php?id=${course.id}" class="btn btn-primary btn-sm">Enroll</a>
                </div>
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
