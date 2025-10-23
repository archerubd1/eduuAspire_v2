<?php
$page = "courses";
$fun  = "add_course";

include_once('head_nav.php');
include_once('config.php');

// Fetch active categories
$categories = mysqli_query($coni, "SELECT id, name FROM directions WHERE active=1 ORDER BY name ASC");

// Fetch instructors
$instructors = mysqli_query($coni, "
    SELECT i.user_login, u.name, u.surname
    FROM instructors i
    LEFT JOIN users u ON u.login = i.user_login
    ORDER BY u.name ASC, u.surname ASC
");
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bx bx-plus-circle me-2"></i> Add New Marketplace Course</h5>
        </div>
        <div class="card-body">

          <div id="form-msg"></div>

          <form id="courseForm" enctype="multipart/form-data" method="post">

            <!-- Course Title -->
            <div class="mb-3">
              <label class="form-label">Course Title</label>
              <input type="text" name="title" class="form-control" required>
            </div>

            <!-- Subtitle -->
            <div class="mb-3">
              <label class="form-label">Subtitle</label>
              <input type="text" name="subtitle" class="form-control">
            </div>

            <!-- Description -->
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <!-- Duration / Price / Discount -->
            <div class="row g-3 mb-3">
              <div class="col-md-4">
                <label class="form-label">Duration (weeks)</label>
                <input type="number" name="duration" class="form-control" min="1" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Price (₹)</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Discount Price (₹)</label>
                <input type="number" step="0.01" name="discount_price" class="form-control">
              </div>
            </div>

            <!-- Badge / Category -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label">Badge</label>
                <select name="badge" class="form-select" required>
                  <option value="">Select Badge</option>
                  <option value="Featured">Featured</option>
                  <option value="New">New</option>
                  <option value="Popular">Popular</option>
                  <option value="Certificate">Certificate</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                  <option value="">Select Category</option>
                  <?php
                  if ($categories && mysqli_num_rows($categories) > 0) {
                    while ($cat = mysqli_fetch_assoc($categories)) {
                      echo '<option value="' . $cat['id'] . '">' . htmlspecialchars($cat['name']) . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <!-- Course Mode -->
            <div class="mb-3">
              <label class="form-label">Course Mode</label>
              <select name="course_mode" id="course_mode" class="form-select" required>
                <option value="">Select Mode</option>
                <option value="SPL">Self Paced Learning (SPL)</option>
                <option value="ILT">Instructor Led Training (ILT)</option>
                <option value="Hybrid">Hybrid (SPL + ILT)</option>
              </select>
            </div>

            <!-- Course Image -->
            <div class="mb-3">
              <label class="form-label">Course Image</label>
              <input type="file" name="course_image" class="form-control" accept="image/*">
              <small class="text-muted">Leave empty to use default image.</small>
            </div>

            <!-- Course Brochure -->
            <div class="mb-3">
              <label class="form-label">Course Brochure (optional)</label>
              <input type="file" name="meta_brochure" class="form-control" accept=".pdf,.doc,.docx">
              <small class="text-muted">PDF or DOCX. Will be linked on course details page.</small>
            </div>

            <!-- Instructor Details (shown for ILT/Hybrid) -->
            <div id="instructorFields" style="display: none;">
              <hr>
              <h6>Instructor Details</h6>

              <div class="mb-3">
                <label class="form-label">Select Instructor</label>
                <select name="instructor_login" class="form-select">
                  <option value="">Choose Instructor</option>
                  <?php
                  if ($instructors && mysqli_num_rows($instructors) > 0) {
                    mysqli_data_seek($instructors, 0);
                    while ($ins = mysqli_fetch_assoc($instructors)) {
                      $full_name = htmlspecialchars($ins['name'] . " " . $ins['surname']);
                      echo '<option value="' . htmlspecialchars($ins['user_login']) . '">' . $full_name . ' (' . htmlspecialchars($ins['user_login']) . ')</option>';
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Specialization</label>
                <input type="text" name="specialty" class="form-control" placeholder="Enter instructor specialty">
              </div>

              <div class="mb-3">
                <label class="form-label">Instructor Avatar (optional)</label>
                <input type="file" name="instructor_avatar" class="form-control" accept="image/*">
              </div>
            </div>

            <!-- Modules / Lessons Section (dynamic) -->
            <hr>
            <h6>Course Lessons (Modules) & Topics</h6>
            <div id="modulesContainer"></div>
            <button type="button" id="addModuleBtn" class="btn btn-outline-primary mt-2">
              <i class="bx bx-plus"></i> Add More Lessons
            </button>

            <!-- Course Metadata -->
            <hr>
            <h6>Course Metadata (for details page)</h6>

            <div class="mb-2">
              <label class="form-label">Overview</label>
              <textarea name="meta_overview" class="form-control" rows="3" placeholder="Brief overview"></textarea>
            </div>

            <div class="mb-2">
              <label class="form-label">Skills (one per line)</label>
              <textarea name="meta_skills" class="form-control" rows="3" placeholder="One skill per line"></textarea>
            </div>

            <div class="mb-2">
              <label class="form-label">Modules (simple textarea fallback)</label>
              <textarea name="meta_modules" class="form-control" rows="3" placeholder="Each module on a new line (fallback)"></textarea>
            </div>

            <div class="mb-2">
              <label class="form-label">Learning Objectives</label>
              <textarea name="meta_objectives" class="form-control" rows="3" placeholder="Learning objectives"></textarea>
            </div>

            <div class="mb-2">
              <label class="form-label">Target Audience</label>
              <textarea name="meta_audience" class="form-control" rows="2" placeholder="Who this course is for"></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">
              <i class="bx bx-check-circle me-1"></i> Save Course
            </button>

          </form>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>

<!-- JS: dynamic modules/topics and ajax submit -->
<script>
document.getElementById('course_mode').onchange = function() {
  var instructorDiv = document.getElementById('instructorFields');
  instructorDiv.style.display = (this.value === 'ILT' || this.value === 'Hybrid') ? 'block' : 'none';
};

// dynamic modules + topics builder
var moduleCount = 0;
document.getElementById('addModuleBtn').onclick = function() {
  moduleCount++;
  var container = document.getElementById('modulesContainer');
  var moduleDiv = document.createElement('div');
  moduleDiv.className = 'border rounded p-3 mb-3';
  moduleDiv.setAttribute('data-module', moduleCount);
  moduleDiv.innerHTML = ''
    + '<h6>Lesson ' + moduleCount + '</h6>'
    + '<input type="text" name="modules['+moduleCount+'][title]" class="form-control mb-2" placeholder="Lesson Title" required>'
    + '<textarea name="modules['+moduleCount+'][description]" class="form-control mb-2" rows="2" placeholder="Lesson Description"></textarea>'
    + '<div class="topicsContainer" id="topics_' + moduleCount + '"></div>'
    + '<button type="button" class="btn btn-sm btn-outline-secondary addTopicBtn" data-module="' + moduleCount + '">'
    + '<i class="bx bx-plus"></i> Add Topic</button>';
  container.appendChild(moduleDiv);
};

// add topic on click (delegated)
document.addEventListener('click', function(e) {
  var el = e.target;
  while (el && el !== document) {
    if (el.classList && el.classList.contains('addTopicBtn')) break;
    el = el.parentNode;
  }
  if (!el || el === document) return;
  var moduleIndex = el.getAttribute('data-module');
  var topicsDiv = document.getElementById('topics_' + moduleIndex);
  var count = topicsDiv.children.length + 1;
  var div = document.createElement('div');
  div.className = 'input-group mb-2';
  div.innerHTML = '<span class="input-group-text">Topic ' + count + '</span>'
    + '<input type="text" name="modules['+moduleIndex+'][topics]['+count+'][title]" class="form-control" placeholder="Topic Title" required>';
  topicsDiv.appendChild(div);
});

// AJAX submit using FormData
document.getElementById("courseForm").onsubmit = function(e) {
  e.preventDefault();
  var form = this;
  var formData = new FormData(form);
  var msgBox = document.getElementById("form-msg");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax_add_course.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      try {
        var res = JSON.parse(xhr.responseText);
        msgBox.innerHTML = '<div class="alert alert-' + (res.success ? 'success' : 'danger') + '">' + res.message + '</div>';
        if (res.success) {
          form.reset();
          document.getElementById('modulesContainer').innerHTML = '';
          document.getElementById('instructorFields').style.display = 'none';
          moduleCount = 0;
        }
      } catch (err) {
        msgBox.innerHTML = '<div class="alert alert-danger">Unexpected response from server.</div>';
      }
    }
  };
  xhr.send(formData);
};
</script>
