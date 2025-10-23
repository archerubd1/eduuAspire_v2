<?php
$page = "instructors";
$fun  = "add_ins";

include_once('head_nav.php');
include_once('config.php');
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>

  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card mb-4">
        <div class="card-header">
          <h5><i class="bx bx-user-plus me-2"></i> Add New Instructor</h5>
        </div>
        <div class="card-body">

          <!-- Success/Error -->
          <div id="form-msg"></div>

          <!-- AJAX Form -->
          <form id="instructorForm" enctype="multipart/form-data">

            <!-- Row 1 -->
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Instructor Login</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-user"></i></span>
                  <input type="text" name="login" class="form-control" required>
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label">First Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                  <input type="text" name="name" class="form-control" required>
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label">Last Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                  <input type="text" name="surname" class="form-control" required>
                </div>
              </div>
            </div>

            <!-- Row 2 -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                  <input type="email" name="email" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Mobile</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-phone"></i></span>
                  <input type="text" name="mobile" class="form-control">
                </div>
              </div>
            </div>

            <!-- Row 3 -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Specialty</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-bulb"></i></span>
                  <input type="text" name="specialty" class="form-control" placeholder="e.g. Business, Math, AI">
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Bio</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-comment"></i></span>
                  <textarea name="bio" class="form-control" rows="1" placeholder="Brief instructor bio"></textarea>
                </div>
              </div>
            </div>

            <!-- Avatar -->
            <div class="mb-3">
              <label class="form-label">Profile Picture</label>
              <div class="input-group mb-2">
                <span class="input-group-text"><i class="bx bx-camera"></i></span>
                <input type="file" name="avatar" class="form-control">
              </div>
              <div class="input-group">
                <span class="input-group-text"><i class="bx bx-user-circle"></i></span>
                <select name="avatar_default" class="form-select">
                  <option value="">Choose Default Avatar</option>
                  <option value="assets/img/person/avatar-male.png">Male Avatar</option>
                  <option value="assets/img/person/avatar-female.png">Female Avatar</option>
                </select>
              </div>
            </div>

            <!-- Submit -->
            <div class="text-center mt-3">
              <button type="submit" class="btn btn-primary px-4">
                <i class="bx bx-check-circle me-1"></i> Save Instructor
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
document.getElementById("instructorForm").addEventListener("submit", function(e){
  e.preventDefault();
  var formData = new FormData(this);

  fetch("ajax_add_instructor.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    var msgBox = document.getElementById("form-msg");
    if (data.success) {
      msgBox.innerHTML = '<div class="alert alert-success">✅ ' + data.message + '</div>';
      document.getElementById("instructorForm").reset();
    } else {
      msgBox.innerHTML = '<div class="alert alert-danger">❌ ' + data.message + '</div>';
    }
  })
  .catch(err => {
    document.getElementById("form-msg").innerHTML = '<div class="alert alert-danger">⚠️ Error: ' + err + '</div>';
  });
});
</script>
