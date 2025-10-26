<?php
$page = "instructors";
$fun  = "view";

include_once('head_nav.php');
include_once('config.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("<div class='alert alert-danger m-3'>Invalid instructor ID.</div>");
}

$id = (int)$_GET['id'];

$query = $coni->prepare("
  SELECT i.*, p.qualification, p.experience_years, p.languages_known, p.achievements, 
         p.linkedin_url, p.facebook_url, p.youtube_url, p.bio, p.location, p.office_hours, p.website
  FROM instructors i
  LEFT JOIN instructor_profiles p ON i.id = p.instructor_id
  WHERE i.id = ?
");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$ins = $result->fetch_assoc();
$query->close();

if (!$ins) {
  die("<div class='alert alert-danger m-3'>Instructor not found.</div>");
}
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5><i class="bx bx-user me-2"></i> Instructor Details</h5>
          <div>
            <a href="instructors-list.php" class="btn btn-sm btn-secondary me-2">
              <i class="bx bx-arrow-back"></i> Back
            </a>

            <a href="edit_instructor.php?id=<?php echo $ins['id']; ?>" class="btn btn-sm btn-warning me-2">
              <i class="bx bx-edit-alt"></i> Edit
            </a>

            <?php if ($ins['status'] == 'active'): ?>
              <button class="btn btn-sm btn-danger" onclick="toggleInstructorStatus(<?php echo $ins['id']; ?>)">
                <i class="bx bx-block"></i> Suspend
              </button>
            <?php else: ?>
              <button class="btn btn-sm btn-success" onclick="toggleInstructorStatus(<?php echo $ins['id']; ?>)">
                <i class="bx bx-refresh"></i> Reactivate
              </button>
            <?php endif; ?>
          </div>
        </div>

        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-3 text-center">
              <img src="<?php echo htmlspecialchars($ins['avatar']); ?>" class="rounded-circle mb-3" width="120" height="120">
              <h6><?php echo htmlspecialchars($ins['first_name'] . ' ' . $ins['last_name']); ?></h6>
              <p class="text-muted"><?php echo htmlspecialchars($ins['specialty']); ?></p>

              <?php
                if ($ins['status'] == 'active')
                  echo '<span class="badge bg-success">Active</span>';
                elseif ($ins['status'] == 'suspended')
                  echo '<span class="badge bg-danger">Suspended</span>';
                else
                  echo '<span class="badge bg-secondary">Inactive</span>';
              ?>

              <?php if ($ins['verified']): ?>
                <span class="badge bg-primary ms-1">Verified</span>
              <?php endif; ?>
            </div>

            <div class="col-md-9">
              <h6>Contact Info</h6>
              <p><strong>Email:</strong> <?php echo htmlspecialchars($ins['email']); ?></p>
              <p><strong>Mobile:</strong> <?php echo htmlspecialchars($ins['mobile']); ?></p>
              <p><strong>Location:</strong> <?php echo htmlspecialchars($ins['location']); ?></p>
              <hr>

              <h6>Professional Details</h6>
              <p><strong>Qualification:</strong> <?php echo htmlspecialchars($ins['qualification']); ?></p>
              <p><strong>Experience:</strong> <?php echo (int)$ins['experience_years']; ?> years</p>
              <p><strong>Languages:</strong> <?php echo htmlspecialchars($ins['languages_known']); ?></p>
              <p><strong>Achievements:</strong><br><?php echo nl2br(htmlspecialchars($ins['achievements'])); ?></p>
              <hr>

              <h6>Additional Info</h6>
              <p><strong>Office Hours:</strong> <?php echo htmlspecialchars($ins['office_hours']); ?></p>
              <p><strong>Bio:</strong><br><?php echo nl2br(htmlspecialchars($ins['bio'])); ?></p>
              <p><strong>Website:</strong> <a href="<?php echo htmlspecialchars($ins['website']); ?>" target="_blank"><?php echo htmlspecialchars($ins['website']); ?></a></p>
              <p><strong>LinkedIn:</strong> <a href="<?php echo htmlspecialchars($ins['linkedin_url']); ?>" target="_blank"><?php echo htmlspecialchars($ins['linkedin_url']); ?></a></p>
              <p><strong>Facebook:</strong> <a href="<?php echo htmlspecialchars($ins['facebook_url']); ?>" target="_blank"><?php echo htmlspecialchars($ins['facebook_url']); ?></a></p>
              <p><strong>YouTube:</strong> <a href="<?php echo htmlspecialchars($ins['youtube_url']); ?>" target="_blank"><?php echo htmlspecialchars($ins['youtube_url']); ?></a></p>
              <hr>

              <p><strong>Rating:</strong> <?php echo number_format($ins['rating'], 1); ?> ⭐</p>
              <p><strong>Total Students:</strong> <?php echo (int)$ins['total_students']; ?></p>
              <p><strong>Active Courses:</strong> <?php echo (int)$ins['active_courses']; ?></p>
              <p><strong>Reviews:</strong> <?php echo (int)$ins['total_reviews']; ?></p>
              <hr>

              <p class="text-muted"><strong>Last Updated:</strong>
                <?php echo htmlspecialchars($ins['last_updated']); ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>

<script>
function toggleInstructorStatus(id) {
  const confirmMsg = "Are you sure you want to change this instructor's status?";
  if (!confirm(confirmMsg)) return;

  fetch("ajax_toggle_instructor_status.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + id
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.success) location.reload();
  })
  .catch(err => alert("Error: " + err));
}
</script>
