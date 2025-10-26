<?php
$page = "courses";
$fun  = "add_course";

include_once('head_nav.php');
include_once('config.php');

if (!$coni) die("DB connection failed");

// Fetch categories (top-level)
$categories = mysqli_query($coni, "SELECT id, name FROM directions WHERE direction_type='Category' AND active=1 ORDER BY name ASC");

// Fetch instructors
$instructors = mysqli_query($coni, "SELECT user_login, first_name, last_name FROM instructors ORDER BY first_name ASC");
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>

  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bx bx-plus-circle me-2"></i> Add New Course</h5>
        </div>

        <div class="card-body">
          <div id="form-msg"></div>

          <form id="courseForm" enctype="multipart/form-data">

            <!-- Course Title -->
            <div class="mb-3">
              <label class="form-label">Course Title</label>
              <input type="text" name="title" class="form-control" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
              <label class="form-label">Course Description</label>
              <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>

            <!-- Category / Subcategory -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="direction_id" id="direction_id" class="form-select" required>
                  <option value="">Select Category</option>
                  <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Subcategory</label>
                <select name="sub_direction_id" id="sub_direction_id" class="form-select" required>
                  <option value="">Select Subcategory</option>
                </select>
              </div>
            </div>

            <!-- Board / Mode / Assessment -->
            <div class="row g-3 mb-3">
              <div class="col-md-4">
                <label class="form-label">Board / Curriculum</label>
                <input type="text" name="board" class="form-control" placeholder="CBSE, ICSE, Goa Board...">
              </div>
              <div class="col-md-4">
                <label class="form-label">Course Mode</label>
                <select name="course_mode" id="course_mode" class="form-select" required>
                  <option value="">Select Mode</option>
                  <option value="SPL">Self-Paced Learning</option>
                  <option value="ILT">Instructor-Led Training</option>
                  <option value="Hybrid">Hybrid</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Assessment Type</label>
                <input type="text" name="assessment_type" class="form-control" placeholder="Practice Tests, Board Prep, etc.">
              </div>
            </div>

            <!-- Duration / Price / Rating -->
            <div class="row g-3 mb-3">
              <div class="col-md-3">
                <label class="form-label">Duration (hours)</label>
                <input type="number" name="duration" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Price (₹)</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Rating (0–5)</label>
                <input type="number" step="0.1" name="rating" class="form-control" value="4.5">
              </div>
              <div class="col-md-3">
                <label class="form-label">Learners</label>
                <input type="number" name="learners" class="form-control" value="0">
              </div>
            </div>

            <!-- Instructor Section (conditional) -->
            <div id="instructorSection" style="display:none;">
              <hr>
              <h6>Instructor Details</h6>
              <div class="mb-3">
                <label class="form-label">Instructor</label>
                <select name="creator_LOGIN" class="form-select">
                  <option value="">Select Instructor</option>
                  <?php while($ins = mysqli_fetch_assoc($instructors)): ?>
                    <option value="<?php echo htmlspecialchars($ins['user_login']); ?>">
                      <?php echo htmlspecialchars($ins['first_name'].' '.$ins['last_name']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
              <label class="form-label">Course Image</label>
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <!-- Active Toggle -->
            <div class="form-check mb-3">
              <input type="checkbox" class="form-check-input" name="active" id="active" value="1" checked>
              <label class="form-check-label" for="active">Active</label>
            </div>

            <button type="submit" class="btn btn-primary">
              <i class="bx bx-save"></i> Save Course
            </button>

          </form>
        </div>
      </div>
    </div>

    <?php include_once('footer.php'); ?>
  </div>
</div>

<script>
// Load subcategories dynamically
document.getElementById('direction_id').addEventListener('change', function() {
  var catID = this.value;
  var subSelect = document.getElementById('sub_direction_id');
  subSelect.innerHTML = '<option value="">Loading...</option>';
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_subcategories.php?parent_id=' + catID, true);
  xhr.onload = function() {
    if (xhr.status === 200) subSelect.innerHTML = xhr.responseText;
    else subSelect.innerHTML = '<option value="">Error loading</option>';
  };
  xhr.send();
});

// Show instructor section for ILT/Hybrid
document.getElementById('course_mode').addEventListener('change', function() {
  var section = document.getElementById('instructorSection');
  section.style.display = (this.value === 'ILT' || this.value === 'Hybrid') ? 'block' : 'none';
});

// AJAX submit
document.getElementById('courseForm').addEventListener('submit', function(e) {
  e.preventDefault();
  var formData = new FormData(this);
  var msgBox = document.getElementById('form-msg');
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'ajax_add_course.php', true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      try {
        var res = JSON.parse(xhr.responseText);
        msgBox.innerHTML = '<div class="alert alert-' + (res.success ? 'success' : 'danger') + '">' + res.message + '</div>';
        if (res.success) document.getElementById('courseForm').reset();
      } catch (err) {
        msgBox.innerHTML = '<div class="alert alert-danger">Unexpected error.</div>';
      }
    }
  };
  xhr.send(formData);
});
</script>
