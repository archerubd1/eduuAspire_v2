<?php
$page = "courses";
$fun  = "edit_course";
include_once('head_nav.php');
include_once('config.php');

if (!isset($_GET['edit'])) {
  die("No course selected.");
}
$courseId = (int)$_GET['edit'];

// --- Fetch course details ---
$sql = "
SELECT l.*, cm.image AS marketplace_image 
FROM lessons l
LEFT JOIN course_marketplace cm ON cm.lesson_id = l.id
WHERE l.id = $courseId LIMIT 1";
$res = mysqli_query($coni, $sql);
if (!$res || mysqli_num_rows($res) == 0) {
  die("Course not found.");
}
$course = mysqli_fetch_assoc($res);

// --- Fetch ENUM options for assessment_type ---
$assessmentOptions = [];
$enumQuery = mysqli_query($coni, "SHOW COLUMNS FROM lessons LIKE 'assessment_type'");
if ($enumQuery && mysqli_num_rows($enumQuery) > 0) {
  $enumRow = mysqli_fetch_assoc($enumQuery);
  if (preg_match("/^enum\\('(.*)'\\)$/", $enumRow['Type'], $matches)) {
    $assessmentOptions = explode("','", $matches[1]);
  }
}
?>

<div class="layout-page">
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bx bx-edit me-2"></i>Edit Course</h5>
          <a href="courses.php" class="btn btn-sm btn-outline-secondary"><i class="bx bx-arrow-back"></i> Back</a>
        </div>

        <div class="card-body">
          <form id="editCourseForm" enctype="multipart/form-data">
            <input type="hidden" name="course_id" value="<?= $courseId ?>">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold">Course Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($course['name']) ?>" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Board</label>
                <input type="text" name="board" value="<?= htmlspecialchars($course['board']) ?>" class="form-control">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Course Mode</label>
                <select name="course_mode" class="form-select">
                  <option value="ILT" <?= $course['course_mode']=='ILT'?'selected':'' ?>>ILT (Instructor-Led)</option>
                  <option value="SPL" <?= $course['course_mode']=='SPL'?'selected':'' ?>>SPL (Self-Paced)</option>
                  <option value="Hybrid" <?= $course['course_mode']=='Hybrid'?'selected':'' ?>>Hybrid</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Assessment Type</label>
                <select name="assessment_type" class="form-select">
                  <option value="">-- Select Assessment Type --</option>
                  <?php foreach ($assessmentOptions as $opt): ?>
                    <option value="<?= htmlspecialchars($opt) ?>" <?= ($opt == $course['assessment_type']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($opt) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Price (₹)</label>
                <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($course['price']) ?>" class="form-control">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Duration (weeks)</label>
                <input type="text" name="duration" value="<?= htmlspecialchars($course['duration']) ?>" class="form-control">
              </div>

              <div class="col-md-12">
                <label class="form-label fw-bold">Course Info / Description</label>
                <textarea name="info" rows="4" class="form-control"><?= htmlspecialchars($course['info']) ?></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Course Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-control" id="thumbnailInput">
                <small class="text-muted">Allowed: JPG, PNG, WEBP (max 2MB)</small>
              </div>

              <div class="col-md-6 text-center">
                <label class="form-label fw-bold d-block">Current Thumbnail</label>
                <?php 
                  $img = !empty($course['marketplace_image']) && file_exists($course['marketplace_image'])
                    ? $course['marketplace_image']
                    : 'assets/img/education/courses-3.webp';
                ?>
                <img src="../<?= htmlspecialchars($img) ?>" alt="Course Image" id="thumbPreview" class="rounded border" style="max-width:180px; max-height:120px;">
              </div>
            </div>

            <div class="text-end mt-4">
              <button type="submit" class="btn btn-success px-4"><i class="bx bx-save me-1"></i> Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>

<script>
document.getElementById('thumbnailInput').addEventListener('change', function(e){
  const [file] = e.target.files;
  if (file) document.getElementById('thumbPreview').src = URL.createObjectURL(file);
});

$('#editCourseForm').on('submit', function(e){
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    url: 'ajax_update_course.php',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response){
      try {
        const res = JSON.parse(response);
        alert(res.message);
        if (res.success) window.location.href = 'courses-list.php';
      } catch(err){
        alert('Error updating course.');
      }
    }
  });
});
</script>
