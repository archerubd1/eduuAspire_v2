<?php
$page = "instructors";
$fun  = "edit";

include_once('head_nav.php');
include_once('config.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("<div class='alert alert-danger m-3'>Invalid instructor ID.</div>");
}

$id = (int)$_GET['id'];

// Fetch instructor + profile data
$query = $coni->prepare("
  SELECT i.*, 
         p.qualification, p.experience_years, p.languages_known, p.achievements,
         p.linkedin_url, p.facebook_url, p.youtube_url, p.bio, p.location, p.office_hours, p.website
  FROM instructors i
  LEFT JOIN instructor_profiles p ON i.id = p.instructor_id
  WHERE i.id = ?
");
$query->bind_param("i", $id);
$query->execute();
$res = $query->get_result();
$ins = $res->fetch_assoc();
$query->close();

if (!$ins) {
  die("<div class='alert alert-danger m-3'>Instructor not found.</div>");
}
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5><i class="bx bx-edit-alt me-2"></i> Edit Instructor</h5>
          <a href="instructors-list.php" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
          </a>
        </div>

        <div class="card-body">
          <div id="form-msg"></div>

          <form id="updateInstructorForm" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($ins['id']); ?>">

            <!-- Basic Info -->
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Instructor Login</label>
                <input type="text" name="login" class="form-control"
                       value="<?php echo htmlspecialchars($ins['user_login']); ?>" required>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="name" class="form-control"
                       value="<?php echo htmlspecialchars($ins['first_name']); ?>" required>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="surname" class="form-control"
                       value="<?php echo htmlspecialchars($ins['last_name']); ?>">
              </div>
            </div>

            <!-- Contact Info -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?php echo htmlspecialchars($ins['email']); ?>" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Mobile</label>
                <input type="text" name="mobile" class="form-control"
                       value="<?php echo htmlspecialchars($ins['mobile']); ?>">
              </div>
            </div>

            <!-- Professional Details -->
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Specialty</label>
                <input type="text" name="specialty" class="form-control"
                       value="<?php echo htmlspecialchars($ins['specialty']); ?>">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Qualification</label>
                <input type="text" name="qualification" class="form-control"
                       value="<?php echo htmlspecialchars($ins['qualification']); ?>">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Experience (Years)</label>
                <input type="number" name="experience" class="form-control"
                       value="<?php echo (int)$ins['experience_years']; ?>">
              </div>
            </div>

            <!-- Additional Info -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Languages Known</label>
                <input type="text" name="languages" class="form-control"
                       value="<?php echo htmlspecialchars($ins['languages_known']); ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control"
                       value="<?php echo htmlspecialchars($ins['location']); ?>">
              </div>
            </div>

            <!-- Social Links -->
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">LinkedIn</label>
                <input type="url" name="linkedin" class="form-control"
                       value="<?php echo htmlspecialchars($ins['linkedin_url']); ?>">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Facebook</label>
                <input type="url" name="facebook" class="form-control"
                       value="<?php echo htmlspecialchars($ins['facebook_url']); ?>">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">YouTube</label>
                <input type="url" name="youtube" class="form-control"
                       value="<?php echo htmlspecialchars($ins['youtube_url']); ?>">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Website</label>
              <input type="url" name="website" class="form-control"
                     value="<?php echo htmlspecialchars($ins['website']); ?>">
            </div>

            <!-- Achievements & Bio -->
            <div class="mb-3">
              <label class="form-label">Achievements</label>
              <textarea name="achievements" class="form-control" rows="2"><?php
                echo htmlspecialchars($ins['achievements']);
              ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Bio</label>
              <textarea name="bio" class="form-control" rows="3"><?php
                echo htmlspecialchars($ins['bio']);
              ?></textarea>
            </div>

            <!-- Avatar -->
            <div class="mb-3">
              <label class="form-label">Profile Picture</label>
              <div class="mb-2">
                <img src="<?php echo htmlspecialchars($ins['avatar']); ?>" width="70" height="70" class="rounded-circle">
              </div>
              <input type="file" name="avatar" class="form-control">
            </div>

            <!-- Verified -->
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="verified" value="1" id="verifiedCheck"
                     <?php echo ($ins['verified'] ? 'checked' : ''); ?>>
              <label class="form-check-label" for="verifiedCheck">Verified Instructor</label>
            </div>

            <div class="text-center mt-3">
              <button type="submit" class="btn btn-primary px-4">
                <i class="bx bx-save me-1"></i> Update Instructor
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
document.getElementById("updateInstructorForm").addEventListener("submit", function(e){
  e.preventDefault();
  const formData = new FormData(this);

  fetch("ajax_update_instructor.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    const box = document.getElementById("form-msg");
    if (data.success) {
      box.innerHTML = '<div class="alert alert-success">✅ ' + data.message + '</div>';
    } else {
      box.innerHTML = '<div class="alert alert-danger">❌ ' + data.message + '</div>';
    }
  })
  .catch(err => {
    document.getElementById("form-msg").innerHTML =
      '<div class="alert alert-danger">⚠️ Network or server error: ' + err + '</div>';
  });
});
</script>
