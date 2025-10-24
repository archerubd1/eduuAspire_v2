<?php 
$page = "professional";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) die("DB Connection failed: " . $coni->connect_error);
?>

<main class="main">

  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Corporate Professional Skills</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">Professional Skills</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- Courses Section -->
  <section id="courses-professional" class="courses-2 section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">

        <!-- Filters -->
        <div class="col-lg-3">
          <div class="course-filters" data-aos="fade-right" data-aos-delay="100">
            <h4 class="filter-title">Filter Professional Courses</h4>

            <!-- Category (mapped to board field in lessons) -->
            <div class="filter-group">
              <h5>Skill Category</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="board" value="All" checked><span class="checkmark"></span>All Skills</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Communication"><span class="checkmark"></span>Communication & Soft Skills</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Leadership"><span class="checkmark"></span>Leadership & Management</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Digital"><span class="checkmark"></span>Digital Skills</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Customer"><span class="checkmark"></span>Customer Service</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Workplace"><span class="checkmark"></span>Workplace Essentials</label>
              </div>
            </div>

            <!-- Mode -->
            <div class="filter-group">
              <h5>Course Mode</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="mode" value="All" checked><span class="checkmark"></span>All Modes</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="SPL"><span class="checkmark"></span>SPL (Self-paced)</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="ILT"><span class="checkmark"></span>ILT (Instructor-led)</label>
                <label class="filter-checkbox"><input type="radio" name="mode" value="Hybrid"><span class="checkmark"></span>Hybrid</label>
              </div>
            </div>

            <!-- Assessment -->
            <div class="filter-group">
              <h5>Assessment Type</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="assessment" value="All" checked><span class="checkmark"></span>All Types</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Online Quiz"><span class="checkmark"></span>Online Quiz</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Project"><span class="checkmark"></span>Project-Based</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Certification"><span class="checkmark"></span>Certification Test</label>
              </div>
            </div>

          </div>
        </div>

        <!-- Courses -->
        <div class="col-lg-9">
          <div class="courses-header">
            <div class="search-box">
              <i class="bi bi-search"></i>
              <input type="text" id="searchBox" placeholder="Search professional skills...">
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
              <div class="text-center py-5 text-muted">Loading professional courses...</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</main>

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", function(){
  var filters = document.querySelectorAll(".filter-checkbox input");
  var searchBox = document.getElementById("searchBox");
  var sortOrder = document.getElementById("sortOrder");
  var container = document.getElementById("coursesContainer");

  function fetchCourses(){
    var direction = 6;    // Corporate Learning
    var subcategory = 10; // Professional Skills
    var board = document.querySelector('input[name="board"]:checked') ? document.querySelector('input[name="board"]:checked').value : "All";
    var mode = document.querySelector('input[name="mode"]:checked') ? document.querySelector('input[name="mode"]:checked').value : "All";
    var assessment = document.querySelector('input[name="assessment"]:checked') ? document.querySelector('input[name="assessment"]:checked').value : "All";
    var search = searchBox.value.trim();
    var sort = sortOrder.value;

    console.log("➡ Fetching:", {direction: direction, subcategory: subcategory, board: board, mode: mode, assessment: assessment, search: search, sort: sort});

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "get_courses_dynamic.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var bodyData = "direction=" + encodeURIComponent(direction) +
                   "&subcategory=" + encodeURIComponent(subcategory) +
                   "&board=" + encodeURIComponent(board) +
                   "&mode=" + encodeURIComponent(mode) +
                   "&assessment=" + encodeURIComponent(assessment) +
                   "&search=" + encodeURIComponent(search) +
                   "&sort=" + encodeURIComponent(sort);

    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          try {
            var data = JSON.parse(xhr.responseText);
            renderCourses(data);
          } catch(e) {
            console.log("Parse error:", e, xhr.responseText);
            container.innerHTML = "<p class='text-center text-danger'>Error loading courses.</p>";
          }
        } else {
          container.innerHTML = "<p class='text-center text-danger'>Error loading courses.</p>";
        }
      }
    };
    xhr.send(bodyData);
  }

  function renderCourses(courses){
    container.innerHTML = "";
    if(!courses || courses.length === 0){
      container.innerHTML = '<p class="text-center text-muted py-5">No courses found.</p>';
      return;
    }

    for (var i=0; i<courses.length; i++) {
      var c = courses[i];
      var courseId = c.id || 0;
      var card = ''
        + '<div class="col-lg-6 col-md-6 mb-4">'
        + '  <div class="course-card border rounded-3 shadow-sm h-100">'
        + '    <div class="course-image position-relative">'
        + '      <img src="assets/img/education/courses-4.webp" alt="' + (c.name || '') + '" class="img-fluid rounded-top">'
        + '      <div class="course-badge position-absolute top-0 start-0 bg-primary text-white px-2 py-1">' + (c.board || 'Professional') + '</div>'
        + '      <div class="course-mode position-absolute bottom-0 end-0 bg-dark text-white px-2 py-1">' + (c.course_mode || 'Hybrid') + '</div>'
        + '    </div>'
        + '    <div class="course-content p-3">'
        + '      <div class="small text-muted mb-2">'
        + '        <i class="bi bi-people"></i> ' + (c.learners || 0) + ' learners &nbsp; | &nbsp; '
        + '        <i class="bi bi-star-fill"></i> ' + (c.rating || "4.5") + ' (' + (c.reviews || 0) + ' reviews)'
        + '      </div>'
        + '      <h5 class="fw-bold">' + (c.name || '') + '</h5>'
        + '      <p class="text-muted">' + ((c.info && c.info.length > 100) ? c.info.substring(0,100) + '...' : (c.info || '')) + '</p>'
        + '      <div class="mt-3 d-flex justify-content-between">'
        + '        <a href="course-details.php?id=' + courseId + '" class="btn btn-outline-primary btn-sm">View Details</a>'
        + '        <a href="enroll.php?id=' + courseId + '" class="btn btn-primary btn-sm">Enroll Now</a>'
        + '      </div>'
        + '    </div>'
        + '  </div>'
        + '</div>';
      container.insertAdjacentHTML("beforeend", card);
    }
  }

  for (var i=0; i<filters.length; i++) filters[i].addEventListener("change", fetchCourses);
  searchBox.addEventListener("keyup", function(){ setTimeout(fetchCourses, 500); });
  sortOrder.addEventListener("change", fetchCourses);

  fetchCourses(); // initial load
});
</script>

<?php include_once('footer.php'); ?>
