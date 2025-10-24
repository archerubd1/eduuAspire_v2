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
          <h5><i class="bx bx-user-plus me-2"></i> Add / Onboard New Instructor</h5>
        </div>
        <div class="card-body">

          <div id="form-msg"></div>

          <form id="instructorForm" enctype="multipart/form-data">

            <!-- Login & Basic Identity -->
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Instructor Login <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-user"></i></span>
                  <input type="text" name="login" class="form-control" required>
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                  <input type="text" name="name" class="form-control" required>
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label">Last Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                  <input type="text" name="surname" class="form-control">
                </div>
              </div>
            </div>

            <!-- Contact Info -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                  <input type="email" name="email" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Mobile</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-phone"></i></span>
                  <input type="text" name="mobile" class="form-control" placeholder="+91XXXXXXXXXX">
                </div>
              </div>
            </div>

            <!-- Professional Details -->
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Specialization</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-bulb"></i></span>
                  <input type="text" name="specialty" class="form-control" placeholder="e.g. AI, Data Science, Finance">
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label">Experience (Years)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                  <input type="number" name="experience" class="form-control" min="0" step="0.1" placeholder="e.g. 5">
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label">Qualification</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-certification"></i></span>
                  <input type="text" name="qualification" class="form-control" placeholder="e.g. M.Tech, PhD">
                </div>
              </div>
            </div>

            <!-- Languages, Social Links, Achievements -->
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Languages Known</label>
                <input type="text" name="languages" class="form-control" placeholder="English, Hindi, etc.">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Facebook Profile</label>
                <input type="url" name="facebook" class="form-control" placeholder="https://facebook.com/...">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">YouTube Channel</label>
                <input type="url" name="youtube" class="form-control" placeholder="https://youtube.com/...">
              </div>
            </div>

            <!-- Location & Office Hours -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" placeholder="City, Country">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Office Hours</label>
                <input type="text" name="office_hours" class="form-control" placeholder="Mon–Fri 9AM–5PM">
              </div>
            </div>

            <!-- Website -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">LinkedIn Profile</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bxl-linkedin"></i></span>
                  <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/...">
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Website / Portfolio</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bx bx-globe"></i></span>
                  <input type="url" name="website" class="form-control" placeholder="https://...">
                </div>
              </div>
            </div>

            <!-- Achievements -->
            <div class="mb-3">
              <label class="form-label">Achievements / Awards</label>
              <textarea name="achievements" class="form-control" rows="3" placeholder="List certifications or awards..."></textarea>
            </div>

            <!-- Bio -->
            <div class="mb-3">
              <label class="form-label">Short Bio</label>
              <textarea name="bio" class="form-control" rows="3" placeholder="Write a short professional bio..."></textarea>
            </div>

            <!-- Profile Picture -->
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

            <!-- Verified Checkbox -->
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="verified" value="1" id="verifiedCheck">
              <label class="form-check-label" for="verifiedCheck">
                Mark as Verified Instructor
              </label>
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
