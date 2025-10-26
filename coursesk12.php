<?php 
$page = "coursek12";
include_once('head-nav.php');
include_once('config.php');
if ($coni->connect_error) die("DB Connection failed: " . $coni->connect_error);

// ===== Dynamic direction hierarchy =====
$directionId = 0;        // Academia
$subcategoryId = 0;      // K12
$subsubcategoryIds = []; // Boards under K12

$q = $coni->query("SELECT id, name, parent_direction_ID FROM directions WHERE active=1");
while ($r = $q->fetch_assoc()) {
  $name = strtolower(trim($r['name']));
  if ($name === 'academia') $directionId = (int)$r['id'];
  if ($name === 'k12' || $name === 'k-12') $subcategoryId = (int)$r['id'];
  if ((int)$r['parent_direction_ID'] === $subcategoryId) {
    $subsubcategoryIds[strtolower($r['name'])] = (int)$r['id'];
  }
}
?>

<main class="main">
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1>Courses – K-12</h1>
      <nav class="breadcrumbs"><ol><li><a href="index.php">Home</a></li><li class="current">Courses K-12</li></ol></nav>
    </div>
  </div>

  <section class="courses-2 section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">

        <!-- Sidebar Filters -->
        <div class="col-lg-3">
          <div class="course-filters shadow-sm rounded p-3" data-aos="fade-right" data-aos-delay="100">
            <h4 class="filter-title text-primary fw-bold mb-3">Filter Courses</h4>

            <!-- Board -->
            <div class="filter-group mb-3">
              <h5>Board / Curriculum</h5>
              <div class="filter-options">
                <label class="filter-checkbox">
                  <input type="radio" name="board" value="All" checked><span class="checkmark"></span>All Boards
                </label>
                <?php foreach ($subsubcategoryIds as $boardName => $boardId): ?>
                  <label class="filter-checkbox">
                    <input type="radio" name="board" value="<?= htmlspecialchars(ucwords($boardName)) ?>">
                    <span class="checkmark"></span><?= htmlspecialchars(ucwords($boardName)) ?>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Class -->
            <div class="filter-group mb-3">
              <h5>Class Level</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="class" value="All" checked><span class="checkmark"></span>All Classes</label>
                <?php for ($i = 5; $i <= 12; $i++): ?>
                  <label class="filter-checkbox"><input type="radio" name="class" value="Class <?= $i ?>"><span class="checkmark"></span>Class <?= $i ?></label>
                <?php endfor; ?>
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
                <label class="filter-checkbox"><input type="radio" name="assessment" value="All" checked><span class="checkmark"></span>All</label>
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
          <div class="courses-header d-flex justify-content-between align-items-center mb-3">
            <div class="search-box"><i class="bi bi-search"></i><input type="text" id="searchBox" placeholder="Search K-12 courses..."></div>
            <div class="sort-dropdown">
              <select id="sortOrder" class="form-select">
                <option value="popular">Most Popular</option>
                <option value="newest">Newest</option>
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
document.addEventListener("DOMContentLoaded", function(){
  const container = document.getElementById("coursesContainer");
  const filters = document.querySelectorAll(".filter-checkbox input");
  const searchBox = document.getElementById("searchBox");
  const sortOrder = document.getElementById("sortOrder");

  const direction = <?= (int)$directionId ?>;     // Academia
  const subcategory = <?= (int)$subcategoryId ?>; // K12
  const subsubMap = <?= json_encode($subsubcategoryIds) ?>; // Boards (CBSE, ICSE, Goa, etc.)

  function fetchCourses(){
    const board = document.querySelector('input[name="board"]:checked')?.value || "All";
    const classLevel = document.querySelector('input[name="class"]:checked')?.value || "All";
    const mode = document.querySelector('input[name="mode"]:checked')?.value || "All";
    const assessment = document.querySelector('input[name="assessment"]:checked')?.value || "All";
    const search = searchBox.value.trim();
    const sort = sortOrder.value;

    const subsubcategory = (board && board !== "All" && subsubMap[board.toLowerCase()]) ? subsubMap[board.toLowerCase()] : 0;

    fetch("get_courses_dynamic.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        direction,
        subcategory,
        subsubcategory,
        board,
        class: classLevel,
        mode,
        assessment,
        search,
        sort
      })
    })
    .then(r => r.json())
    .then(data => {
      console.log("K12 data:", data);
      renderCourses(data);
    })
    .catch(() => container.innerHTML = "<p class='text-center text-danger'>Error loading courses.</p>");
  }

  function renderCourses(courses){
    container.innerHTML = "";
    if(!courses || !courses.length){
      container.innerHTML = "<p class='text-center text-muted py-5'>No courses found for selected filters.</p>";
      return;
    }

    courses.forEach(c => {
      const img = c.image || "assets/img/education/default-course.webp";
      const badge = c.badge ? `<span class='course-badge'>${c.badge}</span>` : "";
      const instructor = c.instructor_name ? `
        <div class='d-flex align-items-center mt-3'>
          <img src='${c.instructor_avatar}' class='rounded-circle border me-2' width='40' height='40'>
          <small>${c.instructor_name}</small>
        </div>` : "";
      const hierarchy = `
        <div class='hierarchy-btns mt-2'>
          <button class='btn btn-outline-primary btn-sm'>${c.direction_name || ''}</button>
          <button class='btn btn-outline-secondary btn-sm'>${c.sub_direction_name || ''}</button>
          <button class='btn btn-outline-success btn-sm'>${c.board || ''}</button>
        </div>`;

      container.insertAdjacentHTML("beforeend", `
        <div class='col-lg-6 col-md-6 mb-4'>
          <div class='course-card shadow-sm'>
            <div class='course-image position-relative'>
              <img src='${img}' alt='${c.name}'>
              ${badge}
              <div class='course-mode'>${c.course_mode || ''}</div>
            </div>
            <div class='course-content p-3'>
              ${hierarchy}
              <h5 class='fw-bold mt-2'>${c.name}</h5>
              <p class='text-muted small'>${c.info?.substring(0,120) || ''}...</p>
              ${instructor}
              <div class='d-flex justify-content-between align-items-center mt-3'>
                <span class='text-success fw-bold'>₹${c.price}</span>
                <div>
                  <a href='course-details.php?id=${c.id}' class='btn btn-outline-primary btn-sm me-2'>View</a>
                  <a href='enroll.php?id=${c.id}' class='btn btn-primary btn-sm'>Enroll</a>
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
