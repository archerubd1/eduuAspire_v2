<?php 
$page = "home";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) die("DB Connection failed: " . $coni->connect_error);
?>

<main class="main">

  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Corporate Onboarding & Skilling</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">Corporate Onboarding</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Courses Section -->
  <section id="courses-corporate" class="courses-2 section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">

        <!-- Filters -->
        <div class="col-lg-3">
          <div class="course-filters" data-aos="fade-right" data-aos-delay="100">
            <h4 class="filter-title">Filter Training Programs</h4>

            <!-- Industry Sector -->
            <div class="filter-group">
              <h5>Industry Sector</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="sector" value="All" checked><span class="checkmark"></span>All Sectors</label>
                <label class="filter-checkbox"><input type="radio" name="sector" value="Hospitality & Tourism"><span class="checkmark"></span>Hospitality & Tourism</label>
                <label class="filter-checkbox"><input type="radio" name="sector" value="Industrial & Manufacturing"><span class="checkmark"></span>Industrial & Manufacturing</label>
                <label class="filter-checkbox"><input type="radio" name="sector" value="Security & Allied Services"><span class="checkmark"></span>Security & Allied Services</label>
                <label class="filter-checkbox"><input type="radio" name="sector" value="Retail & Customer Care"><span class="checkmark"></span>Retail & Customer Care</label>
                <label class="filter-checkbox"><input type="radio" name="sector" value="Facility & Logistics"><span class="checkmark"></span>Facility & Logistics</label>
              </div>
            </div>

            <!-- Training Type -->
            <div class="filter-group">
              <h5>Training Type</h5>
              <div class="filter-options">
                <label class="filter-checkbox"><input type="radio" name="training" value="All" checked><span class="checkmark"></span>All Types</label>
                <label class="filter-checkbox"><input type="radio" name="training" value="Onboarding"><span class="checkmark"></span>Onboarding</label>
                <label class="filter-checkbox"><input type="radio" name="training" value="Safety Induction"><span class="checkmark"></span>Safety Induction</label>
                <label class="filter-checkbox"><input type="radio" name="training" value="Skill Development"><span class="checkmark"></span>Skill Development</label>
                <label class="filter-checkbox"><input type="radio" name="training" value="Supervisory"><span class="checkmark"></span>Supervisory Programs</label>
                <label class="filter-checkbox"><input type="radio" name="training" value="Customer Service"><span class="checkmark"></span>Customer Service</label>
              </div>
            </div>

            <!-- Mode -->
            <div class="filter-group">
              <h5>Delivery Mode</h5>
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
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Practical"><span class="checkmark"></span>Practical Evaluation</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Online"><span class="checkmark"></span>Online Quiz</label>
                <label class="filter-checkbox"><input type="radio" name="assessment" value="Project"><span class="checkmark"></span>On-the-job Project</label>
              </div>
            </div>

          </div><!-- End Filters -->
        </div>

        <!-- Courses -->
        <div class="col-lg-9">
          <div class="courses-header">
            <div class="search-box">
              <i class="bi bi-search"></i>
              <input type="text" id="searchBox" placeholder="Search corporate training...">
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
              <div class="text-center py-5 text-muted">Loading training programs...</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
document.addEventListener("DOMContentLoaded", function(){
  const filters=document.querySelectorAll(".filter-checkbox input");
  const searchBox=document.getElementById("searchBox");
  const sortOrder=document.getElementById("sortOrder");
  const container=document.getElementById("coursesContainer");

  function fetchCourses(){
    const sector=document.querySelector('input[name="sector"]:checked')?.value||"All";
    const training=document.querySelector('input[name="training"]:checked')?.value||"All";
    const mode=document.querySelector('input[name="mode"]:checked')?.value||"All";
    const assessment=document.querySelector('input[name="assessment"]:checked')?.value||"All";
    const search=searchBox.value.trim();
    const sort=sortOrder.value;

    fetch("get_courses_onboarding.php",{
      method:"POST",
      headers:{"Content-Type":"application/x-www-form-urlencoded"},
      body:new URLSearchParams({sector,training,mode,assessment,search,sort})
    })
    .then(res=>res.json())
    .then(data=>renderCourses(data))
    .catch(()=>container.innerHTML="<p class='text-center text-danger'>Error loading training programs.</p>");
  }

  function renderCourses(courses){
    container.innerHTML="";
    if(!courses||courses.length===0){
      container.innerHTML='<p class="text-center text-muted py-5">No programs found for selected filters.</p>';
      return;
    }
    courses.forEach(course=>{
      const card=`
        <div class="col-lg-6 col-md-6 mb-4">
          <div class="course-card">
            <div class="course-image">
              <img src="assets/img/education/courses-3.webp" alt="${course.name}" class="img-fluid">
              <div class="course-badge">${course.sector}</div>
              <div class="course-mode">${course.course_mode} Mode</div>
            </div>
            <div class="course-content">
              <div class="course-meta">
                <span class="category">${course.training_type}</span>
                <span class="level">${course.assessment_type}</span>
              </div>
              <h3>${course.name}</h3>
              <p>${course.info ? course.info.substring(0,120)+'...' : ''}</p>
              <div class="course-stats">
                <div class="stat"><i class="bi bi-people"></i> ${course.learners} learners</div>
                <div class="rating"><i class="bi bi-star-fill"></i>${course.rating} (${course.reviews} reviews)</div>
              </div>
              <a href="enroll.html" class="btn-course">Join Training</a>
            </div>
          </div>
        </div>`;
      container.insertAdjacentHTML("beforeend",card);
    });
  }

  filters.forEach(f=>f.addEventListener("change",fetchCourses));
  searchBox.addEventListener("keyup",()=>setTimeout(fetchCourses,500));
  sortOrder.addEventListener("change",fetchCourses);
  fetchCourses();
});
</script>

<?php include_once('footer.php'); ?>
