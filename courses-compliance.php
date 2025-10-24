<?php 
$page = "compliance";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) die("DB Connection failed: " . $coni->connect_error);
?>

<main class="main">

  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Corporate Compliance & Policy Training</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">Compliance & Policy Training</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- Courses Section -->
  <section id="courses-compliances" class="courses-2 section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">

        <!-- Filters -->
        <div class="col-lg-3">
          <div class="course-filters" data-aos="fade-right" data-aos-delay="100">
            <h4 class="filter-title">Filter Compliance Programs</h4>

            <!-- Sector -->
            <div class="filter-group">
              <h5>Industry Sector</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="board" value="All" checked><span class="checkmark"></span>All Industries</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Hospitality"><span class="checkmark"></span>Hospitality & Tourism</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Industrial"><span class="checkmark"></span>Industrial & Manufacturing</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Corporate"><span class="checkmark"></span>Corporate & Office</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Security"><span class="checkmark"></span>Security & Allied Services</label>
                <label class="filter-checkbox"><input type="radio" name="board" value="Retail"><span class="checkmark"></span>Retail & Customer Care</label>
              </div>
            </div>

            <!-- Compliance Type -->
            <div class="filter-group">
              <h5>Compliance Category</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="compliance" value="All" checked><span class="checkmark"></span>All Categories</label>
                <label class="filter-checkbox"><input type="radio" name="compliance" value="HR Policies"><span class="checkmark"></span>HR Policies & Ethics</label>
                <label class="filter-checkbox"><input type="radio" name="compliance" value="Safety"><span class="checkmark"></span>Workplace Safety</label>
                <label class="filter-checkbox"><input type="radio" name="compliance" value="Data Protection"><span class="checkmark"></span>Data Protection (GDPR)</label>
                <label class="filter-checkbox"><input type="radio" name="compliance" value="Environment"><span class="checkmark"></span>Environment & Sustainability</label>
                <label class="filter-checkbox"><input type="radio" name="compliance" value="Anti Harassment"><span class="checkmark"></span>Anti-Harassment & PoSH</label>
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
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Project"><span class="checkmark"></span>Practical Project</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Certification"><span class="checkmark"></span>Certification Test</label>
              </div>
            </div>

          </div>
        </div>

        <!-- Courses -->
        <div class="col-lg-9">
          <div class="courses-header d-flex justify-content-between align-items-center mb-3">
            <div class="search-box">
              <i class="bi bi-search"></i>
              <input type="text" id="searchBox" placeholder="Search compliance programs...">
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
              <div class="text-center py-5 text-muted">Loading compliance programs...</div>
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
    var subcategory = 9;  // Compliance & Policies
    var board = document.querySelector('input[name="board"]:checked') ? document.querySelector('input[name="board"]:checked').value : "All";
    var compliance = document.querySelector('input[name="compliance"]:checked') ? document.querySelector('input[name="compliance"]:checked').value : "All";
    var mode = document.querySelector('input[name="mode"]:checked') ? document.querySelector('input[name="mode"]:checked').value : "All";
    var assessment = document.querySelector('input[name="assessment"]:checked') ? document.querySelector('input[name="assessment"]:checked').value : "All";
    var search = searchBox.value.trim();
    var sort = sortOrder.value;

    console.log("➡ Fetching:", {direction: direction, subcategory: subcategory, board: board, compliance: compliance, mode: mode, assessment: assessment, search: search, sort: sort});

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
            container.innerHTML = "<p class='text-center text-danger'>Error loading compliance programs.</p>";
          }
        } else {
          container.innerHTML = "<p class='text-center text-danger'>Error loading compliance programs.</p>";
        }
      }
    };
    xhr.send(bodyData);
  }

  function renderCourses(courses){
    container.innerHTML = "";
    if(!courses || courses.length === 0){
      container.innerHTML = '<p class="text-center text-muted py-5">No compliance programs found.</p>';
      return;
    }

    for (var i=0; i<courses.length; i++) {
      var c = courses[i];
      var courseId = c.id || 0;
      var card = ''
        + '<div class="col-lg-6 col-md-6 mb-4">'
        + '  <div class="course-card border rounded-3 shadow-sm h-100">'
        + '    <div class="course-image position-relative">'
        + '      <img src="assets/img/education/courses-3.webp" alt="' + (c.name || '') + '" class="img-fluid rounded-top">'
        + '      <div class="course-badge position-absolute top-0 start-0 bg-primary text-white px-2 py-1">' + (c.board || 'Corporate') + '</div>'
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
