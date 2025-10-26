<?php
$page = "courses";
$fun  = "add_course";
include_once('head_nav.php');
include_once('config.php');

// Fetch top-level categories for initial select (optional)
// We still load children via ajax_get_children.php but keep top-level for faster display.
$categories = $coni->query("
  SELECT id, name 
  FROM directions 
  WHERE parent_direction_ID IS NULL AND active=1 
  ORDER BY name ASC
");

// Fetch instructors
$instructors = $coni->query("
  SELECT user_login, CONCAT(first_name, ' ', last_name) AS fullname, avatar
  FROM instructors
  ORDER BY first_name ASC
");
?>
<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-success text-white">
          <h5 class="mb-0"><i class="bx bx-book-add me-2"></i> Add New Course</h5>
        </div>

        <div class="card-body">
          <div id="form-msg"></div>
          <form id="courseForm" enctype="multipart/form-data" method="post">
<p><br></p>
            <!-- Badge + Hierarchy -->
            <div class="row g-3 mb-3">
              <div class="col-md-3">
                <label class="form-label">
                  <i class="bx bx-purchase-tag-alt text-primary me-1"></i> Badge
                </label>
                <select name="badge" class="form-select" required>
                  <option value="">Select</option>
                  <option value="Featured">Featured</option>
                  <option value="New">New</option>
                  <option value="Popular">Popular</option>
                  <option value="Certificate">Certificate</option>
                </select>
              </div>

              <div class="col-md-9">
                <label class="form-label">
                  <i class="bx bx-sitemap text-primary me-1"></i> Select Course Classification & Offerings Hierarchy
                </label>

                <!-- Static selects to be filled dynamically via ajax_get_children.php -->
                <div class="row g-2">
                  <div class="col-md-3">
                    <select id="categorySelect" class="form-select">
                      <option value="">Category</option>
                      <?php if ($categories && $categories->num_rows > 0): ?>
                        <?php while($c = $categories->fetch_assoc()): ?>
                          <option value="<?= htmlspecialchars($c['id']) ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endwhile; ?>
                      <?php endif; ?>
                    </select>
                  </div>

                  <div class="col-md-3">
                    <select id="subcategorySelect" class="form-select">
                      <option value="">Subcategory</option>
                    </select>
                  </div>

                  <div class="col-md-3">
                    <select id="boardSelect" class="form-select">
                      <option value="">Board / Program </option>
                    </select>
                  </div>

                  <div class="col-md-3">
                    <select id="classSelect" name="direction_id" class="form-select">
                      <option value="">Class / Level</option>
                    </select>
                  </div>
                </div>

              </div>
            </div>

            <!-- Hidden hierarchy fields expected by backend -->
            <input type="hidden" name="parent_direction_id" id="hiddenParent" value="">
            <input type="hidden" name="subcategory_id" id="hiddenSub" value="">
            <input type="hidden" name="board_name" id="hiddenBoard" value="">
            <input type="hidden" name="sub_direction_id" id="hiddenClass" value="">

            <!-- Course Image -->
            <div class="mb-3">
              <label class="form-label"><i class="bx bx-image-alt text-primary me-1"></i> Course Image</label>
              <input type="file" name="course_image" class="form-control" accept="image/*">
            </div>

            <!-- Basic Info -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label"><i class="bx bx-book-content text-primary me-1"></i> Course Title</label>
                <input type="text" name="title" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label"><i class="bx bx-highlight text-primary me-1"></i> Subtitle / USP</label>
                <input type="text" name="subtitle" class="form-control">
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-3">
                <label class="form-label"><i class="bx bx-time-five text-primary me-1"></i> Duration (weeks)</label>
                <input type="number" name="duration" class="form-control" min="1" required>
              </div>
              <div class="col-md-3">
                <label class="form-label"><i class="bx bx-rupee text-primary me-1"></i> Price (₹)</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label"><i class="bx bx-discount text-primary me-1"></i> Discount Price (₹)</label>
                <input type="number" step="0.01" name="discount_price" class="form-control">
              </div>
              <div class="col-md-3">
                <label class="form-label"><i class="bx bx-chalkboard text-primary me-1"></i> Course Mode</label>
                <select name="course_mode" id="course_mode" class="form-select" required>
                  <option value="">Select</option>
                  <option value="SPL">Self Paced</option>
                  <option value="ILT">Instructor Led</option>
                  <option value="Hybrid">Hybrid</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label"><i class="bx bx-detail text-primary me-1"></i> Description</label>
              <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>

            <!-- Instructor -->
            <div id="instructorFields" style="display:none;">
              <hr>
              <h6><i class="bx bx-user-voice text-primary me-2"></i> Instructor Details</h6>
              <div class="row mb-3 align-items-center">
                <div class="col-md-4">
                  <label class="form-label"><i class="bx bx-user text-primary me-1"></i> Select Instructor</label>
                  <select name="instructor_login" id="instructorSelect" class="form-select">
                    <option value="">Select Instructor</option>
                    <?php if ($instructors && $instructors->num_rows > 0): ?>
                      <?php while($i = $instructors->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($i['user_login']) ?>" data-avatar="<?= htmlspecialchars($i['avatar'] ?: 'assets/img/avatars/default.png') ?>">
                          <?= htmlspecialchars($i['fullname']) ?>
                        </option>
                      <?php endwhile; ?>
                    <?php endif; ?>
                  </select>
                </div>
                <div class="col-md-4 text-center">
                  <img id="instructorAvatar" src="assets/img/avatars/default.png" class="rounded-circle border" style="width:80px;height:80px;display:none;">
                  <p id="instructorName" class="mt-2 fw-semibold"></p>
                </div>
                <div class="col-md-4">
                  <label class="form-label"><i class="bx bx-user-pin text-primary me-1"></i> Specialization</label>
                  <input type="text" name="specialty" class="form-control" placeholder="Instructor specialty">
                </div>
              </div>
            </div>

            <!-- Lessons & Topics (kept same) -->
            <hr>
            <h6><i class="bx bx-layer text-primary me-2"></i> Lessons & Topics</h6>
            <div id="modulesContainer"></div>
            <button type="button" id="addModuleBtn" class="btn btn-outline-primary mt-2">
              <i class="bx bx-plus-circle"></i> Add Lesson
            </button>

            <!-- Brochure & Metadata -->
            <hr>
            <div class="mb-3">
              <label class="form-label"><i class="bx bx-file text-primary me-1"></i> Brochure (Optional)</label>
              <input type="file" name="meta_brochure" class="form-control" accept=".pdf,.doc,.docx">
            </div>

            <h6><i class="bx bx-info-circle text-primary me-2"></i> Additional Info</h6>
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label"><i class="bx bx-notepad text-primary me-1"></i> Overview</label>
                <textarea name="meta_overview" class="form-control" rows="2"></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label"><i class="bx bx-bulb text-primary me-1"></i> Skills</label>
                <textarea name="meta_skills" class="form-control" rows="2"></textarea>
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label"><i class="bx bx-target-lock text-primary me-1"></i> Objectives</label>
                <textarea name="meta_objectives" class="form-control" rows="2"></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label"><i class="bx bx-group text-primary me-1"></i> Target Audience</label>
                <textarea name="meta_audience" class="form-control" rows="2"></textarea>
              </div>
            </div>

            <div class="text-center mt-4">
              <button type="submit" class="btn btn-success px-4">
                <i class="bx bx-check-circle me-2"></i> Save Course
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>

<script>
// ===== Utility to call ajax_get_children.php and fill a <select> =====
function loadChildrenAjax(parentId, targetSelect, clearNext) {
  targetSelect.innerHTML = '<option value="">Loading...</option>';
  // clear next if provided
  if (clearNext) clearNext.innerHTML = '<option value="">Select next</option>';

  var url = 'ajax_get_children.php?parent_id=' + encodeURIComponent(parentId);
  fetch(url)
    .then(function(res){ return res.json(); })
    .then(function(data){
      targetSelect.innerHTML = '<option value="">Select</option>';
      if (!data || data.length === 0) {
        targetSelect.innerHTML = '<option value="">No options</option>';
        return;
      }
      data.forEach(function(item){
        var opt = document.createElement('option');
        opt.value = item.id;
        opt.text = item.name;
        targetSelect.appendChild(opt);
      });
    })
    .catch(function(err){
      targetSelect.innerHTML = '<option value="">Error</option>';
      console.error('loadChildrenAjax error:', err);
    });
}

// DOM references
var catSel = document.getElementById('categorySelect');
var subSel = document.getElementById('subcategorySelect');
var boardSel = document.getElementById('boardSelect');
var clsSel = document.getElementById('classSelect');

var hiddenParent = document.getElementById('hiddenParent');
var hiddenSub = document.getElementById('hiddenSub');
var hiddenBoard = document.getElementById('hiddenBoard');
var hiddenClass = document.getElementById('hiddenClass');

// When category changes: set parent, clear downstream, load subcategories
catSel.addEventListener('change', function(){
  hiddenParent.value = this.value || '';
  hiddenSub.value = '';
  hiddenBoard.value = '';
  hiddenClass.value = '';
  subSel.innerHTML = '<option value="">Subcategory</option>';
  boardSel.innerHTML = '<option value="">Board / Program</option>';
  clsSel.innerHTML = '<option value="">Class / Level</option>';
  if (this.value) loadChildrenAjax(this.value, subSel, boardSel);
});

// When subcategory changes: set sub, clear downstream, load boards/programs
subSel.addEventListener('change', function(){
  hiddenSub.value = this.value || '';
  hiddenBoard.value = '';
  hiddenClass.value = '';
  boardSel.innerHTML = '<option value="">Board / Program</option>';
  clsSel.innerHTML = '<option value="">Class / Level</option>';
  if (this.value) loadChildrenAjax(this.value, boardSel, clsSel);
});

// When board/program changes: set board name (text) and load classes
boardSel.addEventListener('change', function(){
  var selectedText = this.options[this.selectedIndex] ? this.options[this.selectedIndex].text : '';
  hiddenBoard.value = selectedText || '';
  hiddenClass.value = '';
  clsSel.innerHTML = '<option value="">Class / Level</option>';
  if (this.value) loadChildrenAjax(this.value, clsSel, null);
});

// When class changes: set final class id
clsSel.addEventListener('change', function(){
  hiddenClass.value = this.value || '';
  // Also set the visible final class select value (name is sent as `direction_id` because earlier code uses that)
});

// Instructor avatar preview
var instructorSelect = document.getElementById('instructorSelect');
if (instructorSelect) {
  instructorSelect.addEventListener('change', function(e){
    var opt = this.selectedOptions[0];
    var avatar = opt ? opt.getAttribute('data-avatar') : '';
    var img = document.getElementById('instructorAvatar');
    var name = document.getElementById('instructorName');
    if (opt && this.value) {
      img.src = avatar ? avatar : 'assets/img/avatars/default.png';
      img.style.display = 'inline-block';
      name.textContent = opt.textContent.trim();
    } else {
      img.style.display = 'none';
      name.textContent = '';
    }
  });
}

// Course mode toggles instructor block
var cm = document.getElementById('course_mode');
if (cm) {
  cm.addEventListener('change', function(){
    document.getElementById('instructorFields').style.display = (this.value === 'ILT' || this.value === 'Hybrid') ? 'block' : 'none';
  });
}

// Modules/Topics (same behaviour you already had)
var moduleCount = 0;
document.getElementById('addModuleBtn').addEventListener('click', function(){
  moduleCount++;
  var c = document.getElementById('modulesContainer');
  var m = document.createElement('div');
  m.className = 'border rounded p-3 mb-3';
  m.innerHTML = '<h6><i class="bx bx-book-content text-primary"></i> Lesson '+moduleCount+'</h6>'
    + '<input type="text" name="modules['+moduleCount+'][title]" class="form-control mb-2" placeholder="Lesson title" required>'
    + '<textarea name="modules['+moduleCount+'][description]" class="form-control mb-2" rows="2" placeholder="Lesson description"></textarea>'
    + '<div id="topics_'+moduleCount+'"></div>'
    + '<button type="button" class="btn btn-sm btn-outline-secondary addTopicBtn" data-module="'+moduleCount+'"><i class="bx bx-plus"></i> Add Topic</button>';
  c.appendChild(m);
});
document.addEventListener('click', function(e){
  if (e.target.classList && e.target.classList.contains('addTopicBtn')) {
    var i = e.target.getAttribute('data-module');
    var t = document.getElementById('topics_'+i);
    var count = t.children.length + 1;
    var div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = '<span class="input-group-text">Topic '+count+'</span>'
      + '<input type="text" name="modules['+i+'][topics]['+count+'][title]" class="form-control" placeholder="Topic title" required>';
    t.appendChild(div);
  }
});

// AJAX submit (FormData automatically includes hidden fields)
document.getElementById('courseForm').addEventListener('submit', function(e){
  e.preventDefault();
  var fd = new FormData(this);
  fetch('ajax_add_course.php', { method: 'POST', body: fd })
    .then(function(r){ return r.json(); })
    .then(function(res){
      document.getElementById('form-msg').innerHTML = '<div class="alert alert-'+(res.success ? 'success' : 'danger')+'">'+res.message+'</div>';
      if (res.success) document.getElementById('courseForm').reset();
    })
    .catch(function(err){
      document.getElementById('form-msg').innerHTML = '<div class="alert alert-danger">Error: '+ err +'</div>';
      console.error('submit error', err);
    });
});
</script>
