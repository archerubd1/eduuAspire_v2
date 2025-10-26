<?php
$page = "courses";
$fun  = "edit_metadata";
include_once('head_nav.php');
include_once('config.php');

if (!isset($_GET['course'])) {
  die("No course selected.");
}

$courseId = (int)$_GET['course'];

// --- Fetch Course Info ---
$course = mysqli_fetch_assoc(mysqli_query($coni, "SELECT name FROM lessons WHERE id=$courseId"));
if (!$course) {
  die("Invalid course ID.");
}

// --- Fetch Metadata (if exists) ---
$metaQuery = mysqli_query($coni, "SELECT * FROM course_metadata WHERE course_id=$courseId LIMIT 1");
$metadata = $metaQuery && mysqli_num_rows($metaQuery) > 0 ? mysqli_fetch_assoc($metaQuery) : [
  'overview' => '',
  'modules' => '',
  'skills' => '',
  'objectives' => '',
  'audience' => '',
  'brochure_path' => '',
  'brochure_type' => ''
];
?>

<div class="layout-page">
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bx bx-data me-2"></i>Edit Metadata – <?= htmlspecialchars($course['name']) ?></h5>
          <a href="courses-list.php" class="btn btn-sm btn-outline-secondary"><i class="bx bx-arrow-back"></i> Back</a>
        </div>

        <div class="card-body">
          <form id="editMetadataForm" enctype="multipart/form-data">
            <input type="hidden" name="course_id" value="<?= $courseId ?>">

            <div class="row g-3">
              <div class="col-md-12">
                <label class="form-label fw-bold">Course Overview</label>
                <textarea name="overview" class="form-control" rows="3"><?= htmlspecialchars($metadata['overview']) ?></textarea>
              </div>

              <div class="col-md-12">
                <label class="form-label fw-bold">Modules / Topics</label>
                <textarea name="modules" class="form-control" rows="3"><?= htmlspecialchars($metadata['modules']) ?></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Key Skills</label>
                <textarea name="skills" class="form-control" rows="2"><?= htmlspecialchars($metadata['skills']) ?></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Objectives</label>
                <textarea name="objectives" class="form-control" rows="2"><?= htmlspecialchars($metadata['objectives']) ?></textarea>
              </div>

              <div class="col-md-12">
                <label class="form-label fw-bold">Target Audience</label>
                <textarea name="audience" class="form-control" rows="2"><?= htmlspecialchars($metadata['audience']) ?></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Upload Brochure (PDF/DOC)</label>
                <input type="file" name="brochure" accept=".pdf,.doc,.docx" class="form-control" id="brochureInput">
                <small class="text-muted">Allowed formats: PDF, DOC, DOCX (max 5 MB)</small>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold d-block">Current Brochure</label>
                <?php if (!empty($metadata['brochure_path']) && file_exists("../" . $metadata['brochure_path'])): ?>
                  <a href="../<?= htmlspecialchars($metadata['brochure_path']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="bx bx-download"></i> View Brochure
                  </a>
                <?php else: ?>
                  <span class="text-muted">No brochure uploaded.</span>
                <?php endif; ?>
              </div>
            </div>

            <div class="text-end mt-4">
              <button type="submit" class="btn btn-success px-4">
                <i class="bx bx-save me-1"></i> Save Metadata
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
$('#editMetadataForm').on('submit', function(e){
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    url: 'ajax_update_metadata.php',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response){
      try {
        const res = JSON.parse(response);
        alert(res.message);
        if (res.success) {
          window.location.href = 'courses-list.php';
        }
      } catch(err) {
        alert('Error updating metadata.');
      }
    }
  });
});
</script>
