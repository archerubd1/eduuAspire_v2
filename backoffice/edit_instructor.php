<?php
$page = "instructors";
$fun  = "edit_ins";

include_once('head_nav.php');
include_once('config.php');

// --- Get Instructor ID ---
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("<div class='alert alert-danger'>Invalid instructor ID.</div>");
}

// --- Fetch Instructor Info ---
$sql = "
SELECT i.id, i.user_login, i.avatar, i.specialty, i.rating, i.total_reviews,
       u.name, u.surname, u.email, u.avatar AS user_avatar
FROM instructors i
LEFT JOIN users u ON u.login = i.user_login
WHERE i.id = $id
LIMIT 1
";

$res = mysqli_query($coni, $sql);
if (!$res || mysqli_num_rows($res) == 0) {
    die("<div class='alert alert-warning'>Instructor not found.</div>");
}
$row = mysqli_fetch_assoc($res);

// --- Image Fallback ---
$photo = "assets/img/person/default-avatar.webp";
if (!empty($row['avatar'])) {
    if (strpos($row['avatar'], 'uploads/') === 0) {
        $photo = "../" . $row['avatar'];
    } else {
        $photo = $row['avatar'];
    }
} elseif (!empty($row['user_avatar'])) {
    if (strpos($row['user_avatar'], 'uploads/') === 0) {
        $photo = "../" . $row['user_avatar'];
    } else {
        $photo = $row['user_avatar'];
    }
}
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card mb-4">
        <div class="card-header">
          <h5><i class="bx bx-edit me-2"></i> Edit Instructor</h5>
        </div>
        <div class="card-body">
          <div id="form-msg"></div>

          <form id="editInstructorForm" enctype="multipart/form-data" method="POST">

            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="user_login" value="<?php echo htmlspecialchars($row['user_login']); ?>">

            <div class="text-center mb-3">
              <img src="<?php echo htmlspecialchars($photo); ?>" alt="Instructor" width="100" height="100" class="rounded-circle border mb-2">
              <p class="text-muted">@<?php echo htmlspecialchars($row['user_login']); ?></p>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="surname" class="form-control" value="<?php echo htmlspecialchars($row['surname']); ?>" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Specialty</label>
                <input type="text" name="specialty" class="form-control" value="<?php echo htmlspecialchars($row['specialty']); ?>">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Change Avatar</label>
              <input type="file" name="avatar" class="form-control">
              <small class="text-muted">Leave empty to keep the current photo.</small>
            </div>

            <div class="text-center mt-3">
              <button type="submit" class="btn btn-primary px-4">
                <i class="bx bx-check-circle me-1"></i> Update Instructor
              </button>
              <a href="instructors-list.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>
          </form>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>

<script>
document.getElementById("editInstructorForm").addEventListener("submit", function(e){
    e.preventDefault();
    var formData = new FormData(this);

    fetch("ajax_update_instructor.php", {
        method: "POST",
        body: formData
    })
    .then(function(res){ return res.json(); })
    .then(function(data){
        var msgBox = document.getElementById("form-msg");
        if (data.success) {
            msgBox.innerHTML = '<div class="alert alert-success">✅ ' + data.message + '</div>';
        } else {
            msgBox.innerHTML = '<div class="alert alert-danger">❌ ' + data.message + '</div>';
        }
    })
    .catch(function(err){
        document.getElementById("form-msg").innerHTML = '<div class="alert alert-danger">⚠️ Error: ' + err + '</div>';
    });
});
</script>
