<?php
$page = "instructors";
$fun  = "all_ins";
include_once('head_nav.php');
include_once('config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch instructor + user details
$sql = "
  SELECT i.*, u.login, u.name AS firstname, u.surname AS lastname, u.email
  FROM instructors i
  LEFT JOIN users u ON u.login = i.user_login
  WHERE i.id=$id
  LIMIT 1
";
$res = $coni->query($sql);

if (!$res || $res->num_rows == 0) {
    die("<div class='container p-5'><div class='alert alert-danger'>Instructor not found.</div></div>");
}
$row = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $specialty = $coni->real_escape_string($_POST['specialty']);
    $bio       = $coni->real_escape_string($_POST['bio']);
    $avatar    = $row['avatar'];

    // Avatar upload
    if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = dirname(__DIR__) . "/uploads/instructors/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $filename = time() . "_" . basename($_FILES['avatar']['name']);
        $target   = $upload_dir . $filename;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
            $avatar = "uploads/instructors/" . $filename;
        }
    }

    $coni->query("UPDATE instructors SET specialty='$specialty', bio='$bio', avatar='$avatar' WHERE id=$id");

    header("Location: instructors-list.php?msg=success&text=" . urlencode("Instructor updated successfully"));
    exit;
}
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card mb-4">
        <div class="card-header"><h5><i class="bx bx-edit"></i> Edit Instructor</h5></div>
        <div class="card-body">
          <form action="" method="post" enctype="multipart/form-data">

            <!-- Read-only user info -->
            <div class="mb-3">
              <label class="form-label">Login</label>
              <input type="text" class="form-control" value="<?= htmlspecialchars($row['login']) ?>" readonly>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($row['firstname']) ?>" readonly>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($row['lastname']) ?>" readonly>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="text" class="form-control" value="<?= htmlspecialchars($row['email']) ?>" readonly>
            </div>

            <hr>

            <!-- Editable fields -->
            <div class="mb-3">
              <label class="form-label">Specialty</label>
              <input type="text" name="specialty" class="form-control" value="<?= htmlspecialchars($row['specialty']) ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Bio</label>
              <textarea name="bio" class="form-control" rows="4"><?= htmlspecialchars($row['bio']) ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Avatar</label><br>
              <img src="../<?= htmlspecialchars($row['avatar'] ? $row['avatar'] : 'assets/img/person/default-avatar.webp') ?>" 
                   width="100" class="rounded mb-2"><br>
              <input type="file" name="avatar" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Save Changes</button>
            <a href="instructors-list.php" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>
